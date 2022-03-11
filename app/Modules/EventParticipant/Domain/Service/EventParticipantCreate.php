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

/**
 * EventParticipantCreate domain
 */
class EventParticipantCreate extends BaseService
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

    public function __invoke(array $data): Payload
    {
        $event = $this->eventRepo->getActiveEvent();
        $eventParticipantDto = $this->makeDto($data, new EventParticipantDto);
        $eventParticipantDto->event_id = $event->id;

        if (!$this->filter->forInsert($eventParticipantDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        if (is_file($eventParticipantDto->thumb)) {
            $path = $event->asset_path . 'participants/';
            \Storage::disk('public')->putFile($path, $eventParticipantDto->thumb);
            $eventParticipantDto->thumb = $eventParticipantDto->thumb->hashName();
            ProccessThumbnail::dispatch($path . $eventParticipantDto->thumb)->onQueue('medium');
        }

        $create = $this->repo->create($eventParticipantDto->getData());

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
