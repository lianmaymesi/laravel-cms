<?php

namespace Lianmaymesi\LaravelCms\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        $this->seeding();
        $this->info('Default CMS permissions seeded successfully!');

        $this->info('Database migrated successfully!');

        return self::SUCCESS;
    }

    private function seeding()
    {
        $permissions = [
            'create menu',
            'edit menu',
            'delete menu',
            'index menu',
            'create page',
            'edit page',
            'delete page',
            'index page',
            'create section',
            'edit section',
            'delete section',
            'index section',
            'create theme',
            'edit theme',
            'delete theme',
            'index theme',
        ];

        if (! $role = Role::where('name', 'Super Admin')->first()) {
            $role = Role::create(['name' => 'Super Admin']);
        }

        foreach ($permissions as $permission) {
            if (! Permission::where('name', $permission)->first()) {
                Permission::create([
                    'name' => $permission,
                ]);
                $role->givePermissionTo($permission);
            }
        }

        if (! $user = \App\Models\User::where('email', config('cms.super_admin_email'))->first()) {
            $newUser = \App\Models\User::create([
                'name' => 'Super Admin',
                'email' => config('cms.super_admin_email'),
                'password' => Hash::make('Secret@143'),
                'email_verified_at' => now(),
            ]);

            $newUser->assignRole('Super Admin');
        } else {
            $user->assignRole('Super Admin');
        }
    }
}
