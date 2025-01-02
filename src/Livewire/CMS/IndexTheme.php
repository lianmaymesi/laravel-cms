<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS;

use Lianmaymesi\LaravelCms\Livewire\BaseComponent;
use Lianmaymesi\LaravelCms\Models\Theme;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\WithPagination;

#[Layout('cms::components.layouts.cms-app')]
class IndexTheme extends BaseComponent
{
    use WithPagination;

    public $page_title = 'Themes List';

    #[On('theme-lists')]
    public function render()
    {
        $this->can('index theme');

        return view('cms::livewire.c-m-s.index-theme', [
            'themes' => Theme::paginate($this->perPage),
        ]);
    }
}
