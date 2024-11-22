<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Themes;

use Lianmaymesi\LaravelCms\Livewire\BaseComponent;
use Lianmaymesi\LaravelCms\Models\Section;
use Livewire\Attributes\Layout;

#[Layout('components.marketing.layouts.admin')]
class IndexSection extends BaseComponent
{
    public $page_title = 'Sections List';

    public function render()
    {
        return view('livewire.marketing.c-m-s.themes.index-section', [
            'sections' => Section::paginate($this->perPage),
        ]);
    }
}
