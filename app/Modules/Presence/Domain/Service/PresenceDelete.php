<?php

namespace App\Modules\Presence\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Presence\Repository\PresenceRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * Presence delete
 */
class PresenceDelete extends BaseService
{
    private $fetch;
    private $repo;

    public function __construct(PresenceFetch $fetch, PresenceRepositoryInterface $repo)
    {
        $this->fetch = $fetch;
        $this->repo = $repo;
    }

    public function __invoke(int $id): Payload
    {
        if (($presence = $this->fetch->__invoke($id))->getStatus() != 'FOUND') {
            return $presence;
        }

        $this->repo->delete($id);
        $message = 'presence deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
