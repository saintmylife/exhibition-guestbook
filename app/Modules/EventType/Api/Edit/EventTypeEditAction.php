<?php

namespace App\Modules\EventType\Api\Edit;

use App\Http\Controllers\Controller;
use App\Modules\EventType\Domain\Service\EventTypeEdit;
use Illuminate\Http\Request;

/**
 * EventTypeEditAction
 */
class EventTypeEditAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventTypeEdit $domain, EventTypeEditResponder $responder)
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
