<?php

namespace App\Modules\Guest;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'details' => 'array'
    ];

    public function event()
    {
        return $this->belongsTo('App\Modules\Event\Event');
    }
    public function event_participants()
    {
        return $this->belongsToMany('App\Modules\EventParticipant\EventParticipant', 'presences')
            ->as('presences')
            ->withPivot('type', 'scanned_at');
    }
    public function presence()
    {
        return $this->hasMany('App\Modules\Presence\Presence');
    }
    public function doorprize()
    {
        return $this->hasMany('App\Modules\Doorprize\Doorprize');
    }
}
