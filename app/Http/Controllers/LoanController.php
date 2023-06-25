<?php

namespace App\Http\Controllers;

use App\Helpers\LoanHelper;
use App\Http\Requests\Loan\StoreLoanRequest;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::paginate(10);
        return view('loan.index', [
            'loans' => $loans
        ]);
    }
    public function create()
    {
        return view('loan.create');
    }

    public function store(StoreLoanRequest $request)
    {
        $loanAmount = $request->input('loan_amount');
        $interestRate = $request->input('interest_rate');
        $loanTerm = $request->input('loan_term');
        $monthlyPayment = LoanHelper::calculateMonthlyPayment($loanAmount, $interestRate, $loanTerm);

        // Store the loan data in the database
        $loan = new Loan([
            'loan_amount' => $loanAmount,
            'interest_rate' => $interestRate,
            'loan_term' => $loanTerm * 12,
            'monthly_payment' => $monthlyPayment,
            'user_id' => Auth::id(),
        ]);
        $loan->save();
    }
}
