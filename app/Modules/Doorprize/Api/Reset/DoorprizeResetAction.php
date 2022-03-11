<?php

namespace App\Modules\Doorprize\Api\Reset;

use App\Http\Controllers\Controller;
use App\Modules\Doorprize\Domain\Service\DoorprizeReset;
use Illuminate\Http\Request;

/**
 * Doorprize action
 */
class DoorprizeResetAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(DoorprizeReset $domain, DoorprizeResetResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->only('password'));
        return $this->responder->__invoke($payload);
    }
}
