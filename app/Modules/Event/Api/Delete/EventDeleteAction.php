<?php

namespace App\Modules\Event\Api\Delete;

use App\Http\Controllers\Controller;
use App\Modules\Event\Domain\Service\EventDelete;

/**
 * Event action
 */
class EventDeleteAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventDelete $domain, EventDeleteResponder $responder)
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
