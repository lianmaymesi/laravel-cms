<?php

namespace Lianmaymesi\LaravelCms\Livewire\Forms;

use Illuminate\Support\Facades\DB;
use Lianmaymesi\LaravelCms\Models\Language;
use Lianmaymesi\LaravelCms\Models\Page;
use Livewire\Form;

class PageForm extends Form
{
    public ?Page $page = null;

    public $menu_id;

    public $featured_image;

    public $head_scripts;

    public $footer_scripts;

    public $success_scripts;

    public $page_featured_image;

    public $featured_image_preview;

    public $featured_image_trans;

    public $featured_image_trans_preview;

    public $image_trans;

    public $featured_image_success_preview;

    public $language;

    public $translations = [
        'title' => '',
        'meta_title' => '',
        'meta_description' => '',
        'meta_tags' => [],
        'featured_image' => '',
        'success_title' => '',
        'help_title' => '',
        'success_content' => '',
        'image' => '',
    ];

    public function create()
    {
        $this->validate([
            'menu_id' => 'required|exists:menus,id',
            'featured_image' => 'nullable|image',
            'translations' => 'array',
            'translations.*' => 'required',
        ]);

        return DB::transaction(function () {
            if ($this->featured_image) {
                $featured_image = $this->featured_image->store('pages', 'web-fe');
            } else {
                $featured_image = null;
            }

            $page = Page::create([
                'menu_id' => $this->menu_id,
                'featured_image' => $featured_image,
            ]);

            if ($this->translations['featured_image']) {
                $featured_image_trans = $this->translations['featured_image']->store('pages', 'web-fe');
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

    public function update()
    {
        $this->validate([
            'translations' => 'array',
            'translations.*' => 'required',
            'translations.featured_image' => 'nullable',
            'translations.image' => 'nullable',
            'head_scripts' => 'nullable|string',
            'footer_scripts' => 'nullable|string',
            'success_scripts' => 'nullable|string',
        ]);

        if ($this->page_featured_image) {
            $page_featured_image = $this->page_featured_image->store('pages', 'web-fe');
        } else {
            $page_featured_image = null;
        }

        $this->page->update([
            'head_scripts' => $this->head_scripts,
            'footer_scripts' => $this->footer_scripts,
            'success_scripts' => $this->success_scripts,
            'featured_image' => $page_featured_image ? $page_featured_image : $this->featured_image,
        ]);

        if ($this->featured_image_trans) {
            $featured_image_trans = $this->featured_image_trans->store('pages', 'web-fe');
        } else {
            $featured_image_trans = null;
        }

        if ($this->image_trans) {
            $succes_image = $this->image_trans->store('pages', 'web-fe');
        } else {
            $succes_image = null;
        }

        $this->page->translations()->where('language_id', Language::where('code', 'en')->first()->id)
            ->update([
                'title' => $this->translations['title'],
                'meta_title' => $this->translations['meta_title'],
                'meta_description' => $this->translations['meta_description'],
                'meta_tags' => json_encode($this->translations['meta_tags']),
                'success_title' => $this->translations['success_title'],
                'success_content' => $this->translations['success_content'],
                'help_title' => $this->translations['help_title'],
                'image' => $succes_image ? $succes_image : $this->translations['image'],
                'featured_image' => $featured_image_trans ? $featured_image_trans : $this->translations['featured_image'],
            ]);
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
        $this->featured_image_success_preview = $page->detail->imageSuccessUrl();
        $this->head_scripts = $page->head_scripts;
        $this->footer_scripts = $page->footer_scripts;
        $this->success_scripts = $page->success_scripts;
    }
}
