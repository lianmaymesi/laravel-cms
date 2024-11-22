<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS;

use Psy\Output\Theme;
use Livewire\Attributes\On;
use Livewire\Attributes\Layout;
use Lianmaymesi\LaravelCms\Livewire\BaseComponent;

#[Layout('components.marketing.layouts.admin')]
class IndexTheme extends BaseComponent
{
    public $page_title = 'Themes List';

    #[On('theme-lists')]
    public function render()
    {
        return view('livewire.marketing.c-m-s.index-theme', [
            'themes' => Theme::paginate($this->perPage)
        ]);
    }
}
