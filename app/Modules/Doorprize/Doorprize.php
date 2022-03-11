<?php

namespace App\Modules\Doorprize;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doorprize extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function guest()
    {
        return $this->belongsTo('App\Modules\Guest\Guest');
    }
    public function event()
    {
        return $this->belongsTo('App\Modules\Event\Event');
    }
}
