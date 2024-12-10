@extends('website.parts.dash')

@section('content')
    <div class="container">

        <!-- Back Button -->
        <div style="justify-content: space-between;" class="mb-4 d-flex">
            <h4>Patient Details: {{ $patient->fullname }}</h4>
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
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Address</th>
                        <th>Date of Birth</th>
                        <th>Medical History</th>

                    </tr>
                    <tr>
                        <td>{{ $patient->id }}</td>
                        <td>{{ $patient->fullname }}</td>
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
        <div class="row">
            <!-- Protein Box -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <i class="fa fa-dna" aria-hidden="true"></i> Proteins
                    </div>
                    <div class="card-body">
                        @if($proteins->isEmpty())
                            <p>No proteins found for this patient.</p>
                        @else
                            <ul class="list-group">
                                @foreach($proteins as $protein)
                                    <li class="list-group-item">
                                        <strong>UniProt:</strong> {{ $protein->UniProt }} <br>
                                        <strong>NPX:</strong> {{ $protein->NPX }}
                                        <br>
                                        <br>
                                        <strong></strong>
                                        <div class="mt-2">
                                            <!-- View UniProt button -->
                                            <a href="https://www.uniprot.org/uniprotkb/{{ $protein->UniProt }}" target="_blank" class="btn btn-primary btn-sm">
                                                View UniProt
                                            </a>
                                            <!-- Show details button -->
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#proteinModal{{ $protein->id }}">
                                                Show Details
                                            </button>
                                        </div>
                                    </li>

                                    <!-- Protein Modal -->
                                    <div class="modal fade" id="proteinModal{{ $protein->id }}" tabindex="-1" role="dialog" aria-labelledby="proteinModalLabel{{ $protein->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="proteinModalLabel{{ $protein->id }}">Protein Details - {{ $protein->UniProt }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>UniProt ID:</strong> {{ $protein->UniProt }}</p>
                                                    <p><strong>NPX:</strong> {{ $protein->NPX }}</p>
                                                    <p><strong>Visit ID:</strong> {{ $protein->visit_id }}</p>
                                                    <p><strong>Visit Month:</strong> {{ $protein->visit_month }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Peptide Box -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <i class="fa fa-vial" aria-hidden="true"></i> Peptides
                    </div>
                    <div class="card-body">
                        @if($peptides->isEmpty())
                            <p>No peptides found for this patient.</p>
                        @else
                            <ul class="list-group">
                                @foreach($peptides as $peptide)
                                    <li class="list-group-item">
                                        <strong>UniProt:</strong> {{ $peptide->UniProt }} <br>
                                        <strong>Peptide:</strong> {{ $peptide->Peptide }} <br>
                                        <strong>Abundance:</strong> {{ $peptide->PeptideAbundance }}
                                        <div class="mt-2">
                                            <!-- View UniProt button -->
                                            <a href="https://www.uniprot.org/peptide-search?peps={{ $peptide->Peptide }}" target="_blank" class="btn btn-primary btn-sm">
                                                View UniProt
                                            </a>
                                            <!-- Show details button -->
                                            <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#peptideModal{{ $peptide->id }}">
                                                Show Details
                                            </button>
                                        </div>
                                    </li>

                                    <!-- Peptide Modal -->
                                    <div class="modal fade" id="peptideModal{{ $peptide->id }}" tabindex="-1" role="dialog" aria-labelledby="peptideModalLabel{{ $peptide->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="peptideModalLabel{{ $peptide->id }}">Peptide Details - {{ $peptide->UniProt }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p><strong>UniProt ID:</strong> {{ $peptide->UniProt }}</p>
                                                    <p><strong>Peptide:</strong> {{ $peptide->Peptide }}</p>
                                                    <p><strong>Peptide Abundance:</strong> {{ $peptide->PeptideAbundance }}</p>
                                                    <p><strong>Visit ID:</strong> {{ $peptide->visit_id }}</p>
                                                    <p><strong>Visit Month:</strong> {{ $peptide->visit_month }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add bootstrap JS and jQuery for modal functionality -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
@endsection
