<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerChart extends Model
{
    protected $table = 'volunteer_chart';
    protected $primaryKey = 'vol_chart_id';
    public $incrementing = false;
    protected $keyType = 'int';

    protected $fillable = [
        'vol_id',
        'month',
        'evts_partd_count'
    ];

    public function volunteer() {
        return $this->belongsTo(Volunteer::class, 'vol_id');
    }
}
