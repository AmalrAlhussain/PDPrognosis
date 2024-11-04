@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2>Peptides for Patient: {{ $patient->fullname }}</h2>

        @if($peptides->isEmpty())
            <p>No peptides found for this patient.</p>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Visit ID</th>
                    <th>UniProt</th>
                    <th>Peptide</th>
                    <th>Peptide Abundance</th>
                </tr>
                </thead>
                <tbody>
                @foreach($peptides as $peptide)
                    <tr>
                        <td>{{ $peptide->id }}</td>
                        <td>{{ $peptide->visit_id }}</td>
                        <td>{{ $peptide->UniProt }}</td>
                        <td>{{ $peptide->Peptide }}</td>
                        <td>{{ $peptide->PeptideAbundance }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
