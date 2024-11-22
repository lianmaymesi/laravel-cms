<?php

namespace Lianmaymesi\LaravelCms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Theme extends Model
{
    use HasFactory;

    public const WIDGET = false;

    protected $guarded = [];

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }
}
