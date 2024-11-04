@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2>Proteins for Patient: {{ $patient->fullname }}</h2>

        @if($proteins->isEmpty())
            <p>No proteins found for this patient.</p>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Visit ID</th>
                    <th>Visit Month</th>
                    <th>UniProt</th>
                    <th>NPX</th>
                </tr>
                </thead>
                <tbody>
                @foreach($proteins as $protein)
                    <tr>
                        <td>{{ $protein->id }}</td>
                        <td>{{ $protein->visit_id }}</td>
                        <td>{{ $protein->visit_month }}</td>
                        <td>{{ $protein->UniProt }}</td>
                        <td>{{ $protein->NPX }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
