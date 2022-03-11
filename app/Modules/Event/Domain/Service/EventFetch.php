<?php

namespace App\Modules\Event\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\EventDto;
use App\Modules\Event\Repository\EventRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * Event delete
 */
class EventFetch extends BaseService
{
    private $repo;

    public function __construct(EventRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function __invoke(int $id): Payload
    {
        try {
            $data = $this->repo->find($id);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(Payload::STATUS_NOT_FOUND, compact('id'));
        }
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}
