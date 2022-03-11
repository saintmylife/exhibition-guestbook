<?php

namespace App\Modules\Guest\Api\Delete;

use App\Http\Controllers\Controller;
use App\Modules\Guest\Domain\Service\GuestDelete;

/**
 * Guest action
 */
class GuestDeleteAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(GuestDelete $domain, GuestDeleteResponder $responder)
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
