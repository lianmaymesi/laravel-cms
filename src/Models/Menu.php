<?php

namespace Lianmaymesi\LaravelCms\Models;

use Illuminate\Database\Eloquent\Model;
use Lianmaymesi\LaravelCms\Models\Casts\Json;
use Oddvalue\LaravelDrafts\Concerns\HasDrafts;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lianmaymesi\LaravelCms\Models\Traits\Orderable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory, Orderable, HasDrafts;

    public const WIDGET = false;

    protected $guarded = [];

    protected $casts = [
        'placement' => Json::class
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            if ($model->parent_id) {
                $model->order = static::where('parent_id', $model->parent_id)->max('order') + 1;
            } else {
                $model->order = static::max('order') + 1;
            }
        });

        static::deleting(function (Model $model) {
            if ($model->parent_id) {
                $model->where('parent_id', $model->parent_id)
                    ->where('order', '>', $model->order)
                    ->decrement('order');
            } else {
                $model->where('order', '>', $model->order)
                    ->decrement('order');
            }
        });
    }

    public function detail(): HasOne
    {
        return $this->hasOne(MenuTranslation::class, 'menu_id', 'id')
            ->where('language_id', Language::where('code', app()->getLocale())->first()->id);
    }

    public function page(): HasOne
    {
        return $this->hasOne(Page::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(MenuTranslation::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent_id', 'id')->orderBy('order', 'asc');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    public function getLastOrderAttribute(): int
    {
        return self::whereNull('parent_id')->count();
    }

    public function getChildLastOrderAttribute(): int
    {
        return self::where('parent_id', $this->parent_id)->count();
    }

    public function moveUp()
    {
        $previous = static::where('parent_id', $this->parent_id)
            ->where('order', '<', $this->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($previous) {
            $this->swapOrderWith($previous);
        }
    }

    public function moveDown()
    {
        $next = static::where('parent_id', $this->parent_id)
            ->where('order', '>', $this->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($next) {
            $this->swapOrderWith($next);
        }
    }

    protected function swapOrderWith($other)
    {
        $currentOrder = $this->order;
        $this->order = $other->order;
        $other->order = $currentOrder;

        $this->save();
        $other->save();
    }

    public function getLinkAttribute()
    {
        $path = [];

        $current = $this;

        while ($current) {
            $path[] = $current->detail->slug;
            $current = $current->parent;
        }

        return implode('/', array_reverse($path));
    }
}
