<?php

namespace App\Http\Repositories;


use App\Loan;
use Illuminate\Http\Request;

class LoanRepositoryImpl implements LoanRepository
{

    private $loan;

    /**
     * Create a new controller instance.
     *
     * @param Loan $loan
     */
    public function __construct(Loan $loan)
    {
        $this->loan = $loan;
    }

    public function addLoanForUser(array $loan)
    {
        $this->loan->loan_amount = $loan["loanAmount"];
        $this->loan->arrangement_fee = $loan["arrangementFee"];
        $this->loan->duration = $loan["duration"];
        $this->loan->repayment_frequency = $loan["repaymentFrequency"];
        $this->loan->interest_rate = $loan["interestRate"];
        $this->loan->remaining_installments = $loan["remainingInstallments"];
        $this->loan->installment_amount = $loan["installmentAmount"];
        $this->loan->last_installment_date = $loan["payedDate"];
        $this->loan->loan_balance_amount = $loan["loanBalanceAmount"];
        $this->loan->user_id = $loan["userId"];
        $this->loan->status = 1;
        $this->loan->save();
        return $this->loan;
    }

    public function getLoanById($loanId, $userId)
    {
        return $this->loan->where('id', $loanId)->where("user_id", $userId)->first();
    }

    public function updateRemainingInstallmentsLoanBalance(array $values)
    {
        $loan = $this->loan->find($values["loanId"]);
        $loan->remaining_installments = $values["remainingInstallments"];
        $loan->loan_balance_amount = $values["loanBalanceAmount"];
        $loan->last_installment_date = $values["lastInstallmentDate"];
        $loan->save();
    }

    public function getLoansWithFilters(Request $request)
    {
        $loans = $this->loan->with(['LoanRepaymentLogs' => function ($query) {
            $query->where('status', 1);
        }]);
        if ($request->has("userId")) {
            $loans->where('user_id', $request->get("userId"));
        }
        if ($request->has("loanId")) {
            $loans->where('id', $request->get("loanId"));
        }
        $loans->where('status', 1);
        return $loans->paginate($request->get("pageSize"));
    }
}