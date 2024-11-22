<?php

namespace Lianmaymesi\LaravelCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Oddvalue\LaravelDrafts\Concerns\HasDrafts;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Page extends Model
{
    use HasFactory;

    public const WIDGET = false;

    protected $guarded = [];

    public function getDraftableRelations()
    {
        return ['menu'];
    }

    public function detail(): HasOne
    {
        return $this->hasOne(PageTranslation::class, 'page_id', 'id')
            ->where('language_id', Language::where('code', app()->getLocale())->first()->id);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function menu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }

    public function sections(): BelongsToMany
    {
        return $this->belongsToMany(Section::class, 'page_sections')
            ->using(PageSection::class)
            ->withPivot(['id', 'data', 'order', 'is_active'])
            ->withTimestamps()
            ->orderByPivot('order', 'asc');
    }

    public function imageUrl()
    {
        return $this->featured_image
            ? Storage::disk('web-fe')->url($this->featured_image)
            : url('images/placeholder.jpg');
    }
}
