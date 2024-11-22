<?php

namespace Lianmaymesi\LaravelCms\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait Orderable
{
    public static function bootOrderable()
    {
        static::creating(function (Model $model) {
            $model->order = static::max('order') + 1;
        });

        static::deleting(function (Model $model) {
            $model->where('order', '>', $model->order)
                ->decrement('order');
        });
    }

    public function moveUpOrder($newOrder)
    {
        static::whereBetween('order', [$this->order + 1, $newOrder])
            ->decrement('order');
    }

    public function moveDownOrder($newOrder)
    {
        static::whereBetween('order', [$newOrder, $this->order - 1])
            ->increment('order');
    }
}
