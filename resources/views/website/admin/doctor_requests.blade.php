@extends('website.parts.dash')

@section('content')
    <div class="container">
        @include('notification_messages')
        <h2 class="h222">Pending Doctor Requests</h2>

        @if($doctors->isEmpty())
            <p>No pending doctor requests at the moment.</p>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
{{--                    <th>Specialty</th>--}}
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($doctors as $doctor)
                    <tr>
                        <td>{{ $doctor->id }}</td>
                        <td>{{ $doctor->fullname }}</td>
                        <td>{{ $doctor->email }}</td>
                        <td>{{ $doctor->phone }}</td>
{{--                        <td>{{ $doctor->specialty }}</td>--}}
                        <td>{{ ucfirst($doctor->status) }}</td>
                        <td>
                            <!-- Approve and Reject buttons -->
                            <form action="{{ route('admin.doctor.approve', $doctor->id) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Approve</button>
                            </form>

                            <form action="{{ route('admin.doctor.reject', $doctor->id) }}" method="POST" style="display:inline;">
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
