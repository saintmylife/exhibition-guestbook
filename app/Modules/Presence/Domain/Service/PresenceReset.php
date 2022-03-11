<?php

namespace App\Modules\Presence\Domain\Service;

use App\Modules\Auth\AuthDto;
use App\Modules\Auth\Domain\AuthFilter;
use App\Modules\Base\Domain\BaseService;
use App\Modules\Common\Domain\AuthPayload;
use App\Modules\Common\Domain\Payload;
use App\Modules\Event\Repository\EventRepositoryInterface;
use App\Modules\Presence\Jobs\ResetPresence;
use App\Modules\Presence\Repository\PresenceRepositoryInterface;

class PresenceReset extends BaseService
{
    private $authFilter;
    private $repo;
    private $eventRepo;

    public function __construct(AuthFilter $authFilter, PresenceRepositoryInterface $repo, EventRepositoryInterface $eventRepo)
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
            return $this->newPayload(AuthPayload::STATUS_AUTH_NOT_VALID, compact('messages', 'data'));
        }
        if (!\Hash::check($authDto->password, auth()->user()->getAuthPassword())) {
            $messages = 'Your credentials is invalid';
            return $this->newPayload(AuthPayload::STATUS_AUTH_NOT_VALID, compact('messages'));
        }

        ResetPresence::dispatch($this->eventRepo->getActiveEvent()->id)->onQueue('high');

        $message = 'presence resetted on progress';
        return $this->newPayload(Payload::STATUS_DELETED, compact('message'));
    }
}
