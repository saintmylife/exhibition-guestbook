<?php

namespace App\Modules\EventParticipant\Api\Create;

use App\Http\Controllers\Controller;
use App\Modules\EventParticipant\Domain\Service\EventParticipantCreate;
use Illuminate\Http\Request;

/**
 * EventParticipantCreateAction
 */
class EventParticipantCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventParticipantCreate $domain, EventParticipantCreateResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
