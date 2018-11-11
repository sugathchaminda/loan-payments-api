<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address_line1', 'address_line2', 'city', 'state', 'country', 'zip_code', 'user_id', 'address_type_id', 'status'
    ];

    /**
     * Get the contact type that owns the contact information.
     */
    public function addressType()
    {
        return $this->belongsTo('App\AddressType');
    }

    /**
     * Get the user that owns the contact information.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}