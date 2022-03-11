<?php

namespace App\Modules\Event\Api\Create;

use App\Http\Controllers\Controller;
use App\Modules\Event\Domain\Service\EventCreate;
use Illuminate\Http\Request;

/**
 * EventCreateAction
 */
class EventCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventCreate $domain, EventCreateResponder $responder)
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
