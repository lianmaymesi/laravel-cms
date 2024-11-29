<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Modal;

use Lianmaymesi\LaravelCms\Livewire\Forms\MenuForm;
use Lianmaymesi\LaravelCms\Models\Menu;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class CreateMenuModal extends Component
{
    public ?Menu $menu = null;

    public MenuForm $form;

    public $show = false;

    #[On('create-menu')]
    public function modal($event, $menu = null)
    {
        if ($event === 'show') {
            $this->show = true;
            $this->form->language = $this->form->language ? $this->form->language : app()->getLocale();
            if ($model = Menu::find($menu)) {
                $this->form->setMenu($model);
            } else {
                $this->form->menu = null;
            }
        } else {
            $this->show = false;
            $this->form->reset();
        }
    }

    #[Computed()]
    public function parentMenu()
    {
        return Menu::get();
    }

    public function create()
    {
        $this->form->add();
        $this->form->reset();
        $this->show = false;
        $this->dispatch('menus-list');
    }

    public function render()
    {
        return view('cms::livewire.c-m-s.modal.create-menu-modal');
    }
}
