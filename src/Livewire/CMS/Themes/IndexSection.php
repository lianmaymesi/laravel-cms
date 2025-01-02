<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Themes;

use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Lianmaymesi\LaravelCms\Models\Section;
use Lianmaymesi\LaravelCms\Livewire\BaseComponent;

#[Layout('cms::components.layouts.cms-app')]
class IndexSection extends BaseComponent
{
    use WithPagination;

    public $page_title = 'Sections List';

    public function render()
    {
        $this->can('index section');

        return view('cms::livewire.c-m-s.themes.index-section', [
            'sections' => Section::paginate($this->perPage),
        ]);
    }
}
