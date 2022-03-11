<?php

namespace App\Modules\EventParticipant\Api\Edit;

use App\Http\Controllers\Controller;
use App\Modules\EventParticipant\Domain\Service\EventParticipantEdit;
use Illuminate\Http\Request;

/**
 * EventParticipantEditAction
 */
class EventParticipantEditAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventParticipantEdit $domain, EventParticipantEditResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request, int $id)
    {
        $payload = $this->domain->__invoke($id, $request->all());
        return $this->responder->__invoke($payload);
    }
}
