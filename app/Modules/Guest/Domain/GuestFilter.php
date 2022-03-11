<?php

namespace App\Modules\Guest\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

/**
 * Guest filter
 */
class GuestFilter extends BaseFilter
{
    const TABLE_NAME = 'guests';

    public function forInsert(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        array_push($this->rules['code'], 'starts_with:' . $data->event_code);
        array_push($this->rules['code'], Rule::unique(self::TABLE_NAME, 'code')->where('event_id', $data->event_id));
        return $this->basic($data);
    }
    public function forUpdate(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        array_push($this->rules['code'], 'starts_with:' . $data->event_code);
        array_push($this->rules['code'], Rule::unique(self::TABLE_NAME, 'code')->where('event_id', $data->event_id)->ignore($data->id));
        return $this->basic($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'code' => ['required', 'string', 'min:6'],
            'name' => ['required', 'string', 'min:3'],
            'address' => ['required', 'string', 'min:3'],
            'phone' => ['required', 'numeric', 'min:8'],
            'details' => ['nullable', 'array', 'min:1'],
            'details.*' => ['required_with:details', 'string']
        ];
    }
}
