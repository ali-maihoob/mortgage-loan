@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Loan Details
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#addExtraPaymentModal">
                            Add Extra Payment
                        </button>
                    </div>

                    <div class="card-body">
                        <h4>Loan Information</h4>
                        <p>Loan Amount: {{ $loan->loan_amount }} $</p>
                        <p>Interest Rate: {{ $loan->interest_rate }} %</p>
                        <p>Loan Term: {{ $loan->loan_term }} months</p>
                        <p>Monthly Payment: {{ $loan->monthly_payment }} $</p>
                        <p>Fixed Extra Payment: {{ $loan->fixed_extra_payment ?? 'N/A' }} $</p>

                        <hr>

                        <h4>Amortization Schedule</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Month Number</th>
                                    <th scope="col">Starting Balance</th>
                                    <th scope="col">Monthly Payment</th>
                                    <th scope="col">Principal Component</th>
                                    <th scope="col">Interest Component</th>
                                    <th scope="col">Extra Payment Made</th>
                                    <th scope="col">Ending Balance</th>
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
                        <h4>Extra Payments</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Month Number</th>
                                    <th scope="col">Starting Balance</th>
                                    <th scope="col">Monthly Payment</th>
                                    <th scope="col">Principal Component</th>
                                    <th scope="col">Interest Component</th>
                                    <th scope="col">Extra Payment Made</th>
                                    <th scope="col">Ending Balance</th>
                                    <th scope="col">Remaining Loan Term</th>
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
                    <h5 class="modal-title" id="addExtraPaymentModalLabel">Add Extra Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('loan.extra-payment', $loan->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="extra_payment" class="form-label">Extra Payment</label>
                                    <input type="number" class="form-control" id="extra_payment" name="extra_payment" step="0.01" min="0" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="month_number" class="form-label">Month Number</label>
                                    <input type="number" class="form-control" id="month_number" name="month_number" min="1" max="{{ $loan->loan_term }}" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Extra Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
