<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $table = 'user_details';
    protected $primaryKey = 'usr_id';
    public $incrementing = false;
    protected $keyType = 'int';
    
    protected $fillable = [
        'usr_id',
        'email_add',
        'contact_num',
        'address'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'usr_id', 'usr_id');
    }
}
