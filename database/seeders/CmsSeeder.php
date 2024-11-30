<?php

namespace Lianmaymesi\LaravelCms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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

        if (!$role = Role::where('name', 'Super Admin')->first()) {
            $role = Role::create(['name' => 'Super Admin']);
        }

        foreach ($permissions as $permission) {
            if (!Permission::where('name', $permission)->first()) {
                Permission::create([
                    'name' => $permission
                ]);
                $role->givePermissionTo($permission);
            }
        }

        if (!\App\Models\User::where('email', config('cms.super_admin_email'))->first()) {
            $user = \App\Models\User::create([
                'name' => 'Super Admin',
                'email' => config('cms.super_admin_email'),
                'password' => Hash::make('Secret@143'),
                'email_verified_at' => now()
            ]);

            $user->assignRole('Super Admin');
        }
    }
}
