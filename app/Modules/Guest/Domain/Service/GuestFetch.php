<?php

namespace App\Modules\Guest\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Domain\Service\EventFetch;
use App\Modules\Event\Repository\EventRepositoryInterface;
use App\Modules\Guest\GuestDto;
use App\Modules\Guest\Repository\GuestRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * Guest delete
 */
class GuestFetch extends BaseService
{
    private $eventFetch;
    private $repo;
    private $eventRepo;

    public function __construct(EventFetch $eventFetch, GuestRepositoryInterface $repo, EventRepositoryInterface $eventRepo)
    {
        $this->eventFetch = $eventFetch;
        $this->repo = $repo;
        $this->eventRepo = $eventRepo;
    }

    public function __invoke(int $id): Payload
    {
        $event = $this->eventRepo->getActiveEvent();
        try {
            $data = $this->repo->whereHas('event', function ($query) use ($event) {
                $query->where('id', $event->id);
            })->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
