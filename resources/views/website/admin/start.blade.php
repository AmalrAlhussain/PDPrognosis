

@extends('website.parts.app')


@section('content')
    <div class="jumbotron" style="margin-bottom:0px;">
        <h1 class="display-4" style="text-align:center;">Hello, Admin</h1>
        <p class="lead">Welcome to PDPROGNOSIS System.</p>
        <hr class="my-4">
        <p>You can access various features after Login/SignUp.</p>
        <p class="lead">
            <a class="btn btn-primary btn-lg" href="{{route('admin.register')}}" role="button">SignUp</a>
            <a class="btn btn-primary btn-lg" href="{{route('admin.login')}}" role="button">Login</a>
        </p>
    </div>
@endsection
