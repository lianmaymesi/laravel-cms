<?php

namespace Lianmaymesi\LaravelCms\Livewire\Forms;

use Lianmaymesi\LaravelCms\Models\PageSuccessLink;
use Livewire\Form;

class PageSuccessLinkForm extends Form
{
    public ?PageSuccessLink $pagelink = null;

    public $title;

    public $link;

    public $page_id;

    public $language;

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'link' => 'required',
        ]);
        if ($this->pagelink) {
            $this->pagelink->update([
                'title' => $this->title,
                'link' => $this->link,
            ]);
        } else {
            PageSuccessLink::create([
                'title' => $this->title,
                'link' => $this->link,
                'page_id' => $this->page_id,
            ]);
        }
    }

    public function setPageSuccessLink(?PageSuccessLink $pagelink = null)
    {
        $this->pagelink = $pagelink;
        $this->title = $pagelink->title;
        $this->link = $pagelink->link;
        $this->page_id = $pagelink->page_id;
    }
}
