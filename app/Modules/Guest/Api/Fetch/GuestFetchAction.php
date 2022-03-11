<?php

namespace App\Modules\Guest\Api\Fetch;

use App\Http\Controllers\Controller;
use App\Modules\Guest\Domain\Service\GuestFetch;
use Illuminate\Http\Request;

/**
 * GuestFetchAction
 */
class GuestFetchAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(GuestFetch $domain, GuestFetchResponder $responder)
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
