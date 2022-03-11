<?php

namespace App\Modules\EventParticipant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function event()
    {
        return $this->belongsTo('App\Modules\Event\Event');
    }
    public function guests()
    {
        return $this->belongsToMany('App\Modules\Guest\Guest', 'presences')->as('presences')->withPivot('type', 'scanned_at');
    }
    public function presence()
    {
        return $this->hasMany('App\Modules\Presence\Presence');
    }
}
