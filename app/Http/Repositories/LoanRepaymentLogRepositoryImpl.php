<?php

namespace App\Http\Repositories;


use App\LoanRepaymentLog;

class LoanRepaymentLogRepositoryImpl implements LoanRepaymentLogRepository
{

    private $loanRepaymentLog;

    /**
     * Create a new controller instance.
     *
     * @param LoanRepaymentLog $loanRepaymentLog
     */
    public function __construct(LoanRepaymentLog $loanRepaymentLog)
    {
        $this->loanRepaymentLog = $loanRepaymentLog;
    }

    /**
     * @param array $paymentLog
     * @return LoanRepaymentLog
     */
    public function insertRepaymentLog(array $paymentLog)
    {
        $this->loanRepaymentLog->payed_amount = $paymentLog["payedAmount"];
        $this->loanRepaymentLog->loan_balance_amount = $paymentLog["loanBalanceAmount"];
        $this->loanRepaymentLog->payed_date = $paymentLog["payedDate"];
        $this->loanRepaymentLog->loan_id = $paymentLog["loanId"];
        $this->loanRepaymentLog->status = 1;

        $this->loanRepaymentLog->save();

        return $this->loanRepaymentLog;
    }
}