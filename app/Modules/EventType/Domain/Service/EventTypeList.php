<?php

namespace App\Modules\EventType\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\EventType\Repository\EventTypeRepositoryInterface;

/**
 * EventTypeList service
 */
class EventTypeList extends BaseService
{
    private $repo;

    public function __construct(EventTypeRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke($request)
    {
        $data = $this->repo->all();
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
