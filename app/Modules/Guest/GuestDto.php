<?php

namespace App\Modules\Guest;

use App\Modules\Base\BaseDto;

class GuestDto extends BaseDto
{
    protected $id;
    protected $code;
    protected $name;
    protected $address;
    protected $phone;
    protected $details;
    protected $event_id;
}
