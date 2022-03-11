<?php

namespace App\Modules\EventParticipant\Api\Fetch;

use App\Http\Controllers\Controller;
use App\Modules\EventParticipant\Domain\Service\EventParticipantFetch;
use Illuminate\Http\Request;

/**
 * EventParticipantFetchAction
 */
class EventParticipantFetchAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventParticipantFetch $domain, EventParticipantFetchResponder $responder)
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
