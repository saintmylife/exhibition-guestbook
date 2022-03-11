<?php

namespace App\Modules\Event\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Domain\EventFilter;
use App\Modules\Event\Repository\EventRepositoryInterface;

class EventActive extends BaseService
{
    private $fetch;
    private $repo;

    public function __construct(EventFetch $fetch, EventRepositoryInterface $repo)
    {
        $this->fetch = $fetch;
        $this->repo = $repo;
    }
    public function __invoke(int $id, array $data): Payload
    {
        if (($event = $this->fetch->__invoke($id))->getStatus() != 'FOUND') {
            return $event;
        }

        $deactive = $this->repo->getActiveEvent();

        $this->repo->update([
            'isActive' => false
        ], $deactive->id);

        $update = $this->repo->update([
            'isActive' => true
        ], $id);
        return $this->newPayload(Payload::STATUS_UPDATED, compact('update'));
    }
}
