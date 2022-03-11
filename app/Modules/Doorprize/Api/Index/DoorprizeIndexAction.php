<?php

namespace App\Modules\Doorprize\Api\Index;

use App\Http\Controllers\Controller;
use App\Modules\Doorprize\Domain\Service\DoorprizeList;
use Illuminate\Http\Request;


/**
 * DoorprizeIndexAction
 */
class DoorprizeIndexAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(DoorprizeList $domain, DoorprizeIndexResponder $responder)
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
