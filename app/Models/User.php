<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'usr_id';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'usr_name',
        'password',
        'remember_token',
        'registered_as',

    ];

    // Hide password
    protected $hidden = [
        'password',
        'remember_token',
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

    public function sendEmailVerificationNotification(){
        $this->notify(new CustomVerifyEmail());
    }

    public function getEmailForVerification(){
        return $this->details ? $this->details->email_add : null;
    }


}
