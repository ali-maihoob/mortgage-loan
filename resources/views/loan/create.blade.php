@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Request New Loan</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loan.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="loan_amount" class="form-label">Loan Amount *</label>
                                <input type="number" class="form-control" id="loan_amount" name="loan_amount" step="any" required>
                                <small class="form-text text-muted">Enter the loan amount in digits.</small>

                            </div>

                            <div class="mb-3">
                                <label for="interest_rate" class="form-label">Interest Rate *</label>
                                <input type="number" step="any" min="1" max="100" class="form-control" id="interest_rate" name="interest_rate" required>
                                <small class="form-text text-muted">Enter the annual interest rate.</small>
                            </div>

                            <div class="mb-3">
                                <label for="loan_term" class="form-label">Loan Term *</label>
                                <input type="number" class="form-control" id="loan_term" name="loan_term" min="1" max="20" required>
                                <small class="form-text text-muted">Enter the number of years (not months) and maximum term is 20 years.</small>

                            </div>

                            <div class="mb-3">
                                <label for="fixed_extra_payment" class="form-label">Fixed Extra Payment</label>
                                <input type="text" class="form-control" id="fixed_extra_payment" name="fixed_extra_payment">
                                <small class="form-text text-muted">Optional Field, you can keep it empty.</small>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
