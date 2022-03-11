<?php

namespace App\Modules\Guest\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\Guest\Domain\Service\GuestList;
use Illuminate\Http\Request;


/**
 * GuestIndexAction
 */
class GuestIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(GuestList $domain, GuestIndexResponder $responder)
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
