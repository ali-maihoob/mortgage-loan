<?php

namespace App\Repositories;

use App\Helpers\LoanHelper;
use App\Models\ExtraRepaymentSchedule;
use App\Models\Loan;
use App\Models\LoanAmortizationSchedule;
use Illuminate\Support\Facades\Auth;

class LoanRepository
{
    public function getAllLoans()
    {
        return Loan::paginate(10);
    }

    public function createLoan($loanData)
    {
        $loanAmount = $loanData['loan_amount'];
        $interestRate = $loanData['interest_rate'];
        $loanTerm = $loanData['loan_term'];
        $monthlyPayment = LoanHelper::calculateMonthlyPayment($loanAmount, $interestRate, $loanTerm);

        $fixedExtraPayment = $loanData['fixed_extra_payment'];

        $loan = new Loan([
            'loan_amount' => $loanAmount,
            'interest_rate' => $interestRate,
            'loan_term' => $loanTerm * 12,
            'monthly_payment' => $monthlyPayment,
            'fixed_extra_payment' => $fixedExtraPayment,
            'user_id' => Auth::id(),
        ]);

        if ($loan->save()) {
            LoanHelper::generateAmortizationSchedule($loan);
        }

        return $loan;
    }

    public function findLoanById($id)
    {
        return Loan::findOrFail($id);
    }

    public function getLoanAmortizationSchedule($loanId)
    {
        return LoanAmortizationSchedule::where('loan_id', $loanId)->paginate(25);
    }

    public function getExtraRepaymentSchedule($loanId)
    {
        return ExtraRepaymentSchedule::where('loan_id', $loanId)->orderBy('month_number')->get();
    }

    public function addExtraPayment($loan, $extraPayment, $monthNumber)
    {
        $amortizationSchedule = $loan->amortizationSchedule()->where('month_number', $monthNumber)->first();

        if ($amortizationSchedule) {
            $endingBalance = $amortizationSchedule->ending_balance;
            $updatedEndingBalance = $endingBalance - $extraPayment;

            $amortizationSchedule->extra_repayment_made = $extraPayment;
            $amortizationSchedule->ending_balance = $updatedEndingBalance;
            $amortizationSchedule->save();

            $remainingLoanTerm = $loan->loan_term - $monthNumber;

            ExtraRepaymentSchedule::create([
                'loan_id' => $loan->id,
                'month_number' => $monthNumber,
                'starting_balance' => $endingBalance,
                'monthly_payment' => $amortizationSchedule->monthly_payment,
                'principal_component' => $amortizationSchedule->principal_component,
                'interest_component' => $amortizationSchedule->interest_component,
                'extra_repayment_made' => $extraPayment,
                'ending_balance' => $updatedEndingBalance,
                'remaining_loan_term' => $remainingLoanTerm,
            ]);

            return true;
        }

        return false;
    }
}
