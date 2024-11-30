<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Pages;

use Lianmaymesi\LaravelCms\Livewire\BaseComponent;
use Lianmaymesi\LaravelCms\Models\Page;
use Livewire\Attributes\Layout;

#[Layout('cms::components.layouts.cms-app')]
class IndexPage extends BaseComponent
{
    public $page_title = 'Pages List';

    public function delete()
    {
        $this->can('delete page');
        Page::find($this->selected_id)->delete();
        $this->showDeleteModal = false;
        $this->reset('selected_id');
    }

    public function render()
    {
        $this->can('index page');

        return view('cms::livewire.c-m-s.pages.index-page', [
            'pages' => Page::with(['menu' => function ($query) {
                return $query->withDrafts(true);
            }, 'detail', 'sections'])->paginate($this->perPage),
        ]);
    }
}
