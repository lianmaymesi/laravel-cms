<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS;

use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Lianmaymesi\LaravelCms\Models\Theme;
use Lianmaymesi\LaravelCms\Livewire\BaseComponent;

#[Layout('cms::components.layouts.cms-app')]
class IndexTheme extends BaseComponent
{
    public $page_title = 'Themes List';

    #[On('theme-lists')]
    public function render()
    {
        return view('cms::livewire.c-m-s.index-theme', [
            'themes' => Theme::paginate($this->perPage)
        ]);
    }
}
