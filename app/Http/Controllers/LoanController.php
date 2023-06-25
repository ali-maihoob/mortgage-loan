<?php

namespace App\Http\Controllers;

use App\Helpers\LoanHelper;
use App\Http\Requests\Loan\StoreLoanRequest;
use App\Models\Loan;
use App\Models\LoanAmortizationSchedule;
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

    public function show($id)
    {
        $loan = Loan::findOrFail($id);
        $loanAmortizationSchedule = LoanAmortizationSchedule::where('loan_id', $id)->paginate(25);
        return view('loan.show', [
            'loan' => $loan,
            'loanAmortizationSchedule' => $loanAmortizationSchedule
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
        if($loan->save()) {
            LoanHelper::generateAmortizationSchedule($loan);
        }
        return redirect()->route('loan.index')->with('success', 'The loan has been created successfully');
    }
}
