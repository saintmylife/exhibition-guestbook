<?php

namespace App\Modules\EventParticipant\Api\Delete;

use App\Http\Controllers\Controller;
use App\Modules\EventParticipant\Domain\Service\EventParticipantDelete;

/**
 * EventParticipant action
 */
class EventParticipantDeleteAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventParticipantDelete $domain, EventParticipantDeleteResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(int $id)
    {
        $payload = $this->domain->__invoke($id);
        return $this->responder->__invoke($payload);
    }
}
