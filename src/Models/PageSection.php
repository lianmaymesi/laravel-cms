<?php

namespace Lianmaymesi\LaravelCms\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PageSection extends Pivot
{
    public const WIDGET = false;

    public $incrementing = true;

    protected $table = 'page_sections';

    protected $casts = [
        'data' => Json::class
    ];

    public function imageUrl($image)
    {
        return Storage::disk('web-fe')->url($image);
    }
}
