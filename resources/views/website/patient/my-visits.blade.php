@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2>My Test Results</h2>
        @if($visits->isEmpty())
            <p>No Tests found.</p>
        @else
        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Visit Month</th>
                <th>Part 1 / Score</th>
                <th>Part 2 / Score</th>
                <th>Part 3 / Score</th>
                <th>Part 4 / Score</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($visits as $index => $visit)
                @php
                    $total = 0;
                    $getColor = function($score, $ranges) {
                        if ($score <= $ranges['low']) return '#90ee90'; // Green
                        if ($score <= $ranges['medium']) return '#ec9f53'; // Orange
                        return '#d22e2e'; // Red
                    };
                @endphp
                <tr>
                    <td>{{ optional($visit->patient)->id.'_'.$visit->visit_month }}</td>
                    <td>{{ $visit->visit_month }}</td>

                    <!-- Part 1 -->
                    <td style="background-color: {{ isset($visit->surveys->where('part', 1)->first()->final_score) ? $getColor($visit->surveys->where('part', 1)->first()->final_score, ['low' => 20, 'medium' => 30]) : '' }}">
                        @if($visit->surveys->where('part', 1)->count())
                            @php
                                $part1_score = $visit->surveys->where('part', 1)->first()->final_score;
                                $total += $part1_score;
                            @endphp
                            {{ $part1_score }}
                            <i class="fa fa-check text-success"></i>
                        @else
                            <a href="{{ route('patient.surveys.selectPart', ['visit_id' => $visit->id, 'part' => 1]) }}" class="btn btn-primary btn-sm">Start Part 1</a>
                        @endif
                    </td>

                    <!-- Part 2 -->
                    <td style="background-color: {{ isset($visit->surveys->where('part', 2)->first()->final_score) ? $getColor($visit->surveys->where('part', 2)->first()->final_score, ['low' => 20, 'medium' => 30]) : '' }}">
                        @if($visit->surveys->where('part', 2)->count())
                            @php
                                $part2_score = $visit->surveys->where('part', 2)->first()->final_score;
                                $total += $part2_score;
                            @endphp
                            {{ $part2_score }}
                            <i class="fa fa-check text-success"></i>
                        @else
                            <a href="{{ route('patient.surveys.selectPart', ['visit_id' => $visit->id, 'part' => 2]) }}" class="btn btn-primary btn-sm">Start Part 2</a>
                        @endif
                    </td>

                    <!-- Part 3 -->
                    <td style="background-color: {{ isset($visit->surveys->where('part', 3)->first()->final_score) ? $getColor($visit->surveys->where('part', 3)->first()->final_score, ['low' => 8, 'medium' => 14]) : '' }}">
                        @if($visit->surveys->where('part', 3)->count())
                            @php
                                $part3_score = $visit->surveys->where('part', 3)->first()->final_score;
                                $total += $part3_score;
                            @endphp
                            {{ $part3_score }}
                            <i class="fa fa-check text-success"></i>
                        @else
                            <button disabled>For Doctor</button>
                        @endif
                    </td>

                    <!-- Part 4 -->
                    <td style="background-color: {{ isset($visit->surveys->where('part', 4)->first()->final_score) ? $getColor($visit->surveys->where('part', 4)->first()->final_score, ['low' => 8, 'medium' => 14]) : '' }}">
                        @if($visit->surveys->where('part', 4)->count())
                            @php
                                $part4_score = $visit->surveys->where('part', 4)->first()->final_score;
                                $total += $part4_score;
                            @endphp
                            {{ $part4_score }}
                            <i class="fa fa-check text-success"></i>
                        @else
                            <button disabled>For Doctor</button>
                        @endif
                    </td>



                    <!-- Actions -->
                    <td>
                        <a href="{{ route('patient.surveys.show', ['survey_id' => $visit->id]) }}" class="btn btn-success btn-sm">View Test</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @endif
    </div>
@endsection
