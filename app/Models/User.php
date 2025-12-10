<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'usr_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'usr_name',
        'password',
        'registered_as',
    ];

    // Hide password
    protected $hidden = [
        'password',
    ];

    //helper functions for user type
    public function isVolunteer()
    {
        return $this->registered_as === 'Volunteer';
    }

    public function isOrganizer()
    {
        return $this->registered_as === 'Organizer';
    }

    public function organizer() {
        return $this->hasOne(Organizer::class, 'org_id', 'usr_id');
    }
    public function volunteer() {
        return $this->hasOne(Volunteer::class, 'vol_id', 'usr_id');
    }

    public function details(){
        return $this->hasOne(UserDetail::class, 'usr_id', 'usr_id');
    }

}
