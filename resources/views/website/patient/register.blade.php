@extends('website.parts.app')

@push('css')
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fa;
        }
        a {
            color: #0c40c8;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: none;
            border-radius: 10px;
            margin-top: 50px;
        }

        .card-header {
            background-color: #0072ff;
            color: white;
            text-align: center;
            font-weight: bold;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            padding: 20px;
            font-size: 24px;
        }

        .card-body {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem;
            font-size: 16px;
        }

        .btn-primary {
            background-color: #0072ff;
            border: none;
            border-radius: 0.75rem;
            padding: 10px 30px;
            font-size: 18px;
            font-weight: bold;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: #0056cc;
        }

        .validation-error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
@endpush
@section('content')
    <div class="container mtmb">
        <div class="row justify-content-center">
            @include('notification_messages')
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Patient Registration
                    </div>

                    <div class="card-body">
    <form method="POST" action="{{ route('patient.register') }}">
        @csrf
        <div class="container">
            <div class="form-group">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" name="fullname" required>
                @if($errors->has('fullname'))
                    <div class="validation-error">{{ $errors->first('fullname') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" required>
                @if($errors->has('username'))
                    <div class="validation-error">{{ $errors->first('username') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" required>
                @if($errors->has('email'))
                    <div class="validation-error">{{ $errors->first('email') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" name="phone" required>
                @if($errors->has('phone'))
                    <div class="validation-error">{{ $errors->first('phone') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" required>
                @if($errors->has('password'))
                    <div class="validation-error">{{ $errors->first('password') }}</div>
                @endif
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" class="form-control" name="password_confirmation" required>
                @if($errors->has('password_confirmation'))
                    <div class="validation-error">{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Sign Up</button>
        </div>
    </form>
                    </div>
                </div>
            </div>
    </div>
    </div>
@endsection
