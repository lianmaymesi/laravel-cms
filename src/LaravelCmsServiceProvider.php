<?php

namespace Lianmaymesi\LaravelCms;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Lianmaymesi\LaravelCms\Commands\LaravelCmsCommand;
use Lianmaymesi\LaravelCms\Livewire\CMS\IndexMenu;
use Lianmaymesi\LaravelCms\Livewire\CMS\Modal\CreateMenuModal;
use Lianmaymesi\LaravelCms\Livewire\CMS\Pages\IndexPage;
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
            ->hasViews('cms')
            ->hasRoute('web')
            ->hasMigration('create_cms_table')
            ->hasCommand(LaravelCmsCommand::class);
    }

    public function bootingPackage()
    {
        Livewire::component('create-menu-modal', CreateMenuModal::class);
        Livewire::component('index-menu', IndexMenu::class);
        Livewire::component('index-page', IndexPage::class);
    }
}
