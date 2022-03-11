<?php

namespace App\Modules\Event\Api\Edit;

use App\Http\Controllers\Controller;
use App\Modules\Event\Domain\Service\EventEdit;
use Illuminate\Http\Request;

/**
 * EventEditAction
 */
class EventEditAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventEdit $domain, EventEditResponder $responder)
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
