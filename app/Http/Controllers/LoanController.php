<?php

namespace App\Http\Controllers;

use App\Helpers\LoanHelper;
use App\Http\Requests\Loan\StoreLoanRequest;
use App\Models\Loan;
use App\Models\LoanAmortizationSchedule;
use Illuminate\Support\Facades\Auth;
use App\Models\ExtraRepaymentSchedule;
use Illuminate\Http\Request;

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
        $extraRepaymentSchedule = ExtraRepaymentSchedule::where('loan_id', $loan->id)->orderBy('month_number')->get();
        return view('loan.show', [
            'loan' => $loan,
            'loanAmortizationSchedule' => $loanAmortizationSchedule,
            'extraRepaymentSchedule' => $extraRepaymentSchedule
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

        // Calculate the fixed extra payment amount (if any)
        $fixedExtraPayment = $request->input('fixed_extra_payment');

        // Store the loan data in the database
        $loan = new Loan([
            'loan_amount' => $loanAmount,
            'interest_rate' => $interestRate,
            'loan_term' => $loanTerm * 12,
            'monthly_payment' => $monthlyPayment,
            'fixed_extra_payment' => $fixedExtraPayment,
            'user_id' => Auth::id(),
        ]);
        if($loan->save()) {
            LoanHelper::generateAmortizationSchedule($loan);
        }
        return redirect()->route('loan.index')->with('success', 'The loan has been created successfully');
    }

    public function addExtraPayment(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        $extraPayment = $request->input('extra_payment');
        $monthNumber = $request->input('month_number');

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

            return redirect()->route('loan.show', $loan->id)->with('success', 'Extra payment added successfully');
        }

        return redirect()->route('loan.show', $loan->id)->with('error', 'Invalid month number');
    }

}
