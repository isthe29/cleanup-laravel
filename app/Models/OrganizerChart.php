<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizerChart extends Model
{
    protected $table = 'organizer_chart';
    protected $primaryKey = 'org_chart_id';
    public $incrementing = true; // if true remember to not add in $fillable
    protected $keyType = 'int';
    
    protected $fillable = [
        'org_id',
        'month',
        'evts_orgzd_count',
        'totl_partpts_count'
    ];

    public function organizer(){
        return $this->belongsTo(Organizer::class, 'org_id');
    }

}
