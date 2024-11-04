@extends('website.parts.dash')

@push('css')
    <style>
        .survey-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 20px;
            background-color: #f9f9f9;
        }

        .survey-card .form-group {
            margin-bottom: 0;
        }

        .survey-question {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
            text-align: left;
        }

        .survey-answer {
            display: flex;
            flex-direction: column;
        }

        .survey-answer label {
            margin-bottom: 10px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 18px;
        }
        .lineStart {
            text-align: left;
            background: #ececec;
            padding: 16px;
            border-radius: 10px;
            font-size: 16px;
            line-height: 32px;
        }
        .patinname {
            text-align: center;
            background: #52b586;
            padding: 17px;
            color: white;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="container mb-5">
        <h4 class="mb-4 patinname">Survey for Patient: {{ $patient->fullname }} & Part : {{$part}}</h4>
        <div>
            <p class="lineStart">
                I am going to ask you six questions about behaviors that you may or may not experience.
Some questions concern common problems and some concern uncommon ones.  If you have a problem in one of the areas, please choose the best response that describes how you have felt MOST OF THE TIME during the PAST WEEK. If you are not bothered by a problem, you can simply respond NO.  I am trying to be thorough, so I may ask questions that have nothing to do with you.
            </p>
        </div>

        <form class="mb-5" action="{{ route('patient.surveys.store') }}" method="POST">
            @csrf
            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
            <input type="hidden" name="visit_id" value="{{ $visit->id }}">
            <input type="hidden" name="part" value="{{ $part }}">

            @foreach($questions as $question)
                <div class="survey-card">
                    <div class="form-group">
                        <p class="survey-question">{{ $question->question_text }}</p>
                        <span class="text-muted">{{$question->instructions}}</span>
                        <div class="survey-answer">
                            <label>
                                <input type="radio" name="answers[{{ $question->id }}]" value="0" required>
                                0: Normal
                            </label>
                            <label>
                                <input type="radio" name="answers[{{ $question->id }}]" value="1">
                                1: Slight
                            </label>
                            <label>
                                <input type="radio" name="answers[{{ $question->id }}]" value="2">
                                2: Mild
                            </label>
                            <label>
                                <input type="radio" name="answers[{{ $question->id }}]" value="3">
                                3: Moderate
                            </label>
                            <label>
                                <input type="radio" name="answers[{{ $question->id }}]" value="4">
                                4: Severe
                            </label>
                        </div>
                    </div>
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary mb-5 btn-block">Submit Survey</button>
        </form>
    </div>
@endsection
