<?php

namespace App\Modules\Event;

use App\Modules\Base\BaseDto;

class EventDto extends BaseDto
{
    protected $id;
    protected $name;
    protected $code;
    protected $date;
    protected $organizer = 'Redd One Digital';
    protected $isActive = false;
    protected $event_type_id;
}
