<?php

namespace Lianmaymesi\LaravelCms\Livewire\Forms;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Lianmaymesi\LaravelCms\Models\Language;
use Lianmaymesi\LaravelCms\Models\Menu;
use Lianmaymesi\LaravelCms\Models\Page;
use Livewire\Form;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class PageForm extends Form
{
    public ?Page $page = null;

    public $menu_id;

    public $featured_image;

    public $head_scripts;

    public $footer_scripts;

    public $page_featured_image;

    public $featured_image_preview;

    public $featured_image_trans;

    public $featured_image_trans_preview;

    public $language;

    public $translations = [
        'title' => '',
        'meta_title' => '',
        'meta_description' => '',
        'meta_tags' => [],
        'featured_image' => '',
    ];

    public function create()
    {
        $this->validate([
            'menu_id' => 'required|exists:menus,id',
            'featured_image' => ['nullable', 'image', Rule::requiredIf(function () {
                return count(LaravelLocalization::getSupportedLocales()) == 1;
            })],
            'translations' => 'array',
            'translations.*' => 'required',
            'translations.featured_image' => ['nullable', 'image', Rule::requiredIf(function () {
                return count(LaravelLocalization::getSupportedLocales()) > 1;
            })],
        ]);

        return DB::transaction(function () {
            if ($this->featured_image) {
                $featured_image = $this->featured_image->store('pages', config('cms.storage_driver'));
            } else {
                $featured_image = null;
            }

            $page = Page::create([
                'menu_id' => $this->menu_id,
                'featured_image' => $featured_image,
            ]);

            if ($this->translations['featured_image']) {
                $featured_image_trans = $this->translations['featured_image']->store('pages', config('cms.storage_driver'));
            } else {
                $featured_image_trans = $featured_image;
            }

            $translation = $page->translations()->create([
                'title' => $this->translations['title'],
                'meta_title' => $this->translations['meta_title'],
                'meta_description' => $this->translations['meta_description'],
                'meta_tags' => json_encode($this->translations['meta_tags']),
                'featured_image' => $featured_image_trans,
            ]);
            $translation->language()->associate(Language::where('code', $this->language)->first());
            $translation->save();

            return $page->id;
        });
    }

    public function update(int $draft = 0)
    {
        $this->validate([
            'page_featured_image' => ['nullable', 'image'],
            'translations' => 'array',
            'translations.*' => 'required',
            'translations.featured_image' => ['nullable', 'image'],
            'head_scripts' => 'nullable|string',
            'footer_scripts' => 'nullable|string',
        ]);

        $menu = Menu::withDrafts()->where('id', $this->page->menu_id)->first();
        if ($draft) {
            $menu->is_published = false;
            $menu->status = 'draft';
        } else {
            $menu->is_published = true;
            $menu->status = 'publish';
        }
        $menu->withoutRevision()->save();

        $translation = $this->page->translations()->where('language_id', Language::where('code', 'en')->first()->id)->first();

        if ($this->page_featured_image) {
            if ($this->page->featured_image) {
                Storage::disk(config('cms.storage_driver'))->delete($this->page->featured_image);
            }
            $this->page->featured_image = $this->page_featured_image->store('pages', config('cms.storage_driver'));
            if (count(LaravelLocalization::getSupportedLocales()) == 1) {
                $translation->featured_image = $this->page->featured_image;
            }
        }

        if ($this->featured_image_trans) {
            if ($translation->featured_image) {
                Storage::disk(config('cms.storage_driver'))->delete($translation->featured_image);
            }
            $translation->featured_image = $this->featured_image_trans->store('pages', config('cms.storage_driver'));
        }

        $this->page->head_scripts = $this->head_scripts;
        $this->page->footer_scripts = $this->footer_scripts;
        $this->page->save();

        $translation->title = $this->translations['title'];
        $translation->meta_title = $this->translations['meta_title'];
        $translation->meta_description = $this->translations['meta_description'];
        $translation->meta_tags = json_encode($this->translations['meta_tags']);
        $translation->save();
    }

    public function setPage(?Page $page = null)
    {
        $this->page = $page;
        $this->featured_image = $page->featured_image;
        $this->featured_image_preview = $page->imageUrl();
        $this->translations = $page->detail->toArray();
        $this->translations['meta_tags'] = json_decode($page->detail->meta_tags, true);
        $this->translations['featured_image'] = null;
        $this->featured_image_trans_preview = $page->detail->imageUrl();
        $this->head_scripts = $page->head_scripts;
        $this->footer_scripts = $page->footer_scripts;
    }
}
