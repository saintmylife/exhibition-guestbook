<?php

namespace App\Modules\Presence\Api\Reset;

use App\Http\Controllers\Controller;
use App\Modules\Presence\Domain\Service\PresenceReset;
use Illuminate\Http\Request;

/**
 * Presence action
 */
class PresenceResetAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(PresenceReset $domain, PresenceResetResponder $responder)
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
