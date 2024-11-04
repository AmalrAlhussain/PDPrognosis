<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function selectPart(Request $request)
    {
        $visit_id = $request->visit_id;
        $patient_id = $request->patient_id;
        $visit = Visit::find($visit_id);

        return view('website.doctor.surveys.select_part', compact('visit_id', 'patient_id', 'visit'));
    }

    public function create(Request $request)
    {
        $patient = Patient::findOrFail($request->patient_id);
        $visit = Visit::findOrFail($request->visit_id);
        $questions = SurveyQuestion::where('part', $request->part)->get();
        $part = $request->part;

        // If no questions found, redirect back with a message
        if ($questions->isEmpty()) {
            return redirect()->back()->with('error', 'No questions found for the selected part of the survey.');
        }

        return view('website.doctor.surveys.create', compact('patient', 'questions', 'visit', 'part'));
    }


    // Store survey answers
    public function store(Request $request)
    {
        $survey = Survey::create([
            'survey_date' => now(),
            'doctor_id' => Auth::guard('doctor')->id(),
            'patient_id' => $request->patient_id,
            'doctor_filled' => true,
            'visit_id' => $request->visit_id,
            'part' => $request->part,
        ]);
// Initialize total score
        $totalScore = 0;

        // Loop through answers and store each one
        foreach ($request->answers as $question_id => $answer) {
            $survey->surveyAnswers()->create([
                'question_id' => $question_id,
                'answered_by' => 'doctor',
                'survey_id' => $survey->id,  // Corrected survey_id
                'answer_text' => $answer,
            ]);

            // Sum up the answers for score calculation
            $totalScore += (int) $answer;
        }
        // Update the visit's score with the total score
        $visit = \App\Models\Visit::find($request->visit_id);
        $visit->score = $totalScore;
        $visit->save();
        $survey->update([
            'final_score' => $totalScore
        ]);
        return redirect()->route('doctor.visits.index')->with('success', 'Survey completed successfully.');
    }


    // Show a specific survey with its questions and answers
    public function show($id)
    {
        // Retrieve the survey along with the related answers and questions
        $surveies = Survey::whereIn('part', [1,2,3,4])->with('surveyAnswers.question')->where('visit_id', $id)->get();
        return view('website.doctor.surveys.show', compact('surveies'));
    }
}
