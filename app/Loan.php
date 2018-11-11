<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class Loan extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'loans';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'loan_amount',
        'arrangement_fee',
        'duration',
        'repayment_frequency',
        'interest_rate',
        'installment_amount'
        ,
        'loan_balance_amount',
        'user_id',
        'status',
        'last_installment_date',
        'remaining_installments'
    ];

    /**
     * Get the loan repayment logs for the loan.
     */
    public function loanRepaymentLogs()
    {
        return $this->hasMany('App\LoanRepaymentLog');
    }

    /**
     * Get the user that owns the loans.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
