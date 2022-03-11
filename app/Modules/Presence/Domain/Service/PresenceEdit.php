<?php

namespace App\Modules\Presence\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Presence\Domain\PresenceFilter;
use App\Modules\Presence\PresenceDto;
use App\Modules\Presence\Repository\PresenceRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * PresenceEdit service
 */
class PresenceEdit extends BaseService
{
    private $fetch;
    private $filter;
    private $repo;

    public function __construct(PresenceFetch $fetch, PresenceFilter $filter, PresenceRepositoryInterface $repo)
    {
        $this->fetch = $fetch;
        $this->filter = $filter;
        $this->repo = $repo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $presence = $this->fetch->__invoke($id);
        if ($presence->getStatus() != 'FOUND') {
            return $presence;
        }
        $presence = $presence->getResult()['data'];
        $presenceDto = $this->makeDto($data, new PresenceDto);
        $presenceDto->id = $id;
        $presenceDto->scanned_at = $presence->scanned_at;
        $presenceDto->guest_id = $presence->guest_id;
        $presenceDto->event_id = $presence->guest->event_id;
        $presenceDto->event_participant_id = $presence->event_participant_id;

        if (!$this->filter->forInsert($presenceDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        $update = $this->repo->update($presenceDto->getData(), $id);

        return $this->newPayload(Payload::STATUS_UPDATED, compact('update'));
    }
}
