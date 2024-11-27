@extends('website.parts.dash')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Visits Count -->
            <div class="col-md-6 market-update-gd">
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
            <div class="col-md-6 market-update-gd">
                <div class="market-update-block clr-block-1">
                    <div class="col-md-8 market-update-left">
                        <h3>{{ $surveysCount }}</h3>
                        <h4>My Tests</h4>
                    </div>
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-question-circle-o"></i>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


        <!-- Results Table -->
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="text-center">Typing Diagnosis Results</h3>
                <a style="float: right;margin-bottom: 10px;" target="_blank" href="{{ route('patient.quiz_game').'?patient_id='.auth('patient')->user()->id }}" class="btn btn-primary btn-lg">
                    <i class="fa fa-gamepad mr-2"></i> Start Game
                </a>
                @if ($typingResults->isEmpty())
                    <p class="text-center text-muted">No results found.</p>
                @else
                    <table class="table table-bordered table-striped">
                        <thead class="table-primary">
                        <tr>
                            <th>#</th>
                            <th>Key Durations (ms)</th>
                            <th>Mouse Stability</th>
                            <th>Typing Accuracy (%)</th>
{{--                            <th>Feedback</th>--}}
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($typingResults as $result)
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
{{--                                <td>{!! $result->feedback !!}</td>--}}
                                <td>{{ $result->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-12">
                <h3 class="text-center">Focus Game Results</h3>
                <a style="float: right;margin-bottom: 10px;" target="_blank" href="{{ route('patient.game_1').'?patient_id='.auth('patient')->user()->id }}" class="btn btn-primary btn-lg">
                    <i class="fa fa-gamepad mr-2"></i> Start Game
                </a>
                @if ($gameResults->isEmpty())
                    <p class="text-center text-muted">No results found.</p>
                @else
                    <table class="table table-bordered table-striped">
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
                        @foreach ($gameResults as $result)
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
            </div>
        </div>
    </div>
@endsection
