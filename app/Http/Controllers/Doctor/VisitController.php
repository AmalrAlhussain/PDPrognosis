<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitController extends Controller
{
    // List all visits for the authenticated doctor
    public function index()
    {
        // Get all visits where the logged-in doctor (using doctor guard) is the owner
        $visits = Visit::where('doctor_id', Auth::guard('doctor')->id())->with(['doctor', 'patient'])->get();
        return view('website.doctor.visits.index', compact('visits'));
    }

    // Show form to create a visit, only list the doctor's assigned patients
    public function create()
    {
        // Get patients assigned to the logged-in doctor
        $patients = Patient::where('doctor_id', Auth::guard('doctor')->id())->get();
        return view('website.doctor.visits.create', compact('patients'));
    }

    // Store a new visit, automatically assigning the authenticated doctor's ID
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patient,id',
            'visit_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $patient = Patient::where('id', $request->patient_id)
            ->where('doctor_id', Auth::guard('doctor')->id())
            ->first();

        if (!$patient) {
            return redirect()->back()->withErrors(['patient_id' => 'This patient is not assigned to you.']);
        }

        Visit::create([
            'doctor_id' => Auth::guard('doctor')->id(), // Automatically assign the authenticated doctor
            'patient_id' => $request->patient_id,
            'visit_date' => $request->visit_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('doctor.visits.index')->with('success', 'Visit added successfully');
    }

    // Show a specific visit
    public function show(Visit $visit)
    {
        // Ensure the visit belongs to the authenticated doctor
        if ($visit->doctor_id !== Auth::guard('doctor')->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('website.doctor.visits.show', compact('visit'));
    }

    // Show form to edit a visit
    public function edit(Visit $visit)
    {
        // Ensure the visit belongs to the authenticated doctor
        if ($visit->doctor_id !== Auth::guard('doctor')->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Get the doctor's assigned patients
        $patients = Patient::where('doctor_id', Auth::guard('doctor')->id())->get();

        return view('website.doctor.visits.edit', compact('visit', 'patients'));
    }

    // Update a visit
    public function update(Request $request, Visit $visit)
    {
        // Ensure the visit belongs to the authenticated doctor
        if ($visit->doctor_id !== Auth::guard('doctor')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'visit_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Ensure that the selected patient belongs to the authenticated doctor
        $patient = Patient::where('id', $request->patient_id)
            ->where('doctor_id', Auth::guard('doctor')->id())
            ->first();

        if (!$patient) {
            return redirect()->back()->withErrors(['patient_id' => 'This patient is not assigned to you.']);
        }

        $visit->update([
            'patient_id' => $request->patient_id,
            'visit_date' => $request->visit_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('doctor.visits.index')->with('success', 'Visit updated successfully');
    }

    // Delete a visit
    public function destroy(Visit $visit)
    {
        // Ensure the visit belongs to the authenticated doctor
        if ($visit->doctor_id !== Auth::guard('doctor')->id()) {
            abort(403, 'Unauthorized action.');
        }

        $visit->delete();

        return redirect()->route('doctor.visits.index')->with('success', 'Visit deleted successfully');
    }
}
