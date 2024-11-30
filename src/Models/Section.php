<?php

namespace Lianmaymesi\LaravelCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    public const WIDGET = false;

    protected $guarded = [];

    public function skeleton(): HasOne
    {
        return $this->hasOne(SectionSkeleton::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function imageUrl()
    {
        return $this->image
            ? Storage::disk(config('cms.storage_driver'))->url($this->image)
            : url('images/placeholder.jpg');
    }
}
