<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_role', 'description', 'status'
    ];

    /**
     * Get the users for the user role.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }
}