<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Themes;

use Lianmaymesi\LaravelCms\Livewire\BaseComponent;
use Lianmaymesi\LaravelCms\Models\Section;
use Livewire\Attributes\Layout;

#[Layout('cms::components.layouts.cms-app')]
class IndexSection extends BaseComponent
{
    public $page_title = 'Sections List';

    public function render()
    {
        $this->can('index section');

        return view('cms::livewire.c-m-s.themes.index-section', [
            'sections' => Section::paginate($this->perPage),
        ]);
    }
}
