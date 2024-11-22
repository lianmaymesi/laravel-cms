<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Modal;

use Livewire\Component;
use Livewire\Attributes\On;
use Lianmaymesi\LaravelCms\Models\PageSuccessLink;
use Lianmaymesi\LaravelCms\Livewire\Forms\PageSuccessLinkForm;

class CreatePageSuccessLinkModal extends Component
{
    public ?PageSuccessLink $link = null;
    public PageSuccessLinkForm $form;
    public $page_id;

    public $show = false;

    #[On('create-page-success-link-modal')]
    public function modal($event, $pagelink = null)
    {
        if ($event === 'show') {
            $this->show = true;
            if ($model = PageSuccessLink::find($pagelink)) {
                $this->form->setPageSuccessLink($model);
            } else {
                $this->form->pagelink = null;
                $this->form->reset();
                $this->form->page_id = $this->page_id;
            }
        } else {
            $this->show = false;
            $this->form->reset();
        }
    }

    public function mount($page_id)
    {
        $this->page_id = $page_id;
        $this->form->page_id = $page_id;
    }

    public function save()
    {
        $this->form->save();
        $this->show = false;
        $this->dispatch('edit-page');
    }

    public function close()
    {
        $this->show = false;
    }

    public function render()
    {
        return view('livewire.marketing.c-m-s.modal.create-page-success-link-modal');
    }
}
