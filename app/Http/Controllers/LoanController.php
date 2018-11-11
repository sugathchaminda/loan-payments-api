<?php

namespace App\Http\Controllers;

use App\Http\Repositories\LoanRepaymentLogRepository;
use App\Http\Repositories\LoanRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LoanController extends Controller
{

    private $request;
    private $loanRepository;
    private $loanRepaymentLogRepository;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     * @param LoanRepository $loanRepository
     * @param LoanRepaymentLogRepository $loanRepaymentLogRepository
     */
    public function __construct(Request $request, LoanRepository $loanRepository
        , LoanRepaymentLogRepository $loanRepaymentLogRepository)
    {
        $this->request = $request;
        $this->loanRepository = $loanRepository;
        $this->loanRepaymentLogRepository = $loanRepaymentLogRepository;
    }

    public function addLoanForUser()
    {
        DB::beginTransaction();

        try {
            $this->validate($this->request, [
                'loanAmount' => 'required',
                'arrangementFee' => 'required',
                'duration' => 'required',
                'repaymentFrequency' => 'required',
                'interestRate' => 'required',
                'userId' => 'required',
            ]);

            $values = $this->request->all("loanAmount", "arrangementFee", "duration", "repaymentFrequency"
                , "interestRate", "userId");

            $values["loanBalanceAmount"] = floatval($this->request->get("loanAmount"))
                - floatval($this->request->get("arrangementFee"));

            $values["installmentAmount"] = (floatval($this->request->get("loanAmount"))
                    / floatval($this->request->get("duration")))
                + (floatval($this->request->get("loanAmount"))
                    * (floatval($this->request->get("interestRate"))) / 100);

            $values["remainingInstallments"] = $this->request->get("duration");

            $values["payedDate"] = date("Y-m-d");

            $loan = $this->loanRepository->addLoanForUser($values);

            DB::commit();

            return response()->json([
                'data' => [
                    'loan' => $loan
                ],
                'status' => true,
                'message' => 'Successfully registered.'
            ], 200);

        } catch (\Exception $ex) {

            DB::rollback();

            Log::error("Adding loan.: {} " . $ex);

            return response()->json([
                'data' => $ex,
                'status' => false,
                'message' => "Failed to add loan for user."
            ], 500);
        }
    }

    public function payLoanInstallment()
    {
        DB::beginTransaction();

        try {
            $this->validate($this->request, [
                'payedAmount' => 'required',
                'userId' => 'required',
                'loanId' => 'required'
            ]);

            $values = $this->request->all("payedAmount", "loanId", "userId");

            $loan = $this->loanRepository->getLoanById($values["loanId"], $values["userId"]);

            $isPayed = $this->checkAlreadyPayed($loan);

            if ($isPayed) {

                return response()->json([
                    'data' => null,
                    'status' => false,
                    'message' => 'Already payed.'
                ], 500);
            }

            $values["loanBalanceAmount"] = floatval($loan->loan_balance_amount) - floatval($values["payedAmount"]);
            $values["remainingInstallments"] = (int)$loan->remaining_installments - 1;
            $values["payedDate"] = date("Y-m-d");
            $values["lastInstallmentDate"] = date("Y-m-d");

            $log = $this->loanRepaymentLogRepository->insertRepaymentLog($values);

            $this->loanRepository->updateRemainingInstallmentsLoanBalance($values);

            DB::commit();

            return response()->json([
                'data' => [
                    'repaymentLog' => $log
                ],
                'status' => true,
                'message' => 'Successfully added repayment log.'
            ], 200);

        } catch (\Exception $ex) {

            DB::rollback();

            Log::error("Adding repayments.: {} " . $ex);

            return response()->json([
                'data' => $ex,
                'status' => false,
                'message' => "Failed to add repayments for loan."
            ], 500);
        }

    }

    private function getNumberOfDaysBetweenTwoDate($date1, $date2)
    {
        $datetime1 = new \DateTime($date1);
        $datetime2 = new \DateTime($date2);
        $interval = $datetime1->diff($datetime2);

        return $interval->format('%a');
    }

    private function checkAlreadyPayed($loan)
    {
        $numberOfDays = $this->getNumberOfDaysBetweenTwoDate($loan->last_installment_date, date("Y-m-d"));
        $wantsToPay = $numberOfDays / (int)$loan->repayment_frequency;

        if ($wantsToPay >= 1) {
            return false;
        }

        return true;
    }

    public function getLoans()
    {
        try {
            $loans = $this->loanRepository->getLoansWithFilters($this->request);

            return response()->json([
                'data' => [
                    'loans' => $loans
                ],
                'status' => true,
                'message' => 'Loan list received.'
            ], 200);

        } catch (\Exception $ex) {

            Log::error("Get loans.: {} " . $ex);
            return response()->json([
                'data' => $ex,
                'status' => false,
                'message' => "Failed to get loans."
            ], 500);
        }
    }
}
