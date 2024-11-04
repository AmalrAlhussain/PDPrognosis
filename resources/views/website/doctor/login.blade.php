@extends('website.parts.app')

@push('css')
    <style>
        body {
            color: #aa082e;
            font-family: 'Roboto', sans-serif;
        }

        a:link {
            text-decoration: none;
        }
a {
    color: #0c40c8;
}
        .note {
            text-align: center;
            height: 80px;
            background: -webkit-linear-gradient(left, #0072ff, #8811c5);
            color: #fff;
            font-weight: bold;
            line-height: 80px;
        }

        .form-content {
            padding: 5%;
            border: 1px solid #ced4da;
            margin-bottom: 2%;
        }

        .form-control {
            border-radius: 1.5rem;
        }

        .btnSubmit {
            border: none;
            border-radius: 1.5rem;
            padding: 1%;
            width: 20%;
            cursor: pointer;
            background: #0062cc;
            color: #fff;
        }

        .validation-error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
        }
        .register-form {
            margin-top: 112px;
        }
    </style>
@endpush

@section('content')
    <form method="POST" action="{{ route('doctor.login') }}">
        @csrf
        <div class="container register-form">
            <div class="form">
                <div class="note">
                    <p>Doctor Login Page</p>
                </div>

                <div class="form-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="username" placeholder="Username" class="form-control" required value="{{ old('username') }}">
                                @if ($errors->has('username'))
                                    <div class="validation-error">{{ $errors->first('username') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="password" name="password" placeholder="Password" class="form-control" required>
                                @if ($errors->has('password'))
                                    <div class="validation-error">{{ $errors->first('password') }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btnSubmit">Login</button>
                    <div class="text-center">Do not have an account? <a href="{{ route('doctor.register') }}">Signup here</a></div>
                </div>
            </div>
        </div>
    </form>
@endsection
