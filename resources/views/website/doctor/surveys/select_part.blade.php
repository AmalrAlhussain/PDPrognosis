@extends('website.parts.dash')

@push('css')
    <style>
        .survey-part {
            display: inline-block;
            width: 60%;
            margin: 10px;
            padding: 20px;
            border-radius: 10px;
            font-size: 18px;
            font-weight: bold;
            color: white;
            text-align: left;
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
        }

        .survey-part:hover {
            transform: scale(1.05);
        }

        /* Green for parts that haven't been completed */
        .part-not-done {
            background-color: #28a745;
        }

        /* Red for parts that have been completed */
        .part-done {
            background-color: #dc3545;
            cursor: not-allowed;
        }

        .survey-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <h2 class="mb-4">Select Survey Part</h2>

        <div class="survey-container">
            @auth('doctor')
                <!-- Part III: Motor Examination -->
                @if($visit->surveys->where('part', 3)->isNotEmpty())
                    <div class="survey-part part-done">
                        Part III: Motor Examination - DONE
                    </div>
                @else
                    <a href="{{ route('doctor.surveys.create', ['visit_id' => $visit_id, 'patient_id' => $patient_id, 'part' => 3]) }}"
                       class="survey-part part-not-done">
                        Part III: Motor Examination
                    </a>
                @endif

                <!-- Part IV: Motor Complications -->
                @if($visit->surveys->where('part', 4)->isNotEmpty())
                    <div class="survey-part part-done">
                        Part IV: Motor Complications - DONE
                    </div>
                @else
                    <a href="{{ route('doctor.surveys.create', ['visit_id' => $visit_id, 'patient_id' => $patient_id, 'part' => 4]) }}"
                       class="survey-part part-not-done">
                        Part IV: Motor Complications
                    </a>
                @endif



            @else
                <!-- Part I: Non-Motor Aspects of Daily Living -->
                @if($visit->surveys->where('part', 1)->isNotEmpty())
                    <div class="survey-part part-done">
                        Part I: Non-Motor Aspects of Daily Living (nM-EDL) - DONE
                    </div>
                @else
                    <a href="{{ route('doctor.surveys.create', ['visit_id' => $visit_id, 'patient_id' => $patient_id, 'part' => 1]) }}"
                       class="survey-part part-not-done">
                        Part I: Non-Motor Aspects of Daily Living (nM-EDL)
                    </a>
                @endif

                <!-- Part II: Motor Aspects of Daily Living -->
                @if($visit->surveys->where('part', 2)->isNotEmpty())
                    <div class="survey-part part-done">
                        Part II: Motor Aspects of Daily Living (M-EDL) - DONE
                    </div>
                @else
                    <a href="{{ route('doctor.surveys.create', ['visit_id' => $visit_id, 'patient_id' => $patient_id, 'part' => 2]) }}"
                       class="survey-part part-not-done">
                        Part II: Motor Aspects of Daily Living (M-EDL)
                    </a>
                @endif
            @endauth
        </div>
    </div>
@endsection
