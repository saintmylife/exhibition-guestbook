<?php

namespace App\Modules\Doorprize\Domain\Service;

use App\Modules\Auth\AuthDto;
use App\Modules\Auth\Domain\AuthFilter;
use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\AuthPayload;
use App\Modules\Common\Domain\Payload;
use App\Modules\Doorprize\Repository\DoorprizeRepositoryInterface;
use App\Modules\Event\Repository\EventRepositoryInterface;

class DoorprizeReset extends BaseService
{
    private $authFilter;
    private $repo;
    private $eventRepo;

    public function __construct(AuthFilter $authFilter, DoorprizeRepositoryInterface $repo, EventRepositoryInterface $eventRepo)
    {
        $this->authFilter = $authFilter;
        $this->repo = $repo;
        $this->eventRepo = $eventRepo;
    }
    public function __invoke(array $data): Payload
    {
        $authDto = $this->makeDto($data, new AuthDto);
        if (!$this->authFilter->forPasswordRoute($authDto)) {
            $messages = $this->authFilter->getMessages();
            return $this->newPayload(Payload::STATUS_NOT_VALID, compact('messages', 'data'));
        }
        if (!\Hash::check($authDto->password, auth()->user()->getAuthPassword())) {
            $messages = 'Your credentials is invalid';
            return $this->newPayload(AuthPayload::STATUS_AUTH_NOT_VALID, compact('messages'));
        }
        $event = $this->eventRepo->getActiveEvent();

        $this->repo->deleteWhere(['event_id' => $event->id]);
        $message = 'doorprize resetted on event ' . $event->name;
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
