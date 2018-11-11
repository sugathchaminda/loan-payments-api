<?php

namespace App\Http\Repositories;


interface LoanRepository
{
    public function addLoanForUser(array $loan);

    public function getLoanById($loanId,$userId);

    public function updateRemainingInstallmentsLoanBalance(array $values);

    public function getLoansWithFilters(\Illuminate\Http\Request $request);
}