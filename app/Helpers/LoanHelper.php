<?php

namespace App\Helpers;

use App\Models\Loan;
use App\Models\LoanAmortizationSchedule;

class LoanHelper
{
    public static function calculateMonthlyPayment($loanAmount, $interestRate, $loanTerm): float|int
    {
        $monthlyInterestRate = $interestRate / 100 / 12;
        $numberOfPayments = $loanTerm * 12;
        return ($loanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfPayments));
    }
    public static function generateAmortizationSchedule(Loan $loan)
    {
        $loanAmount = $loan->loan_amount;
        $interestRate = $loan->interest_rate / 100 / 12;
        $loanTerm = $loan->loan_term;
        $monthlyPayment = $loan->monthly_payment;

        // Get the fixed extra payment made during loan creation
        $fixedExtraPayment = $loan->fixed_extra_payment ?? 0;

        $remainingBalance = $loanAmount;
        $month = 1;

        while ($remainingBalance > 0 && $month <= $loanTerm) {
            $interestComponent = $remainingBalance * $interestRate;

            // Deduct the fixed extra payment from the remaining balance
            $startingBalance = $remainingBalance;
            $remainingBalance -= $fixedExtraPayment;

            $principalComponent = $monthlyPayment - $interestComponent;

            // Set the ending balance to zero if it becomes negative
            $endingBalance = max($remainingBalance - $principalComponent, 0);

            $scheduleData = [
                'loan_id' => $loan->id,
                'month_number' => $month,
                'starting_balance' => $startingBalance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principalComponent,
                'interest_component' => $interestComponent,
                'extra_repayment_made' => $fixedExtraPayment,
                'ending_balance' => $endingBalance,
                'remaining_loan_term' => $loanTerm - $month,
            ];

            LoanAmortizationSchedule::create($scheduleData);

            $remainingBalance = $endingBalance;
            $month++;
        }
    }

}
