<?php

namespace Database\Seeders;

use App\Modules\User\Repository\UserRepositoryInterface;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(UserRepositoryInterface $repo)
    {
        $repo->create([
            'username' => 'admin',
            'name' => 'Mr. Admin',
            'password' => bcrypt('digital0207'),
        ]);
        $repo->create([
            'username' => 'organizer',
            'name' => 'Mr. Organizer',
            'password' => bcrypt('organizer1234'),
        ]);
        $repo->create([
            'username' => 'operator',
            'name' => 'Mr. Operator',
            'password' => bcrypt('operator4321'),
        ]);
    }
}
