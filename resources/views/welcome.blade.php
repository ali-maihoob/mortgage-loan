@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center">Senior PHP/Laravel Developer Position Assessment</h1>
                <hr>
                <div class="mb-3">
                    <label for="companyName" class="form-label">Company Name:</label>
                    <input type="text" class="form-control" id="companyName" value="Info Websight EDM Solutions" readonly>
                </div>
                <div class="mb-3">
                    <label for="candidateName" class="form-label">Candidate Name:</label>
                    <input type="text" class="form-control" id="candidateName" value="Ali Maihoob" readonly>
                </div>
                <div class="mb-3">
                    <label for="candidateEmail" class="form-label">Candidate Email:</label>
                    <input type="email" class="form-control" id="candidateEmail" value="ali.hasan.maihoob@gmail.com" readonly>
                </div>
                <div>
                    <p>Please use the credentials:</p>
                    <p>Email: ali@test.com</p>
                    <p>Password: 123456</p>
                </div>
                <div>
                    <a href="{{ route('loan.index') }}" class="btn btn-primary">Start</a>
                </div>
            </div>
        </div>
    </div>
@endsection
