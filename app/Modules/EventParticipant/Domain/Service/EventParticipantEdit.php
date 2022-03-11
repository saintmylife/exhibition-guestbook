<?php

namespace App\Modules\EventParticipant\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Domain\Service\EventFetch;
use App\Modules\Event\Repository\EventRepositoryInterface;
use App\Modules\EventParticipant\Domain\EventParticipantFilter;
use App\Modules\EventParticipant\EventParticipantDto;
use App\Modules\EventParticipant\Jobs\ProccessThumbnail;
use App\Modules\EventParticipant\Repository\EventParticipantRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * EventParticipantEdit service
 */
class EventParticipantEdit extends BaseService
{
    private $filter;
    private $repo;
    private $eventRepo;

    public function __construct(EventParticipantFilter $filter, EventParticipantRepositoryInterface $repo, EventRepositoryInterface $eventRepo)
    {
        $this->filter = $filter;
        $this->repo = $repo;
        $this->eventRepo = $eventRepo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $event = $this->eventRepo->getActiveEvent();
        if ($event->event_type->name != 'Exhibition') {
            $messages = 'Invalid Event Type';
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        $eventParticipantDto = $this->makeDto($data, new EventParticipantDto);
        $eventParticipantDto->id = $id;
        $eventParticipantDto->event_id = $event->id;

        try {
            $eventParticipant = $this->repo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }

        if (!$this->filter->forUpdate($eventParticipantDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        if (is_file($eventParticipantDto->thumb)) {
            $path = $event->asset_path . 'participants/';
            \Storage::disk('public')->delete($path . $eventParticipant->thumb);
            \Storage::disk('public')->putFile($path, $eventParticipantDto->thumb);
            $eventParticipantDto->thumb = $eventParticipantDto->thumb->hashName();
            ProccessThumbnail::dispatch($path . $eventParticipantDto->thumb)->onQueue('medium');
        } else {
            $eventParticipantDto->thumb = $eventParticipant->thumb;
        }
        $update = $this->repo->update($eventParticipantDto->getData(), $id);

        return $this->newPayload(Payload::STATUS_UPDATED, compact('update'));
    }
}
