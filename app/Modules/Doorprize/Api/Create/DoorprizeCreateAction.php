<?php

namespace App\Modules\Doorprize\Api\Create;

use App\Http\Controllers\Controller;
use App\Modules\Doorprize\Domain\Service\DoorprizeCreate;
use Illuminate\Http\Request;

/**
 * DoorprizeCreateAction
 */
class DoorprizeCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(DoorprizeCreate $domain, DoorprizeCreateResponder $responder)
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
