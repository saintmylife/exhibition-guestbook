<?php

namespace App\Modules\Event\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Modules\Event\Domain\Service\EventDashboard;
use Illuminate\Http\Request;

/**
 * EventDashboardAction
 */
class EventDashboardAction extends Controller
{
    private $domain;
    private $responder;

    public function __construct(EventDashboard $domain, EventDashboardResponder $responder)
    {
        $this->domain = $domain;
        $this->responder = $responder;
    }

    public function __invoke(Request $request)
    {
        $payload = $this->domain->__invoke($request->all());
        return $this->responder->__invoke($payload);
    }
}
