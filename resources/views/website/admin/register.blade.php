@extends('website.parts.app')

@section('content')
    <div class="jumbotron" style="margin-bottom:0px;">
        <h1 class="display-4" style="text-align:center;">Hello, Admin</h1>
        <p class="lead">Welcome to PDPROGNOSIS System. Please Sign Up to continue.</p>
        <hr class="my-4">

        <form method="POST" action="{{ route('admin.register') }}">
            @csrf
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="fullname" required>
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
        </form>
    </div>
@endsection
