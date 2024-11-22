<?php

namespace Lianmaymesi\LaravelCms\Livewire\CMS\Skeleton;

use Livewire\Component;
use Lianmaymesi\LaravelCms\Models\SectionSkeleton;

class ViewSkeleton extends Component
{
    public SectionSkeleton $skeleton;

    public $settings = [];

    public function mount(SectionSkeleton $skeleton)
    {
        $this->skeleton = $skeleton;
        $this->settings = json_decode($skeleton->skeleton, true)['settings'];
    }

    public function render()
    {
        return view('livewire.marketing.c-m-s.skeleton.view-skeleton');
    }
}
