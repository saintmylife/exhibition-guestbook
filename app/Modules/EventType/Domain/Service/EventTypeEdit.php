<?php

namespace App\Modules\EventType\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\EventType\Domain\EventTypeFilter;
use App\Modules\EventType\EventTypeDto;
use App\Modules\EventType\Repository\EventTypeRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * EventTypeEdit service
 */
class EventTypeEdit extends BaseService
{
    private $filter;
    private $repo;

    public function __construct(EventTypeFilter $filter, EventTypeRepositoryInterface $repo)
    {
        $this->filter = $filter;
        $this->repo = $repo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $eventTypeDto = $this->makeDto($data, new EventTypeDto);
        $eventTypeDto->id = $id;

        try {
            $eventType = $this->repo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }

        if (!$this->filter->forUpdate($eventTypeDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        $dataForDb = $eventTypeDto->getData();

        $update = $this->repo->update($dataForDb, $id);

        return $this->newPayload(Payload::STATUS_UPDATED, compact('update'));
    }
}
