<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS;

use Lianmaymesi\LaravelCms\Livewire\BaseComponent;
use Lianmaymesi\LaravelCms\Models\Theme;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;

#[Layout('cms::components.layouts.cms-app')]
class IndexTheme extends BaseComponent
{
    public $page_title = 'Themes List';

    #[On('theme-lists')]
    public function render()
    {
        return view('cms::livewire.c-m-s.index-theme', [
            'themes' => Theme::paginate($this->perPage),
        ]);
    }
}
