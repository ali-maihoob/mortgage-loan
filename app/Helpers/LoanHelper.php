<?php

namespace App\Helpers;

class LoanHelper
{
    public static function calculateMonthlyPayment($loanAmount, $interestRate, $loanTerm): float|int
    {
        $monthlyInterestRate = $interestRate / 100 / 12;
        $numberOfPayments = $loanTerm * 12;
        return ($loanAmount * $monthlyInterestRate) / (1 - pow(1 + $monthlyInterestRate, -$numberOfPayments));
    }
}
