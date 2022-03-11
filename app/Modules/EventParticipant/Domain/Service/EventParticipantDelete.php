<?php

namespace App\Modules\EventParticipant\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\EventParticipant\Repository\EventParticipantRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * EventParticipant delete
 */
class EventParticipantDelete extends BaseService
{
    private $fetch;
    private $repo;

    public function __construct(EventParticipantFetch $fetch, EventParticipantRepositoryInterface $repo)
    {
        $this->fetch = $fetch;
        $this->repo = $repo;
    }

    public function __invoke(int $id): Payload
    {
        $eventParticipant = $this->fetch->__invoke($id);
        if ($eventParticipant->getStatus() != 'FOUND') {
            return $eventParticipant;
        }
        $eventParticipant = $eventParticipant->getResult()['data'];
        \Storage::disk('public')->delete($eventParticipant->event->asset_path . 'participants/' . $eventParticipant->thumb);

        $this->repo->delete($id);
        $message = 'eventParticipant deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
