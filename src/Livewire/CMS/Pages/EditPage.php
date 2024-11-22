<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Pages;

use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Lianmaymesi\LaravelCms\Models\Page;
use Lianmaymesi\LaravelCms\Models\Section;
use Lianmaymesi\LaravelCms\Livewire\BaseComponent;
use Lianmaymesi\LaravelCms\Livewire\Forms\PageForm;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

#[Layout('components.marketing.layouts.admin')]
class EditPage extends BaseComponent
{
    use WithFileUploads;

    public Page $page;
    public PageForm $form;

    public $page_title = 'Edit Page';

    public $sections_data = [];
    public $original_data = [];
    public $language;

    public function mount(Page $page)
    {
        $this->page = $page;
        $this->language = app()->getLocale();
        $this->form->setPage($page);
        $sections_data = $page->sections->mapToGroups(function ($section, $key) {
            return [
                $section->pivot->id => $this->extractData($section->pivot->data, $this->language)
            ];
        })->map(function ($items) {
            return $items->reduce(function ($carry, $item) {
                return $item;
            }, []);
        });

        $this->sections_data = $sections_data;

        $this->original_data = $page->sections->mapToGroups(function ($section, $key) {
            return [
                $section->pivot->id => $section->pivot->data
            ];
        })->map(function ($items) {
            return $items->reduce(function ($carry, $item) {
                return $item;
            }, []);
        })->toArray();
    }

    private function extractData($array, $lang)
    {
        if (!isset($array)) {
            return [];
        }

        $transformedArray = [];

        foreach ($array as $key => $value) {
            foreach ($value as $subKey => $subValue) {
                if (str_contains($subKey, 'model')) {
                    $transformedArray[$key][$subKey] = $subValue;
                } elseif (str_contains($subKey, 'cta_')) {
                    $transformedArray[$key][$subKey]['link'] = $subValue['link'][app()->getLocale()];
                    $transformedArray[$key][$subKey]['text'] = $subValue['text'][app()->getLocale()];
                } else {
                    $transformedArray[$key][$subKey] = $subValue[app()->getLocale()];
                }
            }
        }

        return $transformedArray;
    }

    public function updatedLanguage($value)
    {
        $this->language = $value;
    }

    public function addSection(Section $section)
    {
        $this->page->sections()->attach($section->id, ['data' => $this->transformSkelAr(json_decode($section->skeleton->skeleton, true)['data'])]);
        return redirect(route('admin.cms.pages.edit', $this->page->id));
    }

    public function transformSkelAr($sections)
    {
        $transformed = [];

        foreach ($sections as $section) {
            $id = $section["id"];
            $skeleton = $section["skeleton"];
            $transformed[$id] = [];
            foreach ($skeleton as $key => $value) {
                if (is_array($value)) {
                    $transformed[$id] = $skeleton;
                } else {
                    $transl = [];
                    foreach (LaravelLocalization::getSupportedLanguagesKeys() as $language) {
                        if (str_contains($value, 'cta')) {
                            $transl['link'][$language] = 'Link';
                            $transl['text'][$language] = 'Text';
                        } else {
                            $transl[$language] = $value;
                        }
                    }
                    $transformed[$id][$value] = $transl;
                }
            }
        }

        return $transformed;
    }

    #[Computed()]
    public function allmodels()
    {
        $modelList = [];
        $path = app_path() . "/Models";
        $results = scandir($path);

        foreach ($results as $result) {
            if ($result === '.' or $result === '..') continue;

            // Check if it's a file
            if (is_file($path . '/' . $result)) {
                $model = "\App\\Models\\" . pathinfo($result, PATHINFO_FILENAME);

                // Check if the model has the WIDGET constant
                if (defined("$model::WIDGET") && $model::WIDGET) {
                    $modelList[] = pathinfo($result, PATHINFO_FILENAME);
                }
            }
        }

        return $modelList;
    }

    public function updateSectionOrder($sections_order)
    {
        foreach ($sections_order as $section) {
            $this->page->sections()->wherePivot('id', $section['value'])->update([
                'order' => $section['order']
            ]);
        }
    }

    #[Computed()]
    public function sections()
    {
        return Section::with('skeleton')->where('theme_id', 1)->get();
    }

    public function update($draft = 0)
    {
        $datas = $this->validate([
            'sections_data' => 'array',
            'sections_data.*.*.*' => 'required'
        ]);

        $this->form->update();

        foreach ($datas['sections_data'] as $sec_key => $sections_data) {
            foreach ($sections_data as $data_key => $data) {
                foreach ($data as $item_key => $item) {
                    if (str_contains($item_key, 'single_image_') && is_object($datas['sections_data'][$sec_key][$data_key][$item_key])) {
                        $datas['sections_data'][$sec_key][$data_key][$item_key] = $datas['sections_data'][$sec_key][$data_key][$item_key]->store('pages', 'web-fe');
                    }
                }
            }
        }

        foreach ($datas['sections_data'] as $sec_key => $sections_data) {
            $this->page->sections()->wherePivot('id', $sec_key)->update([
                'data' => $this->transform($sections_data, $this->original_data[$sec_key])
            ]);
        }

        return redirect(route('admin.cms.pages.edit', $this->page->id));
    }

    // private function transform($array, $original_data)
    // {
    //     foreach ($array as $key => $value) {
    //         if (is_array($value)) {
    //             if (str_contains(array_keys($value)[0], 'model_')) {
    //                 $original_data[$key] = $value;
    //             } else {
    //                 $original_data[$key] = $this->transform($value, $original_data[$key]);
    //             }
    //         } else {
    //             if (str_contains($key, 'image')) {
    //                 foreach (LaravelLocalization::getSupportedLanguagesKeys() as $language) {
    //                     $original_data[$key][$language] = $value;
    //                 }
    //             } else {
    //                 if (isset($original_data[$key][$this->language])) {
    //                     $original_data[$key][$this->language] = $value;
    //                 } else {
    //                     $original_data[$key] = [$this->language => $value];
    //                 }
    //             }
    //         }
    //     }

    //     return $original_data;
    // }

    private function transform($array, $original_data)
    {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (isset($original_data[$key]) && !isset($original_data[$key][$this->language])) {
                    $original_data[$key] = $this->transform($value, $original_data[$key]);
                } else {
                    $original_data[$key] = $this->transform($value, []);
                }
            } else {
                if (str_contains($key, 'image')) {
                    foreach (LaravelLocalization::getSupportedLanguagesKeys() as $language) {
                        $original_data[$key][$language] = $value;
                    }
                } elseif (str_contains($key, 'model') || str_contains($key, 'records')) {
                    $original_data[$key] = $value;
                } else {
                    if (isset($original_data[$key][$this->language])) {
                        $original_data[$key][$this->language] = $value;
                    } else {
                        $original_data[$key] = [$this->language => $value];
                    }
                }
            }
        }

        return $original_data;
    }

    public function delete()
    {
        $this->page->sections()->wherePivot('id', '=', $this->selected_id)->detach();
        $this->showDeleteModal = false;
        $this->reset('selected_id');
    }

    public function deleteLink(PageSuccessLink $pagelink)
    {
        $pagelink->delete();
    }

    #[On('edit-page')]
    public function render()
    {
        return view('livewire.marketing.c-m-s.pages.edit-page', [
            'links' => PageSuccessLink::where('page_id', $this->page->id)->get()
        ]);
    }
}
