<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Modal;

use Lianmaymesi\LaravelCms\Livewire\BaseComponent;
use Lianmaymesi\LaravelCms\Livewire\Forms\ThemeForm;
use Lianmaymesi\LaravelCms\Models\Theme;
use Livewire\Attributes\On;

class CreateThemeModal extends BaseComponent
{
    public ?Theme $theme = null;

    public ThemeForm $form;

    public $show = false;

    #[On('create-theme')]
    public function modal($event, $theme = null)
    {
        if ($event === 'show') {
            $this->show = true;
            if ($model = Theme::find($theme)) {
                $this->form->setTheme($model);
            } else {
                $this->form->theme = null;
            }
        } else {
            $this->show = false;
            $this->form->reset();
        }
    }

    public function create()
    {
        $this->can('create theme');
        $this->form->save();
        $this->show = false;
        $this->form->reset();
        $this->dispatch('theme-lists');
    }

    public function render()
    {
        return view('cms::livewire.c-m-s.modal.create-theme-modal');
    }
}
