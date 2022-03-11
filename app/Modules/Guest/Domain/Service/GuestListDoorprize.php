<?php

namespace App\Modules\Guest\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Repository\EventRepositoryInterface;
use App\Modules\Guest\Repository\GuestRepositoryInterface;

/**
 * GuestListDoorprize service
 */
class GuestListDoorprize extends BaseService
{
    private $repo;
    private $eventRepo;

    public function __construct(GuestRepositoryInterface $repo, EventRepositoryInterface $eventRepo)
    {
        $this->repo = $repo;
        $this->eventRepo = $eventRepo;
    }

    public function __invoke($request)
    {
        $event = $this->eventRepo->getActiveEvent();
        $data = $this->repo->whereHas('presence', function ($query) {
            $query->where('description->type', 'deal');
        })->whereDoesntHave('doorprize', function ($query) use ($event) {
            $query->where('event_id', $event->id);
        })->where('event_id', $event->id)
            ->select('code')
            ->get()
            ->pluck('code');
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
