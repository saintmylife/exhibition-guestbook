<?php

namespace App\Modules\EventParticipant\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Repository\EventRepositoryInterface;
use App\Modules\EventParticipant\Repository\EventParticipantRepositoryInterface;

/**
 * EventParticipantList service
 */
class EventParticipantList extends BaseService
{
    private $repo;
    private $eventRepo;

    public function __construct(EventParticipantRepositoryInterface $repo, EventRepositoryInterface $eventRepo)
    {
        $this->repo = $repo;
        $this->eventRepo = $eventRepo;
    }

    public function __invoke($request)
    {
        $event = $this->eventRepo->getActiveEvent();
        $data = $this->repo->whereHas('event', function ($query) {
            return $query->where('event_type_id', 1);
        })->where('event_id', $event->id)
            ->paginate(isset($request['per_page']) ? $request['per_page'] : 10);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
