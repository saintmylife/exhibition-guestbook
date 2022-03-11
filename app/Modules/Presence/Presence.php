<?php

namespace App\Modules\Presence;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presence extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $casts = [
        'description' => 'array',
        'scanned_at' => 'datetime'
    ];

    public function event_participant()
    {
        return $this->belongsTo('App\Modules\EventParticipant\EventParticipant');
    }
    public function guest()
    {
        return $this->belongsTo('App\Modules\Guest\Guest');
    }
}
