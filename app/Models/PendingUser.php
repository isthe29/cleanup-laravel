<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingUser extends Model
{
    use HasFactory;

    protected $table = 'pending_users';
    protected $primaryKey = 'usr_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'usr_name',
        'org_name',
        'password',
        'registered_as',
        'email_add',
        'verification_token',
        'remember_token',
    ];
}
