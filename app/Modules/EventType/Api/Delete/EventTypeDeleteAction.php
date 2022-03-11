<?php

namespace App\Modules\EventType\Api\Delete;

use App\Http\Controllers\Controller;
use App\Modules\EventType\Domain\Service\EventTypeDelete;

/**
 * EventType action
 */
class EventTypeDeleteAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventTypeDelete $domain, EventTypeDeleteResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(int $id)
    {
        $payload = $this->domain->__invoke($id);
        return $this->responder->__invoke($payload);
    }
}
