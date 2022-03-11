<?php

namespace App\Modules\Doorprize\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

/**
 * Doorprize filter
 */
class DoorprizeFilter extends BaseFilter
{
    const TABLE_NAME = 'doorprizes';

    public function forInsert(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        array_push($this->rules['guest_id'], Rule::unique(self::TABLE_NAME, 'guest_id')->where('event_id', $data->event_id));
        return $this->basic($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'guest_id'  => ['required', 'bail', 'string', Rule::exists('presences', 'guest_id')->where('description->type', 'deal')],
            'event_id'  => ['required', 'numeric', Rule::exists('events', 'id')->where('isActive', true)]
        ];
    }
}
