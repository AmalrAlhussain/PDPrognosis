@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2 class="h222">Pending Patient Requests</h2>

        @if($patients->isEmpty())
            <p>No pending patient requests at the moment.</p>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Doctor</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($patients as $patient)
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td>{{ $patient->doctor ? $patient->doctor->fullname : 'No Doctor Assigned' }}</td>
                        <td>{{ ucfirst($patient->status) }}</td>
                        <td>
                            <!-- Approve and Reject buttons -->
                            <form action="{{ route('admin.patient.approve', $patient->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>

                            <form action="{{ route('admin.patient.reject', $patient->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
