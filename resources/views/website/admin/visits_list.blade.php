@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2 class="h222">All Visits</h2>
        @if($visits->isEmpty())
            <p>No visits recorded yet.</p>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Visit Date</th>
                    <th>Doctor</th>
                    <th>Patient</th>
                    <th>Score</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($visits as $visit)
                    <tr>
                        <td>{{ $visit->id }}</td>
                        <td>{{ $visit->visit_date }}</td>
                        <td>{{ $visit->doctor ? $visit->doctor->fullname : 'N/A' }}</td>
                        <td>{{ $visit->patient ? $visit->patient->id : 'N/A' }}</td>
                        <td>{{ $visit->score ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.visit.view', $visit->id) }}" class="btn btn-info btn-sm">View Details</a>

                            <!-- Upload Button to trigger modal -->
                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#fileTypeModal" data-visit-id="{{ $visit->id }}" data-patient-id="{{ $visit->patient_id }}">
                                <i class="fa fa-upload"></i> Select File Type
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Modal Structure for File Type Selection -->
    <div class="modal fade" id="fileTypeModal" tabindex="-1" aria-labelledby="fileTypeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileTypeModalLabel">Select File Type to Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <p>Please select the type of file you want to upload:</p>

                    <!-- Buttons for selecting file type -->
                    <button type="button" class="btn btn-primary m-2 file-type-button" data-file-type="protein">Protein File</button>
                    <button type="button" class="btn btn-secondary m-2 file-type-button" data-file-type="peptide">Peptide File</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#fileTypeModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var visitId = button.data('visit-id');
                var patientId = button.data('patient-id');

                // Attach visit_id and patient_id to buttons
                $('.file-type-button').data('visit-id', visitId).data('patient-id', patientId);
            });

            // Handle button clicks and redirect
            $('.file-type-button').on('click', function () {
                var fileType = $(this).data('file-type');
                var visitId = $(this).data('visit-id');
                var patientId = $(this).data('patient-id');

                // Redirect to the upload page with parameters
                window.location.href = `{{ route('admin.uploadFile') }}?file_type=${fileType}&visit_id=${visitId}&patient_id=${patientId}`;
            });
        });
    </script>
@endsection
