<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrashCollectionRecord extends Model
{
    protected $table = 'trash_collection_record';
    protected $primaryKey = 'record_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'partptn_id',
        'collected_kg',
        'date_recorded'
    ];

    public function participation() {
        return $this->belongsTo(EventParticipation::class, 'partptn_id');
    }
}
