<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'evt_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable  = [
        'org_id',
        'evt_name',
        'evt_date',
        'evt_details',
        'trsh_collected_kg'
    ];

    public function location() {
        //rs parent: 1:1, hasOne; 1:N, hasMany(like as in many rows in table); child: belongsTo;
        return $this->hasOne(EventLocation::class, 'evt_id', 'evt_id'); //child, parent
    } 

    public function participation() {
        return $this->hasMany(EventParticipation::class, 'evt_id'); //normal for pk != fk
    }

}
