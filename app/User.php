<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'date_of_birth', 'gender', 'nic', 'user_role_id', 'status'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the user role that owns the users.
     */
    public function userRole()
    {
        return $this->belongsTo('App\UserRole');
    }

    /**
     * Get the contact information for the user.
     */
    public function contactInformation()
    {
        return $this->hasMany('App\ContactInformation');
    }

    /**
     * Get the user addresses for the user.
     */
    public function userAddresses()
    {
        return $this->hasMany('App\UserAddress');
    }

    /**
     * Get the loans for the user.
     */
    public function loans()
    {
        return $this->hasMany('App\Loan');
    }
}