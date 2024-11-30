<?php

namespace Lianmaymesi\LaravelCms\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Lianmaymesi\LaravelCms\Database\Seeders\CmsSeeder;

class LaravelCmsSeederCommand extends Command
{
    public $signature = 'laravel-cms';

    public $description = 'Publishes Spatie Permission migrations and seeds default permissions for CMS';

    public function handle(): int
    {
        $this->comment('Publishing Spatie Permission migration files...');
        Artisan::call('vendor:publish', [
            '--provider' => 'Spatie\Permission\PermissionServiceProvider',
        ]);
        $this->info('Spatie Permission migration files published successfully!');

        Artisan::call('migrate');

        $this->comment('Seeding default CMS permissions...');
        Artisan::call('db:seed', [
            '--class' => \Lianmaymesi\LaravelCms\Database\Seeders\CmsSeeder::class,
        ]);
        $this->info('Default CMS permissions seeded successfully!');

        $this->info('Database migrated successfully!');

        return self::SUCCESS;
    }
}
