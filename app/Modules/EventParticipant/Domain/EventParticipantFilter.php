<?php

namespace App\Modules\EventParticipant\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

/**
 * EventParticipant filter
 */
class EventParticipantFilter extends BaseFilter
{
    const TABLE_NAME = 'event_participants';
    public function forInsert(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        array_push($this->rules['name'], Rule::unique(self::TABLE_NAME, 'name')->where('event_id', $data->event_id));
        return $this->basic($data);
    }
    public function forUpdate(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        array_push($this->rules['name'], Rule::unique(self::TABLE_NAME, 'name')->where('event_id', $data->event_id)->ignore($data->id));
        return $this->basic($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'event_id' => ['required', 'bail', 'numeric', 'exists:events,id'],
            'name'  => ['required', 'string', 'min:2'],
            'thumb'  => ['nullable', 'image', 'max:10240']
        ];
    }
}
