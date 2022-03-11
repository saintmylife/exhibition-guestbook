<?php

namespace App\Modules\Guest\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Guest\Repository\GuestRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * Guest delete
 */
class GuestDelete extends BaseService
{
    private $fetch;
    private $repo;

    public function __construct(GuestFetch $fetch, GuestRepositoryInterface $repo)
    {
        $this->fetch = $fetch;
        $this->repo = $repo;
    }

    public function __invoke(int $id): Payload
    {
        if (($guest = $this->fetch->__invoke($id))->getStatus() != 'FOUND') {
            return $guest;
        }

        $this->repo->delete($id);
        $message = 'guest deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
