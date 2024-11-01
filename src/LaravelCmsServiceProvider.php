<?php

namespace Lianmaymesi\LaravelCms;

use Lianmaymesi\LaravelCms\Commands\LaravelCmsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelCmsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-cms')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_cms_table')
            ->hasCommand(LaravelCmsCommand::class);
    }
}
