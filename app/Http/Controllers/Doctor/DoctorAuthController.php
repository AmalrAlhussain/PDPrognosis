<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Peptide;
use App\Models\Protein;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DoctorAuthController extends Controller
{
    public function dashboard()
    {
        $authUser = Auth::guard('doctor')->user();
        $myPatients = $authUser->patients()->orderBy('created_at', 'desc')->take(5)->get();
        $myVisits = $authUser->visits()->with('patient')->orderBy('visit_date', 'desc')->take(5)->get();
        $mySurveys = $authUser->surveys()->orderBy('created_at', 'desc')->take(5)->get();
        $patientsCount = $authUser->patients()->count();
        $visitsCount = $authUser->visits()->count();
        $surveysCount = $authUser->surveys()->count();
        $visitData = $authUser->visits()->selectRaw('COUNT(id) as visit_count, patient_id')
            ->groupBy('patient_id')
            ->with('patient')
            ->get();
        $patients = $visitData->pluck('patient.fullname');
        $visitCounts = $visitData->pluck('visit_count');
        return view('website.doctor.dashboard', compact(
            'authUser', 'patientsCount', 'visitsCount', 'surveysCount', 'myPatients', 'myVisits', 'patients', 'visitCounts'
        ));
    }

    public function showLoginForm()
    {
        return view('website.doctor.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('username', 'password');
        $doctor = Doctor::where('username', $request->username)->first();
        if ($doctor && $doctor->status == 1) {
            if (Auth::guard('doctor')->attempt(['username' => $request->username, 'password' => $request->password])) {
                return redirect()->route('doctor.profile');
            }
            return back()->withErrors(['password' => 'Invalid username or password'])->withInput();
        }
        return back()->withErrors(['password' => 'Invalid username or password or your account is inactive'])->withInput();
    }

    // Show registration form
    public function showRegisterForm()
    {
        return view('website.doctor.register');
    }

    // Handle registration
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:doctor',
            'username' => 'required|string|max:255|unique:doctor',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|numeric|digits:11',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator)->withInput();
        }

        $doctor = Doctor::create([
            'fullname' => $request->fullname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'username' => $request->username,
            'status' => 1, // Default status can be set as active (1)
        ]);

        Auth::guard('doctor')->login($doctor);

        return redirect()->route('doctor.profile');
    }

    // Show profile page
    public function profile()
    {
        $doctor = Auth::guard('doctor')->user();
        return view('website.doctor.profile', compact('doctor'));
    }

    // Update profile information
    public function updateProfile(Request $request)
    {
        $doctor = Auth::guard('doctor')->user();

        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator)->withInput();
        }

        // Update all fillable fields except password unless it's provided
        $doctor->update($request->only('fullname', 'phone', 'specialty'));

        // If password is provided, hash and update it
        if ($request->filled('password')) {
            $doctor->update([
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
        return redirect()->route('doctor.login');
    }


    public function myPatients()
    {
        $doctor = Auth::guard('doctor')->user();
        $patients = $doctor->patients()->where('status', 1)->orderBy('id','desc')->get(); // Fetch only accepted patients
        return view('website.doctor.my_patients', compact('patients'));
    }
    public function showPatient($id)
    {
        // Find the patient by ID
        $patient = Patient::with('visits.surveys')->findOrFail($id);

        return view('website.doctor.patients.profile', compact('patient'));
    }


    // View the list of proteins for a specific patient
    public function listProteins($patient_id)
    {
        $proteins = Protein::where('patient_id', $patient_id)->get();
        $patient = Patient::findOrFail($patient_id);
        return view('website.doctor.patients.proteins', compact('proteins', 'patient'));
    }

    public function listPeptides($patient_id)
    {
        $peptides = Peptide::where('patient_id', $patient_id)->get();
        $patient = Patient::findOrFail($patient_id);
        return view('website.doctor.patients.peptides', compact('peptides', 'patient'));
    }

    public function showDetails($patient_id)
    {
        $patient = Patient::findOrFail($patient_id);
        $proteins = collect();
        $peptides = collect();
        $visits = Visit::where('patient_id', $patient_id)
            ->select('id', 'visit_month')
            ->get()
            ->unique('visit_month')
            ->pluck('visit_month', 'id');
        return view('website.doctor.patients.protein_peptide', compact('patient', 'proteins', 'peptides', 'visits'));
    }
    public function fetchProteinPeptide(Request $request)
    {
        $proteins = Protein::where('patient_id', $request->patient_id)
            ->where('visit_month', $request->visit_id)
            ->get();
        $peptides = Peptide::where('patient_id', $request->patient_id)
            ->where('visit_month', $request->visit_id)
            ->get();

        return view('website.doctor.patients.protein_peptide_list', compact('proteins', 'peptides'))->render();
    }


}
