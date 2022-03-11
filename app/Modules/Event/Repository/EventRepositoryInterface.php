<?php

namespace App\Modules\Event\Repository;

interface EventRepositoryInterface
{
    public function getActiveEvent();
    public function countActiveEvent();
}
