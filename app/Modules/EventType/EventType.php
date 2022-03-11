<?php

namespace App\Modules\EventType;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    public $timestamps = false;
}
