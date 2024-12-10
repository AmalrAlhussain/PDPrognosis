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
                <h6 style="font-family: Arial, sans-serif; font-size: 18px; font-weight: bold; color: #333; text-align: center; background-color: #f8f9fa; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 20px;">
                    The approach of typing and analyzing finger movements through key press duration, mouse stability, and typing accuracy aims to improve the identification of early symptoms and signs of the disease and its condition.
                </h6>


                <div style="overflow-x: auto; width: 100%; margin: 20px auto;">
                    <table style="width: 100%; border-collapse: collapse; margin: 10px 0; padding: 8px; text-align: left;">
                        <thead style="background-color: #007bff; color: white;">
                            <tr>
                                <th style="padding: 12px 15px; border: 1px solid #ddd;">Term</th>
                                <th style="padding: 12px 15px; border: 1px solid #ddd;">Parkinson's Patients	</th>
                                <th style="padding: 12px 15px; border: 1px solid #ddd;">Non-Patients</th>
                           </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding: 12px 15px; border: 1px solid #ddd;">Key Press Duration(ms)</td>
                                <td style="padding: 12px 15px; border: 1px solid #ddd;">300 ms</td>
                                <td style="padding: 12px 15px; border: 1px solid #ddd;">150 ms</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 15px; border: 1px solid #ddd;">Mouse Stability (Standard Deviation)</td>
                                <td style="padding: 12px 15px; border: 1px solid #ddd;">15.0</td>
                                <td style="padding: 12px 15px; border: 1px solid #ddd;">5.0</td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 15px; border: 1px solid #ddd;">Typing Accuracy (%)</td>
                                <td style="padding: 12px 15px; border: 1px solid #ddd;">75%</td>
                                <td style="padding: 12px 15px; border: 1px solid #ddd;">95%</td>
                            </tr>
                            <!-- Add more rows as needed -->
                        </tbody>
                    </table>
                </div>
                    <br>
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
                            <th>Created At</th>
                            <th>Status</th> <!-- New status column -->
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
                                <td>{{ $result->created_at->format('Y-m-d H:i') }}</td>
                                <td style="
                                    @php
                                        if ($result->mouse_stability <= 5 || $result->typing_accuracy >= 95) {
                                            echo 'background-color: #699280; color: white;';
                                        } elseif ($result->mouse_stability >= 15 && $result->typing_accuracy <= 75) {
                                            echo 'background-color: #623636; color: white;';
                                        } else {
                                            echo 'background-color:#B2734B ; color: white;';
                                        }
                                    @endphp
                                ">
                                    @php
                                        if ($result->mouse_stability <= 5 || $result->typing_accuracy >= 95) {
                                            echo 'Non-Patients';
                                        } elseif ($result->mouse_stability >= 15 && $result->typing_accuracy <= 75) {
                                            echo 'Patients';
                                        } else {
                                            echo 'In Between';
                                        }
                                    @endphp
                                </td>
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
                <h6 style="font-family: Arial, sans-serif; font-size: 18px; font-weight: bold; color: #333; text-align: center; background-color: #f8f9fa; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); margin-bottom: 20px;">
                    The REST-SPER test is a cognitive assessment that measures patients' ability to focus and pay attention. The test is based on the principle of circles appearing on the screen, where the user must click on the center of each circle as quickly as possible, with a duration ranging from 50 to 120 seconds.

                    When comparing the performance of Parkinson's patients with healthy individuals, a noticeable difference in response rates is observed: healthy individuals typically achieve 30 clicks or more, while Parkinson's patients often have a response rate ranging from 10 to 20 clicks.
                </h6>

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
                            <th>Played At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($gameResults as $result)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $result->score }}</td>
                                <td style="
                                    @if($result->total_games >= 30)
                                        background-color: #90ee90;
                                    @elseif($result->total_games >= 10 && $result->total_games <= 20)
                                        background-color: #d22e2e;
                                    @endif
                                ">
                                    {{ $result->total_games }}
                                </td>
                                <td>{{ $result->highest_score }}</td>
                                <td>{{ number_format($result->average_score, 2) }}</td>
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
