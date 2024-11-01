<?php

namespace Lianmaymesi\LaravelCms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Lianmaymesi\LaravelCms\LaravelCms
 */
class LaravelCms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Lianmaymesi\LaravelCms\LaravelCms::class;
    }
}
