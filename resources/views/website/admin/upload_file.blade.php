@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2>Upload CSV File for Visit</h2>

        <!-- Display the incoming request data -->
        <div class="card mb-3">
            <div class="card-header">Review Data</div>
            <div class="card-body">
                <p class="text-left"><strong>File Type:</strong> {{ $data['file_type'] }}</p>
                <p class="text-left"><strong>Visit ID:</strong> {{ $data['visit_id'] }}</p>
                <p class="text-left"><strong>Patient ID:</strong> {{ $data['patient_id'] }}</p>
                <!-- Button to download sample file -->
                <div class="mb-3">
                    @if($data['file_type'] == 'peptide')
                        <a href="{{ url('dataset/sample_file_peptide.csv') }}" class="btn btn-info">
                            Download Sample Peptide CSV File
                        </a>
                    @endif
                        @if($data['file_type'] == 'protein')
                            <a href="{{ url('dataset/sample_file_protein.csv') }}" class="btn btn-info">
                                Download Sample Protein CSV File
                            </a>
                        @endif
                </div>
<hr>
                <!-- Form to upload CSV file -->
                <form action="{{ route('admin.visit.process_upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="file_type" value="{{ $data['file_type'] }}">
                    <input type="hidden" name="visit_id" value="{{ $data['visit_id'] }}">
                    <input type="hidden" name="patient_id" value="{{ $data['patient_id'] }}">

                    <div class="form-group">
                        <label for="file">Upload CSV file</label>
                        <input type="file" name="file" id="file" class="form-control" accept=".csv" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Preview & Confirm</button>
                </form>
            </div>
        </div>




    </div>
@endsection
