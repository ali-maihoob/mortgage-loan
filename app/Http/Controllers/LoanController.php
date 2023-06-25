<?php

namespace App\Http\Controllers;

use App\Http\Requests\Loan\StoreLoanRequest;
use App\Repositories\LoanRepository;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    private $loanRepository;

    public function __construct(LoanRepository $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    public function index()
    {
        $loans = $this->loanRepository->getAllLoans();
        return view('loan.index', [
            'loans' => $loans
        ]);
    }

    public function show($id)
    {
        $loan = $this->loanRepository->findLoanById($id);
        $loanAmortizationSchedule = $this->loanRepository->getLoanAmortizationSchedule($id);
        $extraRepaymentSchedule = $this->loanRepository->getExtraRepaymentSchedule($loan->id);

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
        $loanData = $request->validated();
        $loan = $this->loanRepository->createLoan($loanData);

        return redirect()->route('loan.index')->with('success', __('loan.loan_created_success_msg'));
    }

    public function addExtraPayment(Request $request, $id)
    {
        $loan = $this->loanRepository->findLoanById($id);

        $extraPayment = $request->input('extra_payment');
        $monthNumber = $request->input('month_number');

        if ($this->loanRepository->addExtraPayment($loan, $extraPayment, $monthNumber)) {
            return redirect()->route('loan.show', $loan->id)->with('success', __('loan.add_extra_payment_success_msg'));
        }

        return redirect()->route('loan.show', $loan->id)->with('error', __('loan.invalid_month_number'));
    }
}
