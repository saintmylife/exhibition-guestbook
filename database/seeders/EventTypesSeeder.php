<?php

namespace Database\Seeders;

use App\Modules\EventType\Repository\EventTypeRepositoryInterface;
use Illuminate\Database\Seeder;

class EventTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(EventTypeRepositoryInterface $repo)
    {
        $repo->create(
            ['name' => 'Exhibition']
        );
    }
}
