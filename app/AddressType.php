<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class AddressType extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'address_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address_type', 'status'
    ];

    /**
     * Get the addresses for the address type.
     */
    public function addresses()
    {
        return $this->hasMany('App\UserAddress');
    }
}