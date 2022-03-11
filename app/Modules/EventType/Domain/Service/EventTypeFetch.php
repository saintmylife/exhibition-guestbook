<?php

namespace App\Modules\EventType\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\EventType\EventTypeDto;
use App\Modules\EventType\Repository\EventTypeRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * EventType delete
 */
class EventTypeFetch extends BaseService
{
    private $repo;

    public function __construct(EventTypeRepositoryInterface $repo)
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
        try {
            Gate::authorize('owner', $data->user_id);
        } catch (AuthorizationException $e) {
            return $this->newPayload(Payload::STATUS_UNAUTHORIZED);
        }
        return $this->newPayload(Payload::STATUS_FOUND, compact('data'));
    }
}