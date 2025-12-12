<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventParticipation extends Model
{
    protected $table = 'event_participation';
    protected $primaryKey = 'partptn_id';
    public $incrementing = true;
    protected $keyType = 'int';
    
    protected $fillable = [
        'vol_id',
        'evt_id',
        'status'
    ];

    public function volunteer() {
        return $this->belongsTo(Volunteer::class, 'vol_id');
    }

    public function event() {
        return $this->belongsTo(Event::class, 'evt_id');
    }
}
