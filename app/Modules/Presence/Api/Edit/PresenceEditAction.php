<?php

namespace App\Modules\Presence\Api\Edit;

use App\Http\Controllers\Controller;
use App\Modules\Presence\Domain\Service\PresenceEdit;
use Illuminate\Http\Request;

/**
 * PresenceEditAction
 */
class PresenceEditAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(PresenceEdit $domain, PresenceEditResponder $responder)
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
