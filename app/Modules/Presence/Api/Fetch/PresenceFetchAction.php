<?php

namespace App\Modules\Presence\Api\Fetch;

use App\Http\Controllers\Controller;
use App\Modules\Presence\Domain\Service\PresenceFetch;
use Illuminate\Http\Request;

/**
 * PresenceFetchAction
 */
class PresenceFetchAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(PresenceFetch $domain, PresenceFetchResponder $responder)
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
