@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2>Update Profile</h2>
        <form action="{{ route('patient.profile.update') }}" method="POST">
            @csrf

{{--            <div class="form-group">--}}
{{--                <label for="fullname">Full Name:</label>--}}
{{--                <input type="text" class="form-control" name="fullname" value="{{ old('fullname', $patient->fullname) }}" required>--}}
{{--                @error('fullname')--}}
{{--                <div class="text-danger">{{ $message }}</div>--}}
{{--                @enderror--}}
{{--            </div>--}}

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" value="{{ old('username', $patient->username) }}" required>
                @error('username')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" value="{{ old('email', $patient->email) }}" required>
                @error('email')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" name="phone" value="{{ old('phone', $patient->phone) }}" required>
                @error('phone')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">New Password (leave blank to keep current):</label>
                <input type="password" class="form-control" name="password">
                @error('password')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" class="form-control" name="password_confirmation">
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
@endsection
