<?php

namespace App\Modules\Guest\Api\Edit;

use App\Http\Controllers\Controller;
use App\Modules\Guest\Domain\Service\GuestEdit;
use Illuminate\Http\Request;

/**
 * GuestEditAction
 */
class GuestEditAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(GuestEdit $domain, GuestEditResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request, int $id)
    {
        $payload = $this->domain->__invoke($id, $request->all());
        return $this->responder->__invoke($payload);
    }
}
