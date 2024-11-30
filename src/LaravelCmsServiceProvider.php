<?php

namespace Lianmaymesi\LaravelCms;

use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Workbench\Database\Seeders\DatabaseSeeder;
use Lianmaymesi\LaravelCms\Livewire\CMS\IndexMenu;
use Lianmaymesi\LaravelCms\Livewire\CMS\IndexTheme;
use Lianmaymesi\LaravelCms\Commands\LaravelCmsCommand;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Lianmaymesi\LaravelCms\Livewire\CMS\Pages\EditPage;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Lianmaymesi\LaravelCms\Livewire\CMS\Pages\IndexPage;
use Lianmaymesi\LaravelCms\Livewire\CMS\Pages\CreatePage;
use Lianmaymesi\LaravelCms\Commands\LaravelCmsSeederCommand;
use Lianmaymesi\LaravelCms\Database\Seeders\CmsSeeder;
use Lianmaymesi\LaravelCms\Livewire\CMS\Themes\IndexSection;
use Lianmaymesi\LaravelCms\Livewire\CMS\Themes\CreateSection;
use Lianmaymesi\LaravelCms\Livewire\CMS\Modal\CreateMenuModal;
use Lianmaymesi\LaravelCms\Livewire\CMS\Skeleton\ViewSkeleton;
use Lianmaymesi\LaravelCms\Livewire\CMS\Modal\CreateThemeModal;

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
            ->hasCommand(LaravelCmsSeederCommand::class)
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->startWith(function (InstallCommand $command) {
                        $command->info('Folks! Thank you for trying my package.');
                    })
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('lianmaymesi/laravel-cms')
                    ->endWith(function (InstallCommand $command) {
                        $command->info('Have a great day!');
                    });
            });
    }

    public function bootingPackage()
    {
        Livewire::component('edit-page', EditPage::class);
        Livewire::component('index-menu', IndexMenu::class);
        Livewire::component('index-page', IndexPage::class);
        Livewire::component('create-page', CreatePage::class);
        Livewire::component('index-thene', IndexTheme::class);
        Livewire::component('view-skeleton', ViewSkeleton::class);
        Livewire::component('index-section', IndexSection::class);
        Livewire::component('create-section', CreateSection::class);
        Livewire::component('create-menu-modal', CreateMenuModal::class);
        Livewire::component('create-menu-modal', CreateMenuModal::class);
        Livewire::component('create-theme-modal', CreateThemeModal::class);

        // $this->loadSeeders([CmsSeeder::class]);
        include __DIR__ . '/../Database/Seeders/CmsSeeder.php';
    }
}
