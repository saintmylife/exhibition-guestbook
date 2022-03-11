<?php

namespace App\Modules\Guest\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Domain\Service\EventFetch;
use App\Modules\Event\Repository\EventRepositoryInterface;
use App\Modules\Guest\Domain\GuestFilter;
use App\Modules\Guest\GuestDto;
use App\Modules\Guest\Repository\GuestRepositoryInterface;

/**
 * GuestCreate domain
 */
class GuestCreate extends BaseService
{
    private $filter;
    private $repo;
    private $eventRepo;

    public function __construct(EventFetch $eventFetch, GuestFilter $filter, GuestRepositoryInterface $repo, EventRepositoryInterface $eventRepo)
    {
        $this->eventFetch = $eventFetch;
        $this->filter = $filter;
        $this->repo = $repo;
        $this->eventRepo = $eventRepo;
    }

    public function __invoke(array $data): Payload
    {
        $event = $this->eventRepo->getActiveEvent();

        $guestDto = $this->makeDto($data, new GuestDto);
        $guestDto->event_id = $event->id;
        $guestDto->__set('event_code', $event->code);
        $guestDto->__set('event_type', $event->event_type->name);
        if ($guestDto->event_type == 'Exhibition') {
            $guestDto->code = $this->repo->generateGuestCode($event->id, $guestDto->event_code);
        }

        if (!$this->filter->forInsert($guestDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('data', 'messages'));
        }

        if (\Str::startsWith($guestDto->phone, '0')) {
            $guestDto->phone = \Str::replaceFirst('0', '62', $guestDto->phone);
        }

        $create = $this->repo->create($guestDto->getData());

        return $this->newPayload(Payload::STATUS_CREATED, compact('create'));
    }
}
