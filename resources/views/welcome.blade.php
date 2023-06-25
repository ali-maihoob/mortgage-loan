@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center">{{ __('general.position_name') }}</h1>
                <hr>
                <div class="mb-3">
                    <label for="companyName" class="form-label">{{ __('general.company_name') }}</label>
                    <input type="text" class="form-control" id="companyName" value="Info Websight EDM Solutions" readonly>
                </div>
                <div class="mb-3">
                    <label for="candidateName" class="form-label">{{ __('general.candidate_name') }}</label>
                    <input type="text" class="form-control" id="candidateName" value="Ali Maihoob" readonly>
                </div>
                <div class="mb-3">
                    <label for="candidateEmail" class="form-label">{{ __('general.candidate_email') }}</label>
                    <input type="email" class="form-control" id="candidateEmail" value="ali.hasan.maihoob@gmail.com" readonly>
                </div>
                <div>
                    <p>{{ __('general.use_credentials') }}:</p>
                    <p>Email: ali@test.com</p>
                    <p>Password: 123456</p>
                </div>
                <div>
                    <a href="{{ route('loan.index') }}" class="btn btn-primary">{{ __('general.start') }}</a>
                </div>
            </div>
        </div>
    </div>
@endsection
