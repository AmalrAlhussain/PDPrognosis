@extends('website.parts.dash')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Doctors Count -->
            <div class="col-md-3 market-update-gd">
                <div class="market-update-block clr-block-2">
                    <div class="col-md-8 market-update-left">
                        <h3>{{ $doctorsCount }}</h3>
                        <h4>Doctors</h4>
                    </div>
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-user-md"></i>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <!-- Patients Count -->
            <div class="col-md-3 market-update-gd">
                <div class="market-update-block clr-block-3">
                    <div class="col-md-8 market-update-left">
                        <h3>{{ $patientsCount }}</h3>
                        <h4>Patients</h4>
                    </div>
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-users"></i>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>



            <!-- Surveys Count -->
            <div class="col-md-3 market-update-gd">
                <div class="market-update-block clr-block-1">
                    <div class="col-md-8 market-update-left">
                        <h3>{{ $surveysCount }}</h3>
                        <h4>Tests</h4>
                    </div>
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-question-circle-o"></i>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <!-- Latest Patients -->
        <h5 class="mt-5">Latest Patients</h5>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Patient ID</th>
                <th>Email</th>
                <th>Mobile</th>
                <th>Date Joined</th>
            </tr>
            </thead>
            <tbody>
            @foreach($latestPatients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <!-- Latest Visits -->
        <h5 class="mt-5">Latest Visits</h5>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Patient ID</th>
                <th>Visit Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($latestVisits as $visit)
                <tr>
                    <td>{{ $visit->patient->id }}</td>
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
            type: 'bar',
            data: {
                labels: patients, // Patient names
                datasets: [{
                    label: 'Number of Visits',
                    data: visitCounts, // Number of visits per patient
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
    </script>

@endpush
