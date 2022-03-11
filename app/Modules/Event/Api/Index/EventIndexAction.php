<?php

namespace App\Modules\Event\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\Event\Domain\Service\EventList;
use Illuminate\Http\Request;


/**
 * EventIndexAction
 */
class EventIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventList $domain, EventIndexResponder $responder)
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
