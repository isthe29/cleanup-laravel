<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventLocation extends Model
{
    protected $table = 'event_location';
    protected $primaryKey = 'evt_id';
    public $incrementing = false;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable = [
        'evt_id',
        'map_details',
        'evt_loctn_name'
    ];

    public function event() {
        return $this->belongsTo(Event::class, 'evt_id','evt_id');
    }
}
