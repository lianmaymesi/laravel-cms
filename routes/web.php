<?php

use Illuminate\Support\Facades\Route;
use Lianmaymesi\LaravelCms\Livewire\CMS\IndexMenu;
use Lianmaymesi\LaravelCms\Livewire\CMS\IndexTheme;
use Lianmaymesi\LaravelCms\Livewire\CMS\Pages\EditPage;
use Lianmaymesi\LaravelCms\Livewire\CMS\Pages\IndexPage;
use Lianmaymesi\LaravelCms\Livewire\CMS\Pages\CreatePage;
use Lianmaymesi\LaravelCms\Livewire\CMS\Themes\IndexSection;
use Lianmaymesi\LaravelCms\Livewire\CMS\Themes\CreateSection;

Route::prefix(config('cms.route_prefix'))->name('cms.')->middleware('web')->group(function () {
    Route::get('/menus', IndexMenu::class)->name('menus.index');
    Route::get('/pages', IndexPage::class)->name('pages.index');
    Route::get('/pages/create', CreatePage::class)->name('pages.create');
    Route::get('/pages/{page:id}/edit', EditPage::class)->name('pages.edit');
    Route::get('/themes', IndexTheme::class)->name('themes.index');
    Route::get('/themes/sections', IndexSection::class)->name('themes.sections.index');
    Route::get('/themes/sections/create', CreateSection::class)->name('themes.sections.create');
});
