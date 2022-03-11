<?php

namespace App\Modules\EventParticipant\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Repository\EventRepositoryInterface;
use App\Modules\EventParticipant\Repository\EventParticipantRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * EventParticipant delete
 */
class EventParticipantFetch extends BaseService
{
    private $repo;
    private $eventRepo;

    public function __construct(EventParticipantRepositoryInterface $repo, EventRepositoryInterface $eventRepo)
    {
        $this->repo = $repo;
        $this->eventRepo = $eventRepo;
    }

    public function __invoke(int $id): Payload
    {
        $event = $this->eventRepo->getActiveEvent();
        try {
            $data = $this->repo->whereHas('event', function ($query) use ($event) {
                return $query->where('id', $event->id);
            })->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
