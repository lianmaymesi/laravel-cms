<?php

namespace Lianmaymesi\LaravelCms\Livewire\Forms;

use Livewire\Form;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Lianmaymesi\LaravelCms\Models\Menu;
use Lianmaymesi\LaravelCms\Models\Language;

class MenuForm extends Form
{
    public ?Menu $menu = null;

    public $label;
    public $placement = ['header', 'footer'];
    public $search_visible = 1;
    public $order;
    public $status = 'publish';
    public $parent_id;
    public $have_page = false;
    public $route;
    public $is_toplevel = 1;
    public $is_published = true;

    public $language;

    public $translations = [
        'title' => ''
    ];

    public function add()
    {
        $this->validate([
            'label' => 'required|string',
            'placement' => 'required|array',
            'search_visible' => 'required|boolean',
            'status' => 'required|string',
            'parent_id' => 'nullable|exists:menus,id',
            'translations.title' => 'required|string'
        ]);

        if ($this->menu) {
            return DB::transaction(function () {
                if ($this->status === 'draft') {
                    $this->is_published = false;
                    $menu = $this->menu->updateAsDraft($this->except(['translations', 'menu', 'language']));
                } else {
                    $menu = $this->menu->update($this->except(['translations', 'menu', 'language']));
                }
                $this->menu->translations()->where('language_id', Language::where('code', $this->language)->first()->id)
                    ->update([
                        'title' => $this->translations['title']
                    ]);
            });
        } else {
            return DB::transaction(function () {
                if ($this->status === 'draft') {
                    $this->is_published = false;
                }
                $menu = Menu::create($this->except(['translations', 'menu', 'language']));
                $translation = $menu->translations()->create([
                    'title' => $this->translations['title']
                ]);
                $translation->language()->associate(Language::where('code', $this->language)->first());
                $translation->save();
                return $menu->id;
            });
        }

        Cache::forget('global-header-menu');
    }

    public function setMenu(?Menu $menu = null)
    {
        $this->menu = $menu;
        $this->label = $menu->label;
        $this->placement = $menu->placement;
        $this->search_visible = $menu->search_visible;
        $this->order = $menu->order;
        $this->status = $menu->status;
        $this->parent_id = $menu->parent_id;
        $this->translations = $menu->detail->toArray();
        $this->have_page = $menu->have_page;
        $this->route = $menu->route;
        $this->is_toplevel = $menu->is_toplevel;
    }
}
