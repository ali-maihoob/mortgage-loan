@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{ __('loan.loan_details') }}
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addExtraPaymentModal">
                            {{ __('loan.add_extra_payment') }}
                        </button>
                    </div>

                    <div class="card-body">
                        <h4>{{ __('loan.loan_information') }}</h4>
                        <p>{{ __('loan.loan_amount') }}: {{ $loan->loan_amount }} $</p>
                        <p>{{ __('loan.interest_rate') }}: {{ $loan->interest_rate }} %</p>
                        <p>{{ __('loan.loan_term') }}: {{ $loan->loan_term }} months</p>
                        <p>{{ __('loan.monthly_payment') }}: {{ $loan->monthly_payment }} $</p>
                        <p>{{ __('loan.fixed_extra_payment') }}: {{ $loan->fixed_extra_payment ?? 0 }} $</p>

                        <hr>

                        <h4>{{ __('loan.amortization_schedule') }}</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">{{ __('loan.month_number') }}</th>
                                    <th scope="col">{{ __('loan.starting_balance') }}</th>
                                    <th scope="col">{{ __('loan.monthly_payment') }}</th>
                                    <th scope="col">{{ __('loan.principal_component') }}</th>
                                    <th scope="col">{{ __('loan.interest_component') }}</th>
                                    <th scope="col">{{ __('loan.extra_payment_made') }}</th>
                                    <th scope="col">{{ __('loan.ending_balance') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($loan->amortizationSchedule as $schedule)
                                    <tr>
                                        <td>{{ $schedule->month_number }}</td>
                                        <td>{{ $schedule->starting_balance }} $</td>
                                        <td>{{ $schedule->monthly_payment }} $</td>
                                        <td>{{ $schedule->principal_component }} $</td>
                                        <td>{{ $schedule->interest_component }} $</td>
                                        <td>{{ $schedule->extra_repayment_made }} $</td>
                                        <td>{{ $schedule->ending_balance }} $</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        @if($loan->extraRepaymentSchedule->isNotEmpty())
                            <h4>{{ __('loan.extra_payments') }}</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">{{ __('loan.month_number') }}</th>
                                        <th scope="col">{{ __('loan.starting_balance') }}</th>
                                        <th scope="col">{{ __('loan.monthly_payment') }}</th>
                                        <th scope="col">{{ __('loan.principal_component') }}</th>
                                        <th scope="col">{{ __('loan.interest_component') }}</th>
                                        <th scope="col">{{ __('loan.extra_payment_made') }}</th>
                                        <th scope="col">{{ __('loan.ending_balance') }}</th>
                                        <th scope="col">{{ __('loan.remaining_loan_term') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($loan->extraRepaymentSchedule as $schedule)
                                        <tr>
                                            <td>{{ $schedule->month_number }}</td>
                                            <td>{{ $schedule->starting_balance }} $</td>
                                            <td>{{ $schedule->monthly_payment }} $</td>
                                            <td>{{ $schedule->principal_component }} $</td>
                                            <td>{{ $schedule->interest_component }} $</td>
                                            <td>{{ $schedule->extra_repayment_made }} $</td>
                                            <td>{{ $schedule->ending_balance }} $</td>
                                            <td>{{ $schedule->remaining_loan_term }} months</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Extra Payment Modal -->
    <div class="modal fade" id="addExtraPaymentModal" tabindex="-1" aria-labelledby="addExtraPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExtraPaymentModalLabel">{{ __('loan.modal_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('loan.extra-payment', $loan->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="extra_payment" class="form-label">{{ __('loan.extra_payment_label') }}</label>
                                    <input type="number" class="form-control" id="extra_payment" name="extra_payment" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="month_number" class="form-label">{{ __('loan.month_number_label') }}</label>
                                    <input type="number" class="form-control" id="month_number" name="month_number" min="1" max="{{ $loan->loan_term }}" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('loan.add_extra_payment_button') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
