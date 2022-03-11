<?php

namespace App\Modules\Presence\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Common\Domain\PresencePayload;
use App\Modules\Event\Repository\EventRepositoryInterface;
use App\Modules\Presence\PresenceDto;
use App\Modules\Presence\Repository\PresenceRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * Presence delete
 */
class PresenceFetch extends BaseService
{
    private $repo;
    private $eventRepo;

    public function __construct(PresenceRepositoryInterface $repo, EventRepositoryInterface $eventRepo)
    {
        $this->repo = $repo;
        $this->eventRepo = $eventRepo;
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = $this->repo->whereHas('event_participant', function ($query) {
                $query->whereHas('event', function ($event) {
                    $event->where('isActive', true);
                });
            })->with(['event_participant', 'guest'])->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
