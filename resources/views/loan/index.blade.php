@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('loan.user_loans') }}</div>

                    <div class="card-body">
                        <div class="mb-5">
                            <a href="{{ route('loan.create') }}" class="btn btn-primary">{{ __('loan.request_new_loan') }}</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ __('loan.loan_amount') }}</th>
                                    <th scope="col">{{ __('loan.interest_rate') }}</th>
                                    <th scope="col">{{ __('loan.monthly_payment') }}</th>
                                    <th scope="col">{{ __('loan.fixed_extra_payment') }}</th>
                                    <th scope="col">{{ __('loan.loan_term') }}</th>
                                    <th scope="col">{{ __('loan.created_date') }}</th>
                                    <th scope="col">{{ __('loan.controls') }}</th>
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
                                            <a href="{{ route('loan.show', ['id' => $loan->id]) }}" class="btn btn-secondary btn-sm">
                                                {{ __('loan.show_details') }}
                                            </a>
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
