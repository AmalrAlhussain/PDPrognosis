<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Peptide;
use App\Models\Protein;
use App\Models\Survey;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    public function dashboard()
    {
        $authUser = null;
        if (Auth::guard('admin')->check()) {
            $authUser = Auth::guard('admin')->user();
        } elseif (Auth::guard('doctor')->check()) {
            $authUser = Auth::guard('doctor')->user();
        } elseif (Auth::guard('patient')->check()) {
            $authUser = Auth::guard('patient')->user();
        }
        $doctorsCount = Doctor::count();
        $patientsCount = Patient::count();
        $visitsCount = Visit::count();
        $surveysCount = Survey::count();
        $latestPatients = Patient::orderBy('created_at', 'desc')->take(5)->get();
        $latestVisits = Visit::with('patient')->orderBy('visit_date', 'desc')->take(5)->get();
        $visitData = Visit::selectRaw('COUNT(id) as visit_count, patient_id')
            ->groupBy('patient_id')
            ->with('patient')
            ->get();
        $patients = $visitData->pluck('patient.id');
        $visitCounts = $visitData->pluck('visit_count');
        return view('website.admin.dashboard', compact(
            'authUser', 'doctorsCount', 'patientsCount', 'visitsCount', 'surveysCount', 'latestPatients', 'latestVisits', 'patients', 'visitCounts'
        ));
    }


    public
    function showLoginForm()
    {
        return view('website.admin.login');
    }

    // Handle Admin Login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Attempt login with username and password
        if (Auth::guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
            return redirect()->intended('admin/dashboard');
        }

        return back()->withInput()->withErrors(['username' => 'Email or password incorrect']);
    }

    // Show Admin Registration Form
    public
    function showRegisterForm()
    {
        return view('website.admin.register');
    }

    // Handle Admin Registration
    public
    function register(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:100|unique:admins',
            'email' => 'required|email|unique:admins',
            'password' => 'required|min:6|confirmed',
        ]);

        Admin::create([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.login')->with('success', 'Registration successful. Please login.');
    }

    // Show Update Profile Form
    public
    function showProfileForm()
    {
        return view('website.admin.update_profile', ['admin' => Auth::guard('admin')->user()]);
    }

    public function showProfile()
    {
        $admin = auth('admin')->user();
        return view('website.admin.profile', compact('admin'));
    }
    public function updateProfile(Request $request)
    {
        $admin = auth('admin')->user();

        // Validate form inputs
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:Admin,username,' . $admin->id,
            'email' => 'required|email|unique:Admin,email,' . $admin->id,
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Update admin's information
        $admin->update([
            'fullname' => $request->fullname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $admin->password,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    // Logout function
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('doctor')->logout();
        Auth::guard('patient')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function patientRequests()
    {
        // Fetch patients with status 'pending' to represent requests
        $patients = Patient::where('status', 0)->get();

        // Pass the patient requests to the view
        return view('website.admin.patient_requests', compact('patients'));
    }

    // Approve patient request
    public function approvePatient($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->status = 1;
        $patient->save();

        return redirect()->route('admin.patientRequests')->with('success', 'Patient request approved successfully.');
    }

    // Reject patient request
    public function rejectPatient($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->status = 0;
        $patient->save();

        return redirect()->route('admin.patientRequests')->with('error', 'Patient request rejected.');
    }


    public function doctorRequests()
    {
        // Fetch doctors with status 'pending' to represent requests
        $doctors = Doctor::where('status', 0)->get();

        // Pass the doctor requests to the view
        return view('website.admin.doctor_requests', compact('doctors'));
    }

    // Approve doctor request
    public function approveDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->status = 1;
        $doctor->save();

        return redirect()->route('admin.doctorRequests')->with('success', 'Doctor request approved successfully.');
    }

    // Reject doctor request
    public function rejectDoctor($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->status = 0;
        $doctor->save();

        return redirect()->route('admin.doctorRequests')->with('error', 'Doctor request rejected.');
    }

    public function acceptedDoctors()
    {
        $doctors = Doctor::where('status', 1)->get();
        return view('website.admin.accepted_doctors', compact('doctors'));
    }

    // Function to list accepted patients
    public function acceptedPatients()
    {
        $patients = Patient::where('status', 1)->get();
        return view('website.admin.accepted_patients', compact('patients'));
    }

    public function listVisits()
    {
        $visits =  Visit::with(['doctor', 'patient'])->limit(100)->get();
        return view('website.admin.visits_list', compact('visits'));
    }


    // View visit details
    public function viewVisit($id)
    {
        // Fetch visit details with related doctor, patient, test results, and surveys
        $visit = Visit::with(['doctor', 'patient', 'testResults', 'surveys'])->findOrFail($id);

        // Pass the visit details to the view
        return view('website.admin.visit_details', compact('visit'));
    }



    // Action to fetch protein info from UniProt API
    public function getProteinInfo(Request $request)
    {
        $uniprot_id = $request->input('uniprot_id');

        if ($uniprot_id) {
            $protein_info = $this->fetchProteinInfo($uniprot_id);

            if ($protein_info) {
                return view('website.admin.protein_info', ['protein_info' => $protein_info]);
            } else {
                return view('website.admin.protein_info', ['error' => 'Error fetching protein information from API']);
            }
        }

        return redirect()->back()->with('error', 'UniProt ID is required');
    }

    // Fetch protein information from UniProt API
    protected function fetchProteinInfo($uniprot_id)
    {
        $url = "https://www.uniprot.org/uniprot/{$uniprot_id}.txt";

        try {
            $response = Http::get($url);

            if ($response->successful()) {
                return $this->parseProteinInformation($response->body());
            }
        } catch (\Exception $e) {
            return null;
        }
    }

    // Parse the protein information from the response text
    protected function parseProteinInformation($protein_text)
    {
        $lines = explode("\n", $protein_text);
        $protein_info = [
            'ID' => '',
            'Accession' => '',
            'ProteinName' => '',
            'Organism' => '',
            'Function' => '',
            'DiseaseInvolvement' => '',
        ];
        $reading_function = false;
        $reading_disease = false;

        foreach ($lines as $line) {
            if (strpos($line, 'ID   ') === 0) {
                $protein_info['ID'] = explode(' ', trim($line))[3];
            } elseif (strpos($line, 'AC   ') === 0) {
                $protein_info['Accession'] = explode(' ', trim($line))[3];
            } elseif (strpos($line, 'RecName: Full=') !== false) {
                $protein_info['ProteinName'] = explode('Full=', $line)[1];
            } elseif (strpos($line, 'OS   ') === 0) {
                $protein_info['Organism'] = trim(substr($line, 5));
            } elseif (strpos($line, 'CC   -!- FUNCTION:') === 0) {
                $reading_function = true;
                $protein_info['Function'] = trim(substr($line, 19));
            } elseif ($reading_function && strpos($line, 'CC       ') === 0) {
                $protein_info['Function'] .= ' ' . trim($line);
            } elseif ($reading_function && strpos($line, 'CC   -!- ') === false) {
                $reading_function = false;
            } elseif (strpos($line, 'CC   -!- DISEASE:') === 0) {
                $reading_disease = true;
                $protein_info['DiseaseInvolvement'] = trim(substr($line, 19));
            } elseif ($reading_disease && strpos($line, 'CC       ') === 0) {
                $protein_info['DiseaseInvolvement'] .= ' ' . trim($line);
            } elseif ($reading_disease && strpos($line, 'CC   -!- ') === false) {
                $reading_disease = false;
            }
        }

        return $protein_info;
    }

    public function uploadFile(Request $request)
    {
        $data = $request->all();
        return view('website.admin.upload_file', compact('data'));
    }


    public function processUpload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $data = $request->only(['file_type', 'visit_id', 'patient_id']);
        $previewData = [];

        if ($file->isValid() && $file->getClientOriginalExtension() === 'csv') {
            // Open the file and parse using `fgetcsv`
            if (($handle = fopen($file->getPathname(), 'r')) !== false) {
                while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                    $previewData[] = $row;
                }
                fclose($handle);
            }
            return view('website.admin.preview_upload', compact('data', 'previewData'));
        }

        return back()->withErrors(['file' => 'Uploaded file is not valid or is not a CSV file.']);
    }

    public function confirmUpload(Request $request)
    {
        $fileData = json_decode($request->input('previewData'), true);
        $firstNames = [
            'محمد', 'عبدالله', 'علي', 'فهد', 'سعود', 'خالد', 'سلطان', 'يوسف', 'إبراهيم', 'ناصر',
            'عبدالعزيز', 'تركي', 'راشد', 'سلمان', 'عبدالرحمن', 'ماجد', 'فيصل', 'أحمد', 'حسن', 'سامي',
            'منصور', 'عبدالمجيد', 'زياد', 'عبدالملك', 'طارق', 'صالح', 'ثامر', 'وليد', 'حمود', 'ماهر',
            'جاسم', 'مبارك', 'عبدالإله', 'يحيى', 'صابر', 'رائد', 'مراد', 'حسين', 'عدنان', 'زياد', 'زيد',
            'حمد', 'أديب', 'بدر', 'فايز', 'عمر', 'سامر', 'غالب', 'أيمن', 'سعد', 'مرشد'
        ];
        $lastNames = [
            'العتيبي', 'الشهري', 'الزهراني', 'الحربي', 'المطيري', 'القحطاني', 'الغامدي', 'العنزي', 'الخالد', 'الفهيد',
            'الأنصاري', 'الشريف', 'البكري', 'السعدي', 'الصالح', 'السلمي', 'الجهني', 'الشيباني', 'الهذلي', 'العمري',
            'الرشيدي', 'العسيري', 'الحارثي', 'الدوسري', 'المالكي', 'المهدي', 'الحازمي', 'المشيخي', 'الفقيه', 'الجبيري',
            'الخالدي', 'الشمراني', 'المسعودي', 'الربيع', 'البدر', 'الشهواني', 'العجلان', 'الصويان', 'الغانم', 'المنصور',
            'الطويل', 'الحربي', 'العثمان', 'الحمود', 'القرني', 'النعيمي', 'الفارس', 'السويلم', 'المانع', 'الراضي'
        ];
        foreach ($fileData as $index => $row) {
            if ($index === 0) continue;
            if ($request->file_type == 'peptide') {
                list($visit_id, $visit_month, $patient_id, $UniProt, $Peptide, $PeptideAbundance) = $row;
            }
            if ($request->file_type == 'protein') {
                list($visit_id, $visit_month, $patient_id, $UniProt, $PeptideAbundance) = $row;
            }
            $patient = Patient::find($patient_id);
            if (!$patient) {
                $username = 'patient_' . $patient_id . '_' . rand(1000, 9999);
                $email = $patient_id . rand(1000, 9999) . '@patient.com';
                $patient = Patient::create([
                    'id' => $patient_id,
                    'fullname' => $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)],
                    'username' => $username,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'phone' => '05' . rand(100000000, 999999999),
                    'doctor_id' => rand(1, 6),
                ]);
            }

            $visit_date = Carbon::create(rand(2020, 2024), rand(1, 12), rand(1, 28))->toDateString();
            $visit = Visit::create(
                [
                    'visit_month' => $visit_month,
                    'patient_id' => $patient->id,
                    'visit_date' => $visit_date,
                    'doctor_id' => $patient->doctor_id,
                ]
            );
            if ($request->aSAsd == 'peptide') {
                Peptide::create([
                    'visit_id' => $visit->id,
                    'patient_id' => $patient->id,
                    'UniProt' => $UniProt,
                    'Peptide' => $Peptide,
                    'NPX' => $PeptideAbundance,
                    'visit_month' => $visit_month,
                ]);
            }
            if ($request->file_type == 'protein') {
                Protein::create([
                    'visit_id' => $visit->id,
                    'patient_id' => $patient->id,
                    'UniProt' => $UniProt,
                    'NPX' => $PeptideAbundance,
                    'visit_month' => $visit_month,
                ]);
            }
        }
        return redirect()->route('admin.visits')->with('success', 'Data uploaded successfully.');
    }

}
