<?php

namespace App\Modules\Event\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

/**
 * Event filter
 */
class EventFilter extends BaseFilter
{
    const TABLE_NAME = 'events';

    public function forInsert(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        array_push($this->rules['code'], Rule::unique(self::TABLE_NAME, 'code')->where('isActive', true));
        return $this->basic($data);
    }
    public function forUpdate(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        array_push($this->rules['code'], Rule::unique(self::TABLE_NAME, 'code')->where('isActive', true)->ignore($data->id));
        return $this->basic($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'name'  => ['required', 'string', 'min:3'],
            'code'  => ['required', 'string', 'min:2'],
            'date' => ['required', 'date', 'date_format:Y-m-d'],
            'organizer' => ['nullable', 'string'],
            'event_type_id' => ['required', 'numeric', Rule::exists('event_types', 'id')]
        ];
    }
}
