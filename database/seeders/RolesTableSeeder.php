<?php

namespace Database\Seeders;

use App\Modules\Role\Repository\RoleRepositoryInterface;
use App\Modules\User\Repository\UserRepositoryInterface;
use App\Modules\User\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(RoleRepositoryInterface $repo, UserRepositoryInterface $userRepo)
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $roles = [
            config('app.super_admin_role_name'),
            'organizer',
            'operator'
        ];
        foreach ($roles as $role) {
            $repo->create([
                'name' => $role
            ]);
        }
        // super-admin role
        $userRepo->find(1)->assignRole(1);
        // organizer role
        $userRepo->find(2)->assignRole(2);
        // operator role
        $userRepo->find(3)->assignRole(3);
    }
}
