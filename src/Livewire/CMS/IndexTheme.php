<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS;

use Lianmaymesi\LaravelCms\Livewire\BaseComponent;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Psy\Output\Theme;

#[Layout('components.marketing.layouts.admin')]
class IndexTheme extends BaseComponent
{
    public $page_title = 'Themes List';

    #[On('theme-lists')]
    public function render()
    {
        return view('livewire.marketing.c-m-s.index-theme', [
            'themes' => Theme::paginate($this->perPage),
        ]);
    }
}
