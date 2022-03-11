<?php

namespace App\Modules\Presence\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

/**
 * Presence filter
 */
class PresenceFilter extends BaseFilter
{
    const TABLE_NAME = 'presences';
    public function forInsert(BaseDto $data): bool
    {
        $this->setDefaultRule($data);
        return $this->basic($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'description' => ['required', 'array', 'min:2'],
            'description.type' => ['required', 'in:in,deal'],
            'description.operator' => ['required', 'string'],
            'description.price' => ['required_unless:description.type,in', 'numeric'],
            'event_id'  => ['required', 'numeric', Rule::exists('events', 'id')->where('isActive', true)],
            'event_participant_id' => ['required', 'numeric'],
            'guest_id' => ['required', 'numeric'],
        ];
    }
    protected function setDefaultRule(BaseDto $data)
    {
        $this->messages = [
            'event_id.exists' => 'Event not found or inactive'
        ];
        $this->setBasicRule();
        array_push($this->rules['event_participant_id'], Rule::exists('event_participants', 'id')->where('event_id', $data->event_id));
        array_push($this->rules['guest_id'], Rule::exists('guests', 'id')->where('event_id', $data->event_id));
    }
}
