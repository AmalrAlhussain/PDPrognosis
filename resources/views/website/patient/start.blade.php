

@extends('website.parts.app')


@section('content')
    <div class="jumbotron" style="margin-bottom:0px;">
        <h1 class="display-4" style="text-align:center;">Hello, Patient</h1>
        <p class="lead">Welcome to PDPROGNOSIS System.</p>
        <hr class="my-4">
        <p>You can access various features after Login/SignUp.</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="{{route('patient.register')}}" role="button">Register Your Account</a>
            <a class="btn btn-primary btn-lg" href="{{route('patient.login')}}" role="button">Login</a>
        </p>
    </div>
@endsection
