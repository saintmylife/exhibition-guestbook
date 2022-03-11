<?php

namespace App\Modules\Event\Api\Fetch;

use App\Http\Controllers\Controller;
use App\Modules\Event\Domain\Service\EventFetch;
use Illuminate\Http\Request;

/**
 * EventFetchAction
 */
class EventFetchAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventFetch $domain, EventFetchResponder $responder)
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
