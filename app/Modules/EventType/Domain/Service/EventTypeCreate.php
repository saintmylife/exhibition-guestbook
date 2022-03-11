<?php

namespace App\Modules\EventType\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\EventType\Domain\EventTypeFilter;
use App\Modules\EventType\EventTypeDto;
use App\Modules\EventType\Repository\EventTypeRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * EventTypeCreate domain
 */
class EventTypeCreate extends BaseService
{
    private $filter;
    private $repo;

    public function __construct(EventTypeFilter $filter, EventTypeRepositoryInterface $repo)
    {
        $this->filter = $filter;
        $this->repo = $repo;
    }

    public function __invoke(array $data): Payload
    {

        $eventTypeDto = $this->makeDto($data, new EventTypeDto);

        if (!$this->filter->forInsert($eventTypeDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        $create = $this->repo->create($eventTypeDto->getData());

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
