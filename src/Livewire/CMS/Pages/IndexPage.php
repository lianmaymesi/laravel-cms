<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Pages;

use Livewire\Attributes\Layout;
use Lianmaymesi\LaravelCms\Models\Page;
use Lianmaymesi\LaravelCms\Livewire\BaseComponent;

#[Layout('cms::components.layouts.cms-app')]
class IndexPage extends BaseComponent
{
    public $page_title = 'Pages List';

    public function delete()
    {
        Page::find($this->selected_id)->delete();
        $this->showDeleteModal = false;
        $this->reset('selected_id');
    }

    public function render()
    {
        return view('cms::livewire.c-m-s.pages.index-page', [
            'pages' => Page::with(['menu' => function ($query) {
                return $query->withDrafts(true);
            }, 'detail', 'sections'])->paginate($this->perPage)
        ]);
    }
}
