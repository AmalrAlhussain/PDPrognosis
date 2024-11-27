<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\ParkinsonGameResult;
use App\Models\Patient;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\TypingTestResult;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PatientAuthController extends Controller
{
    public function dashboard()
    {
        $authUser = Auth::guard('patient')->user();
        $myDoctor = $authUser->doctor;
        $myVisits = $authUser->visits()->with('doctor')->orderBy('visit_date', 'desc')->take(5)->get();
        $mySurveys = $authUser->surveys()->orderBy('created_at', 'desc')->take(5)->get();
        $visitsCount = $authUser->visits()->take(12)->get()->count();
        $surveysCount = $authUser->surveys()->count();

        $gameResults = ParkinsonGameResult::where('patient_id', $authUser->id)->orderBy('created_at', 'desc')->get();

        $typingResults = \App\Models\TypingTestResult::where('patient_id', $authUser->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('website.patient.dashboard', compact('authUser', 'gameResults','visitsCount', 'surveysCount', 'myVisits', 'mySurveys', 'typingResults'));
    }


    public function showLoginForm()
    {
        return view('website.patient.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');
        $patient = Patient::where('username', $request->username)->first();
        if ($patient && $patient->status == 1) {
            if (Auth::guard('patient')->attempt($credentials)) {
                return redirect()->route('patient.profile');
            }
            return back()->withErrors(['password' => 'Invalid username or password'])->withInput();
        }
        return back()->withErrors(['password' => 'Invalid username or password or your account is inactive'])->withInput();
    }

    public function showRegisterForm()
    {
        return view('website.patient.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'doctor_id ' => 'required',
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patient',
            'username' => 'required|string|max:255|unique:patient',
            'password' => [
                'required',
                'string',
                'min:8', // At least 8 characters
                'confirmed', // Must match the confirmation
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[0-9]/', // At least one number
                'regex:/[@$!%*?&]/', // At least one special character
            ],
            'phone' => 'required|numeric|digits:10',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator)->withInput();
        }

        $patient = Patient::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'username' => $request->username,
            'doctor_id' => $request->doctor_id,
            'status' => 1,
        ]);

        Auth::guard('patient')->login($patient);

        return redirect()->route('patient.profile');
    }

    // Show profile page
    public function profile()
    {
        $patient = Auth::guard('patient')->user();
        return view('website.patient.profile', compact('patient'));
    }

    // Update profile information
    public function updateProfile(Request $request)
    {
        $patient = Auth::guard('patient')->user();

        $validator = Validator::make($request->all(), [
            'phone' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator)->withInput();
        }

        $patient->update($request->only('fullname', 'phone'));

        if ($request->filled('password')) {
            $patient->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return back()->with('status', 'Profile updated successfully');
    }

    // Logout
    public function logout()
    {
        Auth::guard('admin')->logout();
        Auth::guard('doctor')->logout();
        Auth::guard('patient')->logout();
        return redirect()->route('patient.login');
    }


    public function getMyVisits()
    {
        $authUser = Auth::guard('patient')->user();
        $visits = $authUser->visits()->take(12)->with('doctor', 'surveys')->orderBy('visit_date', 'desc')->get();

        return view('website.patient.my-visits', compact('visits'));
    }



    public function selectPart(Request $request)
    {
        $visit_id = $request->visit_id;
        $patient_id = $request->patient_id;
        $visit = Visit::find($visit_id);

        return view('website.patient.surveys.select_part', compact('visit_id', 'patient_id', 'visit'));
    }

    public function create(Request $request)
    {
        $patient = Patient::findOrFail(\auth('patient')->id());
        $visit = Visit::findOrFail($request->visit_id);
        $questions = SurveyQuestion::where('part', $request->part)->get();
        $part = $request->part;

        // If no questions found, redirect back with a message
        if ($questions->isEmpty()) {
            return redirect()->back()->with('error', 'No questions found for the selected part of the survey.');
        }

        return view('website.patient.surveys.create', compact('patient', 'questions', 'visit', 'part'));
    }


    // Store survey answers
    public function store(Request $request)
    {
        $patient = Auth::guard('patient')->user();
        $survey = Survey::create([
            'survey_date' => now(),
            'doctor_id' => optional($patient->doctor)->id,
            'patient_id' => $patient->id,
            'doctor_filled' => false,
            'visit_id' => $request->visit_id,
            'part' => $request->part,
        ]);
        $totalScore = 0;
        foreach ($request->answers as $question_id => $answer) {
            $survey->surveyAnswers()->create([
                'question_id' => $question_id,
                'answered_by' => 'doctor',
                'survey_id' => $survey->id,
                'answer_text' => $answer,
            ]);
            $totalScore += (int) $answer;
        }
        // Update the visit's score with the total score
        $visit = \App\Models\Visit::find($request->visit_id);
        $visit->score = $visit->score + $totalScore;
        $visit->save();
        $survey->update([
            'final_score' => $totalScore
        ]);
        return redirect()->route('patient.my-visits')->with('success', 'Survey completed successfully.');
    }
    public function show($id)
    {
        // Retrieve the survey along with the related answers and questions
        $surveies = Survey::whereIn('part', [1,2,3,4])->with('surveyAnswers.question')->where('visit_id', $id)->get();
        return view('website.patient.surveys.show', compact('surveies'));
    }


    public function storeTypingTestResults(Request $request)
    {
        $validated = $request->validate([
            'key_durations' => 'required|json',
            'mouse_stability' => 'required|numeric',
            'typing_accuracy' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $result = TypingTestResult::create([
            'patient_id' => Auth::guard('patient')->id(),
            'key_durations' => $validated['key_durations'],
            'mouse_stability' => $validated['mouse_stability'],
            'typing_accuracy' => $validated['typing_accuracy'],
            'feedback' => $validated['feedback'],
        ]);

        return redirect()->route('patient.dashboard')->with('success', 'Typing test results saved successfully.');
    }


    public function focus_game(Request $request)
    {
//        $request->validate([
//            'score' => 'required|integer',
//            'total_games' => 'required|integer',
//            'highest_score' => 'required|integer',
//            'average_score' => 'required|numeric',
//            'feedback' => 'required|string',
//        ]);
        $data = $request->all();
        $data['patient_id'] = Auth::guard('patient')->id();
        $result = ParkinsonGameResult::create($data);
        return response()->json([
            'success' => true,
            'message' => 'Game results saved successfully.',
            'data' => $result,
        ]);
    }

}
