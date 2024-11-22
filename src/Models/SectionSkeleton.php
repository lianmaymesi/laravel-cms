<?php

namespace Lianmaymesi\LaravelCms\Models;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
