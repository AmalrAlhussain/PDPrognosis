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
            height: 200px; /* Set a fixed height for each box */
            /*overflow-y: auto; !* Add scroll for overflow content *!*/
            margin-right: 15px; /* Add margin between boxes */
        }

        .survey-card:last-child {
            margin-right: 0; /* No margin for the last box in the row */
        }

        .survey-question {
            font-size: 13px;
            text-align: left;
        }

        .survey-answer {
            font-size: 12px;
            text-align: left;
            background: #046e00ad;
            color: white;
            padding: 7px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 10px 20px;
            font-size: 18px;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        @if(count($surveies))
        <!-- Back Button -->
        <div style="justify-content: space-between;" class="mb-4 d-flex">
            <h4>Survey Details: [{{ optional($surveies->first()->patient)->id }}]</h4>
            <a href="javascript:history.back()" class="btn btn-danger">
                Go Back<i class="fa fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
        @foreach($surveies as $survey)
            <h4 class="mb-4">Part {{$survey->part}} (Total Score {{$survey->final_score}} )</h4>
            <div class="row">
                @foreach($survey->surveyAnswers as $index => $answer)
                    <div class="col-md-4">
                        <div class=" survey-card">
                            <div class="form-group d-flex flex-column justify-content-between h-100">
                                <p class="survey-question"><i class="fa fa-question-circle"></i> {{$index + 1}} : {{ $answer->question->question_text }}</p>
                                <p class="survey-answer">
                                    <strong>Answer: ({{$answer->answer_text}})</strong>
                                    @switch($answer->answer_text)
                                        @case(0)
                                            0: Normal
                                            @break
                                        @case(1)
                                            1: Slight
                                            @break
                                        @case(2)
                                            2: Mild
                                            @break
                                        @case(3)
                                            3: Moderate
                                            @break
                                        @case(4)
                                            4: Severe
                                            @break
                                    @endswitch
                                </p>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
        <!-- Back to Visits Button -->
        @else
            <div style="justify-content: space-between;" class="mb-4 d-flex">
                <h4>No Answers Yet</h4>
                <a href="javascript:history.back()" class="btn btn-danger">
                    Go Back<i class="fa fa-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        @endif
    </div>
@endsection
