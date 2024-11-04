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
                        <h4>My Surveys</h4>
                    </div>
                    <div class="col-md-4 market-update-right">
                        <i class="fa fa-question-circle-o"></i>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <!-- Latest Visits -->
{{--        <h5 class="mt-5">My Latest Visits</h5>--}}
{{--        <table class="table table-bordered">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>Doctor Name</th>--}}
{{--                <th>Visit Date</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach($myVisits as $visit)--}}
{{--                <tr>--}}
{{--                    <td>{{ $visit->doctor->fullname }}</td>--}}
{{--                    <td>{{ $visit->visit_date }}</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}

        <!-- Latest Surveys -->
{{--        <h5 class="mt-5">My Latest Surveys</h5>--}}
{{--        <table class="table table-bordered">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>Survey Date</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @foreach($mySurveys as $survey)--}}
{{--                <tr>--}}
{{--                    <td>{{ $survey->created_at->format('Y-m-d') }}</td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
    </div>
@endsection
