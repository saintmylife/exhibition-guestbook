<?php

namespace App\Modules\EventType\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\EventType\Domain\Service\EventTypeList;
use Illuminate\Http\Request;


/**
 * EventTypeIndexAction
 */
class EventTypeIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventTypeList $domain, EventTypeIndexResponder $responder)
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
