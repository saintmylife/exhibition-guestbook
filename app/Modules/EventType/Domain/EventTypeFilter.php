<?php

namespace App\Modules\EventType\Domain;

use App\Modules\Base\BaseDto;
use App\Modules\Base\Domain\BaseFilter;
use Illuminate\Validation\Rule;

/**
 * EventType filter
 */
class EventTypeFilter extends BaseFilter
{
    const TABLE_NAME = 'event_types';

    public function forInsert(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        array_push($this->rules['name'], Rule::unique(self::TABLE_NAME, 'name'));
        return $this->basic($data);
    }
    public function forUpdate(BaseDto $data): bool
    {
        $this->messages = [];
        $this->setBasicRule();
        array_push($this->rules['name'], Rule::unique(self::TABLE_NAME, 'name')->ignore($data->id));
        return $this->basic($data);
    }

    protected function setBasicRule()
    {
        $this->rules = [
            'name'  => ['required', 'min:3', 'string']
        ];
    }
}
