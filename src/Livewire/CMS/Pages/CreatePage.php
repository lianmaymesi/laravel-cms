<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Pages;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Lianmaymesi\LaravelCms\Models\Menu;
use Lianmaymesi\LaravelCms\Livewire\Forms\PageForm;

#[Layout('components.marketing.layouts.admin')]
class CreatePage extends Component
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
        $page = $this->form->create();
        if ($page) {
            $this->dispatch('notify-saved')->self();
            $this->redirect(route('admin.cms.pages.edit', $page));
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
        return view('livewire.marketing.c-m-s.pages.create-page');
    }
}
