<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'event';
    protected $primaryKey = 'evt_id';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = true;

    protected $fillable  = [
        'org_id',
        'evt_name',
        'evt_date',
        'end_date',
        'status',
        'evt_details',
        'trsh_collected_kg'
    ];

    public function location() {
        //rs parent: 1:1, hasOne; 1:N, hasMany(like as in many rows in table); child: belongsTo;
        return $this->hasOne(EventLocation::class, 'evt_id', 'evt_id'); //child, parent
    } 

public function participants()
{
    return $this->belongsToMany(Volunteer::class, 'event_participation', 'evt_id', 'vol_id')
                ->withPivot('status', 'created_at', 'updated_at');
}



    public function organizer()
    {
        return $this->belongsTo(Organizer::class, 'org_id', 'org_id');
        // belongsTo(TargetModel::class, foreignKeyOnThisModel, ownerKeyOnTarget)
    }
}


