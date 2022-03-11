<?php

namespace App\Modules\Event\Api\Active;

use App\Http\Controllers\Controller;
use App\Modules\Event\Domain\Service\EventActive;
use Illuminate\Http\Request;

/**
 * EventActiveAction
 */
class EventActiveAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventActive $domain, EventActiveResponder $responder)
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
