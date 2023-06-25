@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">User Loans</div>

                    <div class="card-body">
                        <div class="mb-5">
                            <a href="{{ route('loan.create') }}" class="btn btn-primary">Request New Loan</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Loan Amount</th>
                                    <th scope="col">Interest Rate</th>
                                    <th scope="col">Monthly Payment</th>
                                    <th scope="col">Fixed Extra Payment</th>
                                    <th scope="col">Loan Term</th>
                                    <th scope="col">Created Date</th>
                                    <th scope="col">controls</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($loans as $key => $loan)
                                    <tr>
                                        <th scope="row">{{{ $key+1 }}}</th>
                                        <td>{{ $loan->loan_amount }} $</td>
                                        <td>{{ $loan->interest_rate }} %</td>
                                        <td>{{ $loan->monthly_payment }} $</td>
                                        <td>{{ $loan->fixed_extra_payment ?? 0 }}</td>
                                        <td>{{ $loan->loan_term / 12 }} years</td>
                                        <td>{{ $loan->created_at }}</td>
                                        <td>
                                            <button type="button" class="btn btn-secondary btn-sm">Show Details</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $loans->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
