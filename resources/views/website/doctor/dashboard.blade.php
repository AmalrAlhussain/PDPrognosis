@extends('website.parts.dash')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Patients Count -->
            <div class="col-md-4 market-update-gd">
                <div class="market-update-block clr-block-3">
                    <div class="col-md-8 market-update-left">
                        <h3>{{ $patientsCount }}</h3>
                        <h4>My Patients</h4>
                    </div>
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <!-- Visits Count -->
            <div class="col-md-4 market-update-gd">
                <div class="market-update-block clr-block-4">
                    <div class="col-md-8 market-update-left">
                        <h3>{{ $visitsCount }}</h3>
                        <h4>My Visits</h4>
                    </div>
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-calendar-check-o"></i>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <!-- Surveys Count -->
            <div class="col-md-4 market-update-gd">
                <div class="market-update-block clr-block-1">
                    <div class="col-md-8 market-update-left">
                        <h3>{{ $surveysCount }}</h3>
                        <h4>My Surveys</h4>
                    </div>
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-question-circle-o"></i>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <!-- Latest Patients -->
        <h5 class="mt-5">My Latest Patients</h5>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Patient Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date Joined</th>
            </tr>
            </thead>
            <tbody>
            @foreach($myPatients as $patient)
                <tr>
                    <td>{{ $patient->fullname }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Latest Visits -->
        <h5 class="mt-5">My Latest Visits</h5>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Patient Name</th>
                <th>Visit Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($myVisits as $visit)
                <tr>
                    <td>{{ $visit->patient->fullname }}</td>
                    <td>{{ $visit->visit_date }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Chart for Patient Visits -->
        <canvas class="mt-5" id="visitsChart"></canvas>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var patients = {!! json_encode($patients) !!};
        var visitCounts = {!! json_encode($visitCounts) !!};

        var ctx = document.getElementById('visitsChart').getContext('2d');
        var visitsChart = new Chart(ctx, {
            type: 'scatter', // Change type to 'scatter' for points
            data: {
                labels: patients, // Patient names
                datasets: [{
                    label: 'Number of Visits',
                    data: patients.map((patient, index) => {
                        return {x: index, y: visitCounts[index]}; // Use scatter format with x, y points
                    }),
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    pointRadius: 5, // Set the size of the points
                    showLine: false // Disable connecting lines between points
                }]
            },
            options: {
                scales: {
                    x: {
                        type: 'linear', // Set X axis as a linear scale
                        ticks: {
                            callback: function(value, index, values) {
                                return patients[index]; // Label X axis with patient names
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Visits'
                        }
                    }
                }
            }
        });
    </script>
@endpush
