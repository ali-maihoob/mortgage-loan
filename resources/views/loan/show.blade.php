@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">User Loans</div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">Month Number</th>
                                    <th scope="col">Starting Balance</th>
                                    <th scope="col">Monthly Payment</th>
                                    <th scope="col">Principal Component</th>
                                    <th scope="col">Interest Component</th>
                                    <th scope="col">Extra Payment Paid</th>
                                    <th scope="col">Ending Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($loanAmortizationSchedule as $key => $schedule)
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
                            {{ $loanAmortizationSchedule->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
