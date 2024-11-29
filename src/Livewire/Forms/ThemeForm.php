<?php

namespace Lianmaymesi\LaravelCms\Livewire\Forms;

use Lianmaymesi\LaravelCms\Models\Theme;
use Livewire\Form;

class ThemeForm extends Form
{
    public ?Theme $theme = null;

    public $title;

    public $is_default = true;

    public function save()
    {
        $this->validate([
            'title' => 'required|string',
            'is_default' => 'required|boolean',
        ]);

        Theme::create($this->except('theme'));
    }

    public function setTheme(?Theme $theme = null)
    {
        $this->theme = $theme;
        $this->title = $theme->title;
        $this->is_default = $theme->is_default;
    }
}
