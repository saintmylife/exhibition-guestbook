<?php

namespace Database\Seeders;

use App\Modules\Permission\Repository\PermissionRepositoryInterface;
use App\Modules\Role\Repository\RoleRepositoryInterface;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(PermissionRepositoryInterface $repo, RoleRepositoryInterface $roleRepo)
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'user-access',
            'read-events',
            'read-guests',
            'export-guests',
            'read-presences',
            'scan-presences',
            'read-doorprizes',
        ];

        foreach ($permissions as $permission) {
            $repo->create(['name' => $permission]);
        }

        $organizer = $roleRepo->find(2);
        $organizer->syncPermissions(array_diff($permissions, ['scan-presences']));

        $operator = $roleRepo->find(3);
        $operator->syncPermissions(array_diff($permissions, ['user-access', 'export-guests']));
    }
}
