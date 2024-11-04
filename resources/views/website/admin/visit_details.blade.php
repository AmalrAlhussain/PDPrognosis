@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2 class="h222">Visit Details</h2>

        <table class="table table-bordered">
            <tr>
                <th>Visit Date</th>
                <td>{{ $visit->visit_date }}</td>
            </tr>
            <tr>
                <th>Doctor</th>
                <td>{{ $visit->doctor ? $visit->doctor->fullname : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Patient</th>
                <td>{{ $visit->patient ? $visit->patient->fullname : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Score</th>
                <td>{{ $visit->score ?? 'N/A' }}</td>
            </tr>
        </table>

<hr>
        <h4>Test Results</h4>
        @if($visit->testResults->isEmpty())
            <p>No test results available for this visit.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Test Name</th>
                    <th>Result</th>
                </tr>
                </thead>
                <tbody>
                @foreach($visit->testResults as $testResult)
                    <tr>
                        <td>{{ $testResult->test_name }}</td>
                        <td>{{ $testResult->result }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <hr>        <h4>Surveys</h4>
        @if($visit->surveys->isEmpty())
            <p>No surveys filled for this visit.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Survey Title</th>
                    <th>Response</th>
                </tr>
                </thead>
                <tbody>
                @foreach($visit->surveys as $survey)
                    <tr>
                        <td>{{ $survey->title }}</td>
                        <td>{{ $survey->response }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
