<?php

namespace App\Modules\Doorprize\Api\Delete;

use App\Http\Controllers\Controller;
use App\Modules\Doorprize\Domain\Service\DoorprizeDelete;

/**
 * Doorprize action
 */
class DoorprizeDeleteAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(DoorprizeDelete $domain, DoorprizeDeleteResponder $responder)
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
