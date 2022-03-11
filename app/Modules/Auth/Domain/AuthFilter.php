<?php

namespace App\Modules\Auth\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;

/**
 * Auth filter
 */
class AuthFilter extends BaseFilter
{
    public function forLogin(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        return $this->basic($data);
    }
    public function forPasswordRoute(BaseDto $data): bool
    {
        $this->messages = [];
        $this->rules = [
            'password' => ['required']
        ];
        return $this->basic($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'username' => ['required', 'string'],
            'password' => ['required', 'string']
        ];
    }
}
