@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2 class="h222">My Patients</h2>

        @if($patients->isEmpty())
            <p>No accepted patients at the moment.</p>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Protein/Peptide</th>
                    <th>Visits</th>
                </tr>
                </thead>
                <tbody>
                @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td>
                            @if($patient->status)
                                <i class="fa fa-check-circle text-success"></i>
                            @else
                                <i class="fa fa-times text-danger"></i>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('doctor.patients.showDetails', $patient->id) }}" class="btn btn-info btn-sm">View Details</a>
                        </td>


                        <td>
                            <a href="{{ route('doctor.patients.show', $patient->id) }}" class="btn btn-primary btn-sm">View Visits</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
