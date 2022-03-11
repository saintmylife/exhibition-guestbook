<?php

namespace App\Modules\Event\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Repository\EventRepositoryInterface;

class EventDashboard extends BaseService
{
    private $repo;
    public function __construct(EventRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }
    public function __invoke(): Payload
    {
        $data = $this->repo->withCount([
            'participant', 'guest',
            'presence as presence_in_count' => function ($in) {
                $in->where('description->type', 'in');
            },
            'presence as presence_deal_count' => function ($deal) {
                $deal->where('description->type', 'deal');
            }
        ])->with('participant')->where('isActive', true)->first();
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
