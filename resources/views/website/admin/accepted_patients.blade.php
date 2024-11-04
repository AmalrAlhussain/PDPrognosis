@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2 class="h222">Accepted Patients</h2>

        @if($patients->isEmpty())
            <p>No accepted patients at the moment.</p>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Doctor</th>
                    <th>Status</th>
{{--                    <th>Actions</th>--}}
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
{{--                        <td>--}}
{{--                            @if($patient->uniprot_id)--}}
{{--                                <form action="{{ route('admin.proteinInfo') }}" method="POST" style="display:inline;">--}}
{{--                                    @csrf--}}
{{--                                    <input type="hidden" name="uniprot_id" value="{{ $patient->uniprot_id }}">--}}
{{--                                    <button type="submit" class="btn btn-info btn-sm">Fetch Protein Info</button>--}}
{{--                                </form>--}}
{{--                            @else--}}
{{--                                <button class="btn btn-secondary btn-sm" disabled>No UniProt ID</button>--}}
{{--                            @endif--}}
{{--                        </td>--}}
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
