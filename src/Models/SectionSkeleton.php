<?php

namespace Lianmaymesi\LaravelCms\Models;

use Illuminate\Database\Eloquent\Model;
use Lianmaymesi\LaravelCms\Models\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SectionSkeleton extends Model
{
    use HasFactory;

    public const WIDGET = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'skeleton' => Json::class,
        ];
    }
}
