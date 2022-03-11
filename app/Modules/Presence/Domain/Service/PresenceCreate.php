<?php

namespace App\Modules\Presence\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Common\Domain\PresencePayload;
use App\Modules\Event\Repository\EventRepositoryInterface;
use App\Modules\Guest\Domain\Service\GuestFetch;
use App\Modules\Guest\Repository\GuestRepositoryInterface;
use App\Modules\Presence\Domain\PresenceFilter;
use App\Modules\Presence\PresenceDto;
use App\Modules\Presence\Repository\PresenceRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * PresenceCreate domain
 */
class PresenceCreate extends BaseService
{
    private $filter;
    private $repo;
    private $eventRepo;
    private $guestRepo;

    public function __construct(PresenceFilter $filter, PresenceRepositoryInterface $repo, EventRepositoryInterface $eventRepo, GuestRepositoryInterface $guestRepo)
    {
        $this->filter = $filter;
        $this->repo = $repo;
        $this->eventRepo = $eventRepo;
        $this->guestRepo = $guestRepo;
    }

    public function __invoke(string $code, array $data): Payload
    {
        $event = $this->eventRepo->getActiveEvent();

        try {
            $guest = $this->guestRepo->findGuestByCode($event->id, $code);
        } catch (ModelNotFoundException $e) {
            return $this->newPayload(PresencePayload::STATUS_CODE_NOT_FOUND, compact('code'));
        }

        $presenceDto = $this->makeDto($data, new PresenceDto);
        $presenceDto->event_id = $event->id;
        $presenceDto->guest_id = $guest->id;

        if (!$this->filter->forInsert($presenceDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        if ($presenceDto->description['type'] == 'in') {
            $presenceDto->description = \Arr::except($presenceDto->description, 'price');
        }
        $presenceDto->scanned_at = now();
        $create = $this->repo->create($presenceDto->getData());

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
