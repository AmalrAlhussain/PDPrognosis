@extends('website.parts.dash')

@push('css')
    <style>
        .filter-box {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            background-color: #f9f9f9;
        }

        .filter-box h5 {
            margin-bottom: 15px;
            font-weight: bold;
        }

        .table-patient-info th, .table-patient-info td {
            padding: 10px;
        }

        .card-header.collapsible {
            cursor: pointer;
        }

    </style>
@endpush

@section('content')
    <div style="padding-bottom: 100px;" class="container">

        <!-- Back Button -->
        <div style="justify-content: space-between;" class="mb-4 d-flex">
            <h4>Patient Profile: {{ $patient->fullname }}</h4>
            <a href="javascript:history.back()" class="btn btn-danger">
                Go Back<i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
        <!-- Patient Information -->
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

        <!-- Filter Search for Visits by Date Range -->
        <div class="filter-box">
            <h5>Filter Visits by Date Range</h5>
            <form id="dateFilterForm">
                <div class="row">
                    <div class="col-md-4">
                        <label for="startDate">Start Date</label>
                        <input type="date" id="startDate" class="form-control">
                    </div>
                    <div class="col-md-4">
                        <label for="endDate">End Date</label>
                        <input type="date" id="endDate" class="form-control">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="button" id="filterButton" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Patient Visits -->
        <h4>Visits</h4>
        @if($patient->visits->isEmpty())
            <p>No visits found.</p>
        @else
            @foreach($patient->visits as $visit)
                <div class="card mb-4 visit-card" data-visit-date="{{ $visit->visit_date }}">
                    <div class="card-header collapsible" data-toggle="collapse" data-target="#visit-{{ $visit->id }}">
                        Visit on {{ $visit->visit_date }} (Click to expand/collapse)
                    </div>
                    <div id="visit-{{ $visit->id }}" class="collapse">
                        <div class="card-body">
                            <p><strong>Notes:</strong> {{ $visit->notes }}</p>

                            <!-- Survey Scores -->
                            @if($visit->surveys->isNotEmpty())
                                <h5>Survey Scores</h5>
                                <canvas id="surveyChart-{{ $visit->id }}" width="400" height="200"></canvas>
                            @else
                                <p>No surveys completed for this visit.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Chart.js for displaying survey scores
        @foreach($patient->visits as $visit)
        @if($visit->surveys->isNotEmpty())
        var ctx = document.getElementById('surveyChart-{{ $visit->id }}').getContext('2d');
        var surveyChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Part 1', 'Part 2', 'Part 3', 'Part 4'],
                datasets: [{
                    label: 'Survey Scores',
                    data: [
                        @foreach($visit->surveys as $survey)
                            {{ $survey->final_score }},
                        @endforeach
                    ],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        @endif
        @endforeach

        // Collapse functionality for visits
        document.querySelectorAll('.collapsible').forEach(function (header) {
            header.addEventListener('click', function () {
                const collapseElement = document.getElementById(header.getAttribute('data-target').replace('#', ''));
                collapseElement.classList.toggle('show');
            });
        });

        // Date range filter functionality
        document.getElementById('filterButton').addEventListener('click', function () {
            var startDate = document.getElementById('startDate').value;
            var endDate = document.getElementById('endDate').value;

            document.querySelectorAll('.visit-card').forEach(function (card) {
                var visitDate = card.getAttribute('data-visit-date');

                // Check if the visit date falls within the selected date range
                if ((startDate === '' || visitDate >= startDate) && (endDate === '' || visitDate <= endDate)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    </script>
@endpush
