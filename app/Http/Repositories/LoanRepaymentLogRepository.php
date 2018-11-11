<?php

namespace App\Http\Repositories;


interface LoanRepaymentLogRepository
{

    public function insertRepaymentLog(array $paymentLog);
}