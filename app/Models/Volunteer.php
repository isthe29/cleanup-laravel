<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{   
    protected $table = 'volunteer';
    protected $primaryKey = 'vol_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'vol_id',
        'totl_evts_partd',
        'evt_curr_joined',
        'totl_trash_collected_kg'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'vol_id', 'usr_id'); //child and parent if pk = fk
    }

    public function participation() {
        return $this->hasMany(EventParticipation::class, 'vol_id');
    }

    public function volChart() {
        return $this->hasMany(VolunteerChart::class, 'vol_id');
    }




}
