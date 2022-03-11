<?php

namespace App\Modules\Presence;

use App\Modules\Base\BaseDto;

class PresenceDto extends BaseDto
{
    protected $id;
    protected $description;
    protected $scanned_at;
    protected $event_participant_id;
    protected $guest_id;
    protected $event_id;
}
