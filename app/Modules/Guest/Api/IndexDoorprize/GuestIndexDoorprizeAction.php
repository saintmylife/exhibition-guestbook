<?php

namespace App\Modules\Guest\Api\IndexDoorprize;

use App\Http\Controllers\Controller;
use App\Modules\Guest\Domain\Service\GuestListDoorprize;
use Illuminate\Http\Request;


/**
 * GuestIndexDoorprizeAction
 */
class GuestIndexDoorprizeAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(GuestListDoorprize $domain, GuestIndexDoorprizeResponder $responder)
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
