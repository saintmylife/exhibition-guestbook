<?php

namespace App\Modules\Presence\Api\Delete;

use App\Http\Controllers\Controller;
use App\Modules\Presence\Domain\Service\PresenceDelete;

/**
 * Presence action
 */
class PresenceDeleteAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(PresenceDelete $domain, PresenceDeleteResponder $responder)
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
