<?php

namespace Lianmaymesi\LaravelCms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PageTranslation extends Model
{
    use HasFactory;

    public const WIDGET = false;

    protected $guarded = [];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function imageUrl()
    {
        return $this->featured_image
            ? Storage::disk(config('cms.storage_driver'))->url($this->featured_image)
            : url('images/placeholder.jpg');
    }
}
