@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2>Visit Details</h2>

        <div class="card">
            <div class="card-body">
                <p><strong>Patient Name:</strong> {{ $visit->patient->fullname }}</p>
                <p><strong>Visit Date:</strong> {{ $visit->visit_date }}</p>
                <p><strong>Notes:</strong> {{ $visit->notes }}</p>
            </div>
        </div>

        <a href="{{ route('doctor.visits.index') }}" class="btn btn-secondary mt-3">Back to Visits</a>
    </div>
@endsection
