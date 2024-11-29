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

#[Layout('cms::components.layouts.cms-app')]
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
                    $transformedArray[$key][$subKey]['label'] = $subValue['label'];
                    $transformedArray[$key][$subKey]['link'] = $subValue['value']['link'][app()->getLocale()];
                    $transformedArray[$key][$subKey]['text'] = $subValue['value']['text'][app()->getLocale()];
                } else {
                    $transformedArray[$key][$subKey] = $subValue['value'][app()->getLocale()];
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
        $this->page->sections()->attach($section->id, ['data' => $this->transformSkelAr($section->skeleton->skeleton['data'])]);
        return redirect(route('cms.pages.edit', $this->page->id));
    }

    public function transformSkelAr($sections)
    {
        $transformed = [];

        foreach ($sections as $section) {
            $id = $section["id"];
            $skeleton = $section["skeleton"];
            $transformed[$id] = [];
            foreach ($skeleton as $key => $value) {
                if (str_contains($key, 'cta')) {
                    $transl = [];
                    foreach (LaravelLocalization::getSupportedLanguagesKeys() as $language) {
                        $transl['label'] = $value['label'];
                        $transl['value']['link'][$language] = '';
                        $transl['value']['text'][$language] = '';
                    }
                } elseif (str_contains($key, 'model')) {
                    $transl['label'] = $value['label'];
                    $transl['model'] = $value['model'];
                    $transl['field'] = $value['field'];
                    $transl['value']['type'] = 'all';
                    $transl['value']['records'] = [];
                    $transl['value']['limit'] = 5;
                    $transl['value']['orderby_field'] = 'created_at';
                    $transl['value']['orderby'] = 'asc';
                } else {
                    foreach (LaravelLocalization::getSupportedLanguagesKeys() as $language) {
                        $transl['label'] = $value['label'];
                        $transl['value'][$language] = '';
                    }
                }
                $transformed[$id][$key] = $transl;
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
            if ($result === '.' or $result === '..')

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
            'sections_data.*.*.*.*' => 'required'
        ]);

        $this->form->update($draft);

        foreach ($datas['sections_data'] as $sec_key => $sections_data) {
            foreach ($sections_data as $data_key => $data) {
                foreach ($data as $item_key => $item) {
                    if (str_contains($item_key, 'single_image_') && is_object($datas['sections_data'][$sec_key][$data_key][$item_key])) {
                        $datas['sections_data'][$sec_key][$data_key][$item_key] = $datas['sections_data'][$sec_key][$data_key][$item_key]->store('pages', config('cms.storage_driver'));
                    }
                }
            }
        }

        foreach ($this->sections_data as $sec_key => $sections_data) {

            $transformedData = $this->transform($sections_data, $this->original_data[$sec_key]);

            $this->page->sections()->wherePivot('id', $sec_key)->update([
                'data' => $transformedData,
            ]);
        }

        return redirect(route('cms.pages.edit', $this->page->id));
    }

    private function transform($array, $original_data)
    {
        foreach ($array as $key => $value) {

            if (is_array($value)) {
                if (isset($original_data[$key])) {
                    $original_data[$key] = $this->transform($value, $original_data[$key]);
                }
            }

            if (str_contains($key, 'cta_')) {
                // Handle 'cta_' fields
                if (isset($original_data[$key])) {
                    // Ensure 'value' is always an array for 'cta_' keys
                    if (!isset($original_data[$key]['value'])) {
                        $original_data[$key]['value'] = [];
                    }

                    // Handle 'link' and 'text' for 'cta_'
                    if (isset($value['link'])) {
                        $original_data[$key]['value']['link'][$this->language] = $value['link'];
                    }
                    if (isset($value['text'])) {
                        $original_data[$key]['value']['text'][$this->language] = $value['text'];
                    }

                    // Handle 'label'
                    if (isset($value['label'])) {
                        $original_data[$key]['label'] = $value['label'];
                    }
                }
            }

            if (str_contains($key, 'model_')) {
                if (isset($original_data[$key])) {
                    // Ensure 'value' is always an array for 'model_' keys
                    if (!isset($original_data[$key]['value'])) {
                        $original_data[$key]['value'] = [];
                    }

                    // Loop through 'value' to update or retain existing values
                    foreach ($value['value'] as $subKey => $subValue) {
                        $original_data[$key]['value'][$subKey] = $subValue;
                    }

                    // Handle 'label', 'field', 'model' and other properties
                    foreach (['label', 'field', 'model'] as $property) {
                        if (isset($value[$property])) {
                            $original_data[$key][$property] = $value[$property];
                        }
                    }
                }
            }

            if (str_contains($key, 'text_') || str_contains($key, 'textarea_') || str_contains($key, 'markdown_')) {
                if (isset($original_data[$key]['value'][$this->language])) {
                    $original_data[$key]['value'][$this->language] = $value;
                } else {
                    $original_data[$key]['value'] = [$this->language => $value];
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
        return view('cms::livewire.c-m-s.pages.edit-page');
    }
}
