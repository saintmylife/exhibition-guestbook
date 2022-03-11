<?php

namespace App\Modules\EventType\Api\Create;

use App\Http\Controllers\Controller;
use App\Modules\EventType\Domain\Service\EventTypeCreate;
use Illuminate\Http\Request;

/**
 * EventTypeCreateAction
 */
class EventTypeCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventTypeCreate $domain, EventTypeCreateResponder $responder)
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
