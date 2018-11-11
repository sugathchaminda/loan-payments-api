<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class LoanRepaymentLog extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'loan_repayment_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payed_amount', 'loan_balance_amount', 'payed_date', 'loan_id', 'status','last_installment_date'
    ];

    /**
     * Get the user role that owns the users.
     */
    public function loan()
    {
        return $this->belongsTo('App\Loan');
    }
}
