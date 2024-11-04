@extends('website.parts.app')


@section('content')
    <div class="jumbotron">
        <h5 class="display-3 glow">Parkinson's Disease</h5>
        <p>
            <a class="btn btn-primary btn-lg" href="{{route('patient.start')}}" role="button">Login</a>
        </p>
    </div>

    <div class="grid-container">
        <div class="grid-item">
            <div class="card333">
                <img src="{{asset('images/admin.png')}}" alt="Admin" style="width:100%">
                <p class="title">ADMIN</p>
                <p><button><a href="{{route('admin.start')}}">View</a></button></p>
            </div>
        </div>

        <div class="grid-item">
            <div class="card333">
                <img src="{{asset('images/doctor.png')}}" alt="Doctor" style="width:100%">
                <p class="title">DOCTOR</p>
                <p><button><a href="{{route('doctor.start')}}">View</a></button></p>
            </div>
        </div>

        <div class="grid-item">
            <div class="card333">
                <img src="{{asset('images/patient.jpg')}}" alt="Patient" style="width:100%">
                <p class="title">PATIENT</p>
                <p><button><a href="{{route('patient.start')}}">View</a></button></p>
            </div>
        </div>
    </div>
@endsection
