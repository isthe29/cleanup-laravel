<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organizer extends Model
{
    protected $table = 'organizer';
    protected $primaryKey = 'org_id';
    public $incrementing = false; // if false means fk or not initialized not A.I; add to $fillable 
    protected $keytype = 'int';

    protected $fillable = [
        'org_id',
        'org_name',
        'totl_evts_orgzd',
        'totl_trsh_collected_kg',
        'totl_partpts_overall'
    ];

    public function user() {
        return $this->belongsTo(User::class,'org_id', 'usr_id');
    }

    public function orgChart() {
        return $this->hasMany(OrganizerChart::class, 'org_id');
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'org_id', 'org_id');
    }

}
