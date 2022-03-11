<?php

namespace App\Modules\Guest\Domain\Service;

use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\Payload;
use App\Modules\Guest\Domain\GuestFilter;
use App\Modules\Guest\GuestDto;
use App\Modules\Guest\Repository\GuestRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Gate;
use \Illuminate\Auth\Access\AuthorizationException;

/**
 * GuestEdit service
 */
class GuestEdit extends BaseService
{
    private $fetch;
    private $filter;
    private $repo;

    public function __construct(GuestFetch $fetch, GuestFilter $filter, GuestRepositoryInterface $repo)
    {
        $this->fetch = $fetch;
        $this->filter = $filter;
        $this->repo = $repo;
    }

    public function __invoke(int $id, array $data): Payload
    {
        $guest = $this->fetch->__invoke($id);
        if ($guest->getStatus() != 'FOUND') {
            return $guest;
        }
        $guest = $guest->getResult()['data'];

        $guestDto = $this->makeDto($data, new GuestDto);
        $guestDto->id = $id;
        $guestDto->event_id = $guest->event_id;
        $guestDto->__set('event_code', $guest->event->code);
        $guestDto->__set('event_type', $guest->event->event_type->name);

        if (!$this->filter->forUpdate($guestDto)) {
            $messages = $this->filter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }

        if (\Str::startsWith($guestDto->phone, '0')) {
            $guestDto->phone = \Str::replaceFirst('0', '62', $guestDto->phone);
        }

        $update = $this->repo->update($guestDto->getData(), $id);

        return $this->newPayload(Payload::STATUS_UPDATED, compact('update'));
    }
}
