@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2 class="text-center">Game Results for {{ $patient->id }}</h2>

        <!-- Game 1 Results -->
        <h3 class="text-center mt-5">Focus Game Results</h3>
        @if($patient->gameResults->isEmpty())
            <p class="text-center text-muted">No results available for the Focus Game.</p>
        @else
            <table class="table table-striped table-bordered mt-4">
                <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Score</th>
                    <th>Total Games</th>
                    <th>Highest Score</th>
                    <th>Average Score</th>
                    <th>Feedback</th>
                    <th>Played At</th>
                </tr>
                </thead>
                <tbody>
                @foreach($patient->gameResults as $result)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $result->score }}</td>
                        <td>{{ $result->total_games }}</td>
                        <td>{{ $result->highest_score }}</td>
                        <td>{{ number_format($result->average_score, 2) }}</td>
                        <td>{{ $result->feedback }}</td>
                        <td>{{ $result->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <!-- Typing Game Results -->
        <h3 class="text-center mt-5">Typing Diagnosis Game Results</h3>
        @if($patient->typingGameResults->isEmpty())
            <p class="text-center text-muted">No results available for the Typing Diagnosis Game.</p>
        @else
            <table class="table table-striped table-bordered mt-4">
                <thead class="table-primary">
                <tr>
                    <th>#</th>
                    <th>Key Durations (ms)</th>
                    <th>Mouse Stability</th>
                    <th>Typing Accuracy (%)</th>
                    <th>Feedback</th>
                    <th>Played At</th>
                </tr>
                </thead>
                <tbody>
                @foreach($patient->typingGameResults as $result)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @php
                                $durations = json_decode($result->key_durations);
                                echo implode(', ', $durations);
                            @endphp
                        </td>
                        <td>{{ number_format($result->mouse_stability, 2) }}</td>
                        <td>{{ number_format($result->typing_accuracy, 2) }}</td>
                        <td>{{ $result->feedback }}</td>
                        <td>{{ $result->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <!-- Back Button -->
        <div class="text-center mt-4">
            <a href="{{ route('doctor.my-patients') }}" class="btn btn-secondary">Back to Patients</a>
        </div>
    </div>
@endsection
