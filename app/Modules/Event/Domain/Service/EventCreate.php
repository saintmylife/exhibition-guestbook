<?php

namespace App\Modules\Event\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Domain\EventFilter;
use App\Modules\Event\EventDto;
use App\Modules\Event\Repository\EventRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

/**
 * EventCreate domain
 */
class EventCreate extends BaseService
{
    private $filter;
    private $repo;

    public function __construct(EventFilter $filter, EventRepositoryInterface $repo)
    {
        $this->filter = $filter;
        $this->repo = $repo;
    }

    public function __invoke(array $data): Payload
    {
        $eventDto = $this->makeDto($data, new EventDto);

        if (!$this->filter->forInsert($eventDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        if ($this->repo->countActiveEvent() == 0) {
            $eventDto->isActive = true;
        }

        $create = $this->repo->create($eventDto->getData());

        if ($create->event_type_id == 1) {
            $path = $eventDto->date . '-' . \Str::slug($create->name);
            Storage::disk('public')->makeDirectory('events/' . $path);
        }

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
