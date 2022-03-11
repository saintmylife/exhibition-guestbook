<?php

namespace App\Modules\Presence\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\Presence\Domain\Service\PresenceList;
use Illuminate\Http\Request;


/**
 * PresenceIndexAction
 */
class PresenceIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(PresenceList $domain, PresenceIndexResponder $responder)
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
