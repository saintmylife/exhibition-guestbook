<?php

namespace App\Modules\Guest\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Repository\EventRepositoryInterface;
use App\Modules\Guest\Repository\GuestRepositoryInterface;

/**
 * GuestList service
 */
class GuestList extends BaseService
{
    private $repo;
    private $eventRepo;

    public function __construct(GuestRepositoryInterface $repo, EventRepositoryInterface $eventRepo)
    {
        $this->repo = $repo;
        $this->eventRepo = $eventRepo;
    }

    public function __invoke($request)
    {
        $data = $this->repo->withCount([
            'presence as presence_in' => function ($in) {
                $in->where('description->type', 'in');
            },
            'presence as presence_deal' => function ($in) {
                $in->where('description->type', 'deal');
            },
        ])->where('event_id', $this->eventRepo->getActiveEvent()->id)
            ->paginate(isset($request['per_page']) ? $request['per_page'] : 50);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
