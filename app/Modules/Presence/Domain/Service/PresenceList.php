<?php

namespace App\Modules\Presence\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Presence\Repository\PresenceRepositoryInterface;

/**
 * PresenceList service
 */
class PresenceList extends BaseService
{
    private $repo;

    public function __construct(PresenceRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke($request)
    {
        $data = $this->repo->whereHas('event_participant', function ($query) {
            $query->whereHas('event', function ($event) {
                $event->where('isActive', true);
            });
        })->with(['event_participant:id,name', 'guest:id,code,name,phone'])
            ->paginate(isset($request['per_page']) ? $request['per_page'] : 50);
        // $data = $this->repo->paginate(isset($request['per_page']) ? $request['per_page'] : 100);
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
