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

        .password-hint {
            font-size: 14px;
            color: #6c757d;
            margin-top: 5px;
        }
    </style>
@endpush

@section('content')
    <div class="container mtmb">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Doctor Registration
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('doctor.register') }}">
                            @csrf

                            <div class="form-group">
                                <label for="fullname">Full Name</label>
                                <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname') }}" required>
                                @if($errors->has('fullname'))
                                    <div class="validation-error">{{ $errors->first('fullname') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required>
                                @if($errors->has('username'))
                                    <div class="validation-error">{{ $errors->first('username') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                @if($errors->has('email'))
                                    <div class="validation-error">{{ $errors->first('email') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                                @if($errors->has('phone'))
                                    <div class="validation-error">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                                @if($errors->has('password'))
                                    <div class="validation-error">{{ $errors->first('password') }}</div>
                                @endif
                                <small class="password-hint">
                                    Password must be at least 8 characters, contain at least one uppercase letter, one lowercase letter, one number, and one special character.
                                </small>
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                @if($errors->has('password_confirmation'))
                                    <div class="validation-error">{{ $errors->first('password_confirmation') }}</div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Sign Up</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
