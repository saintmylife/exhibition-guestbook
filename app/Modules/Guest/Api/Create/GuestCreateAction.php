<?php

namespace App\Modules\Guest\Api\Create;

use App\Http\Controllers\Controller;
use App\Modules\Guest\Domain\Service\GuestCreate;
use Illuminate\Http\Request;

/**
 * GuestCreateAction
 */
class GuestCreateAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(GuestCreate $domain, GuestCreateResponder $responder)
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
