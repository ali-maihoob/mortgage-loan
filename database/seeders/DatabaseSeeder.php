<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Loan;
use App\Models\LoanAmortizationSchedule;
use App\Helpers\LoanHelper;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Seed a user
        $user = User::create([
            'name' => 'Ali Maihoob',
            'email' => 'ali@test.com',
            'password' => bcrypt('123456'),
        ]);

        $loanAmount = 100000;
        $interestRate = 5;
        $loanTerm = 2;

        $loan = Loan::create([
            'loan_amount' => $loanAmount,
            'interest_rate' => $interestRate,
            'loan_term' => $loanTerm * 12,
            'monthly_payment' => LoanHelper::calculateMonthlyPayment($loanAmount, $interestRate, $loanTerm),
            'user_id' => $user->id,
        ]);

        // Generate amortization schedule for the loan
        LoanHelper::generateAmortizationSchedule($loan);
    }
}
