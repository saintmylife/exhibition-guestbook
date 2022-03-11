<?php

namespace App\Modules\Base\Domain\Responder;

use App\Modules\Base\Domain\BaseResponder;

abstract class PresenceResponder extends BaseResponder
{
    protected function codeNotFound(): void
    {
        $this->response = abort(
            response()->json([
                'status'    => false,
                'messages'  => 'Code : ' . $this->payload->getResult()['code'] . ' not found !!',
            ], 404)
        );
    }
}
