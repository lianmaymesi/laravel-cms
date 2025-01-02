<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS;

use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Lianmaymesi\LaravelCms\Models\Menu;
use Lianmaymesi\LaravelCms\Livewire\BaseComponent;
use Lianmaymesi\LaravelCms\Livewire\Forms\MenuForm;

#[Layout('cms::components.layouts.cms-app')]
class IndexMenu extends BaseComponent
{
    use WithPagination;

    public ?Menu $menu = null;

    public MenuForm $form;

    public $page_title = 'Menu List';

    public $placement;

    public function moveUp(Menu $menu)
    {
        $menu->moveUp();
    }

    public function moveDown(Menu $menu)
    {
        $menu->moveDown();
    }

    public function getPlacementQueryProperty()
    {
        return Menu::with('children')
            ->withDrafts(true)
            ->when($this->placement, fn($query, $value) => $query->where('placement', $this->placement))
            ->whereNull('parent_id')
            ->orderBy('order', 'asc')
            ->paginate($this->perPage);
    }

    public function updateStatus($menu, $status)
    {
        Menu::withDrafts(true)->where('id', $menu)->update([
            'status' => $status,
            'is_published' => $status === 'draft' ? false : true,
        ]);
    }

    public function sortMenu($items)
    {
        dd($items);
    }

    public function delete()
    {
        $this->can('delete menu');
        $menu = Menu::with('page')->withDrafts(true)->where('id', $this->selected_id)->first();
        if ($menu->page) {
            $menu->page->delete();
        }
        $menu->delete();
        $this->showDeleteModal = false;
        $this->reset('selected_id');
    }

    #[On('menus-list')]
    public function render()
    {
        $this->can('index menu');

        return view('cms::livewire.c-m-s.index-menu', [
            'menus' => $this->placement_query,
        ]);
    }
}
