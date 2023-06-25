@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('loan.request_new_loan') }}</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('loan.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="loan_amount" class="form-label">{{ __('loan.loan_amount') }} *</label>
                                <input type="number" class="form-control" id="loan_amount" name="loan_amount" step="any" required>
                                <small class="form-text text-muted">{{ __('loan.loan_amount_desc') }}</small>

                            </div>

                            <div class="mb-3">
                                <label for="interest_rate" class="form-label">{{ __('loan.interest_rate') }} *</label>
                                <input type="number" step="any" min="1" max="100" class="form-control" id="interest_rate" name="interest_rate" required>
                                <small class="form-text text-muted">{{ __('loan.interest_rate_desc') }}</small>
                            </div>

                            <div class="mb-3">
                                <label for="loan_term" class="form-label">{{ __('loan.loan_term') }} *</label>
                                <input type="number" class="form-control" id="loan_term" name="loan_term" min="1" max="20" required>
                                <small class="form-text text-muted">{{ __('loan.loan_term_desc') }}</small>

                            </div>

                            <div class="mb-3">
                                <label for="fixed_extra_payment" class="form-label">{{ __('loan.fixed_extra_payment') }}</label>
                                <input type="text" class="form-control" id="fixed_extra_payment" name="fixed_extra_payment">
                                <small class="form-text text-muted">{{ __('loan.fixed_extra_payment_desc') }}</small>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('loan.submit') }}</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
