@extends('website.parts.dash')

@section('content')
    <div class="container">
        <!-- Back Button -->
        <div style="justify-content: space-between;" class="mb-4 d-flex">
            <h4>Patient Details</h4>
            <a href="javascript:history.back()" class="btn btn-danger">
                Go Back<i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
        <div class="card mb-4">
            <div class="card-header">Patient Information</div>
            <div class="card-body">
                <table class="table table-bordered table-patient-info">
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Address</th>
                        <th>Date of Birth</th>
                        <th>Medical History</th>

                    </tr>
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->email }}</td>
                        <td>{{ $patient->phone }}</td>
                        <td>{{ ucfirst($patient->status) }}</td>
                        <td>{{ $patient->address ?? 'Not Available' }}</td>
                        <td>{{ $patient->dob ?? 'Not Available' }}</td>
                        <td>{{ $patient->medical_history ?? 'Not Available' }}</td>
                    </tr>

                </table>
            </div>
        </div>
        <!-- Visit Month Selection -->
        <div class="card mb-4">
            <div class="card-header">Select Visit Month</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <select id="visitSelect" class="form-control">
                            <option value="">Select Visit Month</option>
                            @for ($month = 0; $month <= 12; $month++)
                                <option value="{{ $month }}">{{ $month }}</option>
                            @endfor
                        </select>

                    </div>
                    <div class="col-md-4">
                        <button id="fetchData" class="btn btn-primary">Show Proteins & Peptides</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Proteins & Peptides Display -->
        <div id="proteinPeptideContent">
            <!-- Protein and Peptide data will load here after selection -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#fetchData').on('click', function() {
                const visitId = $('#visitSelect').val();
                if (visitId) {
                    $.ajax({
                        url: "{{ route('doctor.fetch.protein.peptide') }}", // Define a route for this in web.php
                        method: 'GET',
                        data: { visit_id: visitId, patient_id: "{{ $patient->id }}" },
                        success: function(response) {
                            $('#proteinPeptideContent').html(response);
                        }
                    });
                } else {
                    alert('Please select a visit month.');
                }
            });
        });
    </script>
@endsection
