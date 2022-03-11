<?php

namespace App\Modules\Doorprize\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Doorprize\Repository\DoorprizeRepositoryInterface;
use App\Modules\Event\Repository\EventRepositoryInterface;

/**
 * DoorprizeList service
 */
class DoorprizeList extends BaseService
{
    private $repo;
    private $eventRepo;

    public function __construct(DoorprizeRepositoryInterface $repo, EventRepositoryInterface $eventRepo)
    {
        $this->repo = $repo;
        $this->eventRepo = $eventRepo;
    }

    public function __invoke($request)
    {
        $data = $this->repo->select('id', 'event_id', 'guest_id', 'created_at')
            ->where('event_id', $this->eventRepo->getActiveEvent()->id)
            ->with('guest:id,name', 'event:id,name')
            ->paginate(isset($request['per_page']) ? $request['per_page'] : 10);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
