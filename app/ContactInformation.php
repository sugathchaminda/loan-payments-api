<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class ContactInformation extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contact_information';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'country_code', 'contact_number', 'user_id', 'contact_type_id', 'status'
    ];

    /**
     * Get the contact type that owns the contact information.
     */
    public function contactType()
    {
        return $this->belongsTo('App\ContactType');
    }

    /**
     * Get the user that owns the contact information.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}