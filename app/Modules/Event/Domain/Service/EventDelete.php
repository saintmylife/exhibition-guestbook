<?php

namespace App\Modules\Event\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Repository\EventRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * Event delete
 */
class EventDelete extends BaseService
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

        $this->repo->delete($id);
        $path = $data->date . '-' . \Str::slug($data->name);
        \Storage::disk('public')->deleteDirectory('events/' . $path);
        $message = 'event deleted';
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
