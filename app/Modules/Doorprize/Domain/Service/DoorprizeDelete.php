<?php

namespace App\Modules\Doorprize\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Doorprize\Repository\DoorprizeRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * Doorprize delete
 */
class DoorprizeDelete extends BaseService
{
    private $repo;

    public function __construct(DoorprizeRepositoryInterface $repo)
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

        $this->repo->delete($id);
        $message = 'doorprize deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
