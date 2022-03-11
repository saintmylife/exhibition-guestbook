<?php

namespace App\Modules\Doorprize\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Doorprize\Domain\DoorprizeFilter;
use App\Modules\Doorprize\DoorprizeDto;
use App\Modules\Doorprize\Repository\DoorprizeRepositoryInterface;
use App\Modules\Event\Repository\EventRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * DoorprizeCreate domain
 */
class DoorprizeCreate extends BaseService
{
    private $filter;
    private $repo;
    private $eventRepo;

    public function __construct(DoorprizeFilter $filter, DoorprizeRepositoryInterface $repo, EventRepositoryInterface $eventRepo)
    {
        $this->filter = $filter;
        $this->repo = $repo;
        $this->eventRepo = $eventRepo;
    }

    public function __invoke(array $data): Payload
    {
        $doorprizeDto = $this->makeDto($data, new DoorprizeDto);
        $event = $this->eventRepo->getActiveEvent();
        $doorprizeDto->event_id = $event->id;

        if (!$this->filter->forInsert($doorprizeDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        $create = $this->repo->create($doorprizeDto->getData());

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
