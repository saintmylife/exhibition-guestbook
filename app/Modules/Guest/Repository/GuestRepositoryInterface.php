<?php

namespace App\Modules\Guest\Repository;

interface GuestRepositoryInterface
{
    public function generateGuestCode(int $event_id, string $event_code);
    public function findGuestByCode(int $event_id, string $guest_code);
}
