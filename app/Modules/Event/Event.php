<?php

namespace App\Modules\Event;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'date' => 'datetime:Y-m-d',
        'isActive' => 'boolean',
    ];
    protected $appends = ['asset_path'];

    public function getAssetPathAttribute()
    {
        return 'events/' . $this->date . '-' . \Str::slug($this->name) . '/';
    }

    public function event_type()
    {
        return $this->belongsTo('App\Modules\EventType\EventType');
    }

    public function participant()
    {
        return $this->hasMany('App\Modules\EventParticipant\EventParticipant');
    }
    public function guest()
    {
        return $this->hasMany('App\Modules\Guest\Guest');
    }
    public function presence()
    {
        return $this->hasManyThrough('App\Modules\Presence\Presence', 'App\Modules\EventParticipant\EventParticipant');
    }
}
