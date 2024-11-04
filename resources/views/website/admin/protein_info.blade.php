@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2>Protein Information</h2>

        @if(isset($protein_info))
            <table class="table table-bordered">
                <tr>
                    <th>ID</th>
                    <td>{{ $protein_info['ID'] }}</td>
                </tr>
                <tr>
                    <th>Accession</th>
                    <td>{{ $protein_info['Accession'] }}</td>
                </tr>
                <tr>
                    <th>Protein Name</th>
                    <td>{{ $protein_info['ProteinName'] }}</td>
                </tr>
                <tr>
                    <th>Organism</th>
                    <td>{{ $protein_info['Organism'] }}</td>
                </tr>
                <tr>
                    <th>Function</th>
                    <td>{{ $protein_info['Function'] }}</td>
                </tr>
                <tr>
                    <th>Disease Involvement</th>
                    <td>{{ $protein_info['DiseaseInvolvement'] }}</td>
                </tr>
            </table>
        @elseif(isset($error))
            <p class="text-danger">{{ $error }}</p>
        @endif
    </div>
@endsection
