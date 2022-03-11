<?php

namespace App\Modules\EventType\Api\Fetch;

use App\Http\Controllers\Controller;
use App\Modules\EventType\Domain\Service\EventTypeFetch;
use Illuminate\Http\Request;

/**
 * EventTypeFetchAction
 */
class EventTypeFetchAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventTypeFetch $domain, EventTypeFetchResponder $responder)
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
