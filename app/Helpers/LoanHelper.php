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

        $remainingBalance = $loanAmount;
        $month = 1;
        while ($remainingBalance > 0 && $month <= $loanTerm) {
            $interestComponent = $remainingBalance * $interestRate;
            $principalComponent = $monthlyPayment - $interestComponent;

            $endingBalance = $remainingBalance - $principalComponent;

            $scheduleData = [
                'loan_id' => $loan->id,
                'month_number' => $month,
                'starting_balance' => $remainingBalance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principalComponent,
                'interest_component' => $interestComponent,
                'ending_balance' => $endingBalance,
            ];

            LoanAmortizationSchedule::create($scheduleData);

            $remainingBalance = $endingBalance;
            $month++;
        }
    }
}
