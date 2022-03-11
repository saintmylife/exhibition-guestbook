<?php

namespace App\Modules\Event\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Domain\EventFilter;
use App\Modules\Event\EventDto;
use App\Modules\Event\Repository\EventRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * EventEdit service
 */
class EventEdit extends BaseService
{
    private $filter;
    private $repo;

    public function __construct(EventFilter $filter, EventRepositoryInterface $repo)
    {
        $this->filter = $filter;
        $this->repo = $repo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $eventDto = $this->makeDto($data, new EventDto);
        $eventDto->id = $id;

        try {
            $event = $this->repo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }

        if (!$this->filter->forUpdate($eventDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        $eventDto->isActive = $event->isActive;
        $oldPath = $event->date . '-' . \Str::slug($event->name);
        $newPath = null;

        $event->date = $eventDto->date;
        $event->name = $eventDto->name;
        ($event->isDirty('date')) ? $newPath .= $eventDto->date : $newPath .= $event->date;
        ($event->isDirty('name')) ? $newPath .= '-' . \Str::slug($eventDto->name) : $newPath .=  '-' . \Str::slug($event->name);

        $update = $this->repo->update($eventDto->getData(), $id);
        if ($newPath != $oldPath) {
            \Storage::disk('public')->move('events/' . $oldPath, 'events/' . $newPath);
        }

        return $this->newPayload(Payload::STATUS_UPDATED, compact('update'));
    }
}
