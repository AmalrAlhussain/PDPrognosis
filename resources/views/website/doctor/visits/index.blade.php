@extends('website.parts.dash')

@section('content')
    <div class="container">
        <h2>Patients Test</h2>
        <a style="float: right;" href="{{ route('doctor.visits.create') }}" class="btn btn-primary">Add New Test</a>
        @if($visits->isEmpty())
            <p>No visits found.</p>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient ID</th>
                    <th>Visit Month</th>
                    <th>Part 1 / Score</th>
                    <th>Part 2 / Score</th>
                    <th>Part 3 / Score</th>
                    <th>Part 4 / Score</th>
                    <th>Total Score</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach($visits as $visit)
                    @php
                        $total = 0;
                    @endphp
                    <tr>
                        <td>{{ optional($visit->patient)->id.'_'.$visit->visit_month }}</td>

                        <td>{{ $visit->patient->id }}</td>
                        <td>{{ $visit->visit_month }}</td>
                        <!-- Part 1 -->
                        <td>
                            @if($visit->surveys->where('part', 1)->count())
                                @php
                                    $part1_score = $visit->surveys->where('part', 1)->first()->final_score;
                                    $total += $part1_score;
                                @endphp
                                {{ $part1_score }}
                                <i class="fa fa-check text-success"></i>
                            @else
                                <button disabled>For Patient</button>
                            @endif
                        </td>

                        <!-- Part 2 -->
                        <td>
                            @if($visit->surveys->where('part', 2)->count())
                                @php
                                    $part2_score = $visit->surveys->where('part', 2)->first()->final_score;
                                    $total += $part2_score;
                                @endphp
                                {{ $part2_score }}
                                <i class="fa fa-check text-success"></i>
                            @else
                                <button disabled>For Patient</button>

                            @endif
                        </td>

                        <!-- Part 3 -->
                        <td>
                            @if($visit->surveys->where('part', 3)->count())
                                @php
                                    $part3_score = $visit->surveys->where('part', 3)->first()->final_score;
                                    $total += $part3_score;
                                @endphp
                                {{ $part3_score }}
                                <i class="fa fa-check text-success"></i>
                            @else
                                <a href="{{ route('doctor.surveys.selectPart', ['visit_id' => $visit->id, 'part' => 3,'patient_id' => $visit->patient_id]) }}" class="btn btn-primary btn-sm">Start Part 3</a>
                            @endif
                        </td>

                        <!-- Part 4 -->
                        <td>
                            @if($visit->surveys->where('part', 4)->count())
                                @php
                                    $part4_score = $visit->surveys->where('part', 4)->first()->final_score;
                                    $total += $part4_score;
                                @endphp
                                {{ $part4_score }}
                                <i class="fa fa-check text-success"></i>
                            @else
                                <a href="{{ route('doctor.surveys.selectPart', ['visit_id' => $visit->id, 'part' => 4, 'patient_id' => $visit->patient_id]) }}" class="btn btn-primary btn-sm">Start Part 4</a>
                            @endif
                        </td>

                        <!-- Total Score -->
                        <td>{{ $total }}</td>

                        <td>
{{--                            <a href="{{ route('doctor.visits.show', $visit->id) }}" class="btn btn-info btn-sm">View</a>--}}
                            <a href="{{ route('doctor.visits.edit', $visit->id) }}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>
                            <form action="{{ route('doctor.visits.destroy', $visit->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </form>
                                <a href="{{ route('doctor.surveys.show', ['survey_id' => $visit->id]) }}" class="btn btn-success btn-sm">View Test</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif


    </div>
@endsection
