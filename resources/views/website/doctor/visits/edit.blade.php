@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2>Edit Visit</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('doctor.visits.update', $visit->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="patient_id">Patient</label>
                <select name="patient_id" id="patient_id" class="form-control" required>
                    <option value="">-- Select Patient --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ $visit->patient_id == $patient->id ? 'selected' : '' }}>
                            {{ $patient->fullname }}
                        </option>
                    @endforeach
                </select>
                @error('patient_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="visit_date">Visit Date</label>
                <input type="date" name="visit_date" id="visit_date" class="form-control" value="{{ $visit->visit_date }}" required>
                @error('visit_date')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="notes">Notes (Optional)</label>
                <textarea name="notes" id="notes" class="form-control">{{ $visit->notes }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Visit</button>
        </form>
    </div>
@endsection
