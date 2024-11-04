@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2 class="h222">Accepted Doctors</h2>

        @if($doctors->isEmpty())
            <p>No accepted doctors at the moment.</p>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Specialty</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($doctors as $doctor)
                    <tr>
                        <td>{{ $doctor->id }}</td>
                        <td>{{ $doctor->fullname }}</td>
                        <td>{{ $doctor->email }}</td>
                        <td>{{ $doctor->phone }}</td>
                        <td>{{ $doctor->specialty }}</td>
                        <td>{{ ucfirst($doctor->status) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
