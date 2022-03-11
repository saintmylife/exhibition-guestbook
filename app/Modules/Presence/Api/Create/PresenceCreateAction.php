<?php

namespace App\Modules\Presence\Api\Create;

use App\Http\Controllers\Controller;
use App\Modules\Presence\Domain\Service\PresenceCreate;
use Illuminate\Http\Request;

/**
 * PresenceCreateAction
 */
class PresenceCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(PresenceCreate $domain, PresenceCreateResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request, string $code)
    {
        $payload = $this->domain->__invoke($code, $request->all());
        return $this->responder->__invoke($payload);
    }
}
