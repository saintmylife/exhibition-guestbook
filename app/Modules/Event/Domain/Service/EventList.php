<?php

namespace App\Modules\Event\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Repository\EventRepositoryInterface;

/**
 * EventList service
 */
class EventList extends BaseService
{
    private $repo;

    public function __construct(EventRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke($request)
    {
        $data = $this->repo->paginate(isset($request['per_page']) ? $request['per_page'] : 10);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
