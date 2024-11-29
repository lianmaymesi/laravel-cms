<?php

namespace Lianmaymesi\LaravelCms\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\Storage;
use Lianmaymesi\LaravelCms\Models\Casts\Json;

class PageSection extends Pivot
{
    public const WIDGET = false;

    public $incrementing = true;

    protected $table = 'page_sections';

    protected $casts = [
        'data' => Json::class,
    ];

    public function imageUrl($image)
    {
        return Storage::disk(config('cms.storage_driver'))->url($image);
    }
}
