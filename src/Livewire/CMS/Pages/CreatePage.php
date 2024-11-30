<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Pages;

use Lianmaymesi\LaravelCms\Livewire\BaseComponent;
use Lianmaymesi\LaravelCms\Livewire\Forms\PageForm;
use Lianmaymesi\LaravelCms\Models\Menu;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('cms::components.layouts.cms-app')]
class CreatePage extends BaseComponent
{
    use WithFileUploads;

    public PageForm $form;

    public $page_title = 'Create Page';

    public function mount()
    {
        $this->form->language = $this->form->language === null ? app()->getLocale() : $this->form->language;
    }

    public function create()
    {
        $this->can('create page');
        $page = $this->form->create();
        if ($page) {
            $this->dispatch('notify-saved')->self();
            $this->redirect(route('cms.pages.edit', $page));
        }
    }

    #[Computed()]
    public function menus()
    {
        return Menu::with('detail')->where('have_page', false)
            ->withDrafts(true)
            ->doesntHave('page')
            ->get();
    }

    public function resetForm()
    {
        $this->form->reset();
    }

    public function render()
    {
        return view('cms::livewire.c-m-s.pages.create-page');
    }
}
