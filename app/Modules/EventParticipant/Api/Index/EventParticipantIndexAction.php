<?php

namespace App\Modules\EventParticipant\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\EventParticipant\Domain\Service\EventParticipantList;
use Illuminate\Http\Request;


/**
 * EventParticipantIndexAction
 */
class EventParticipantIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventParticipantList $domain, EventParticipantIndexResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }


    function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
