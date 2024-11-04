<?php


use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OwnerController as AdminOwnerController;
use App\Http\Controllers\Doctor\DoctorAuthController;
use App\Http\Controllers\Doctor\VisitController;
use App\Http\Controllers\Owner\BatchController;
use App\Http\Controllers\Owner\DamageReportController;
use App\Http\Controllers\Owner\GeneralReportController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Owner\PalmTreeController;
use App\Http\Controllers\Patient\PatientAuthController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Route;

use App\Models\Patient;
use App\Models\Visit;
use App\Models\Peptide;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
Route::view('/', 'website.home')->name('home');
//Route::get('/', function () {
////    $filePath = public_path('dataset/train_peptides.csv');
//    $filePath = public_path('dataset/train_proteins.csv');
//    $csv = Reader::createFromPath($filePath, 'r');
//    $csv->setHeaderOffset(0); // If your CSV has headers
//    DB::beginTransaction();
//    try {
//        $visitCount = [];
//        foreach ($csv as $record) {
//            $visit_id = preg_replace('/_.*/', '', $record['visit_id']);
//            $patient_id = $record['patient_id'];
//            $visit_month = preg_replace('/_.*/', '', $record['visit_month']);
//            $UniProt = $record['UniProt'];
////            $Peptide = $record['Peptide'];
//            $NPX = $record['NPX'];
//
//            // If the patient has already reached 25 visits, skip further records
//            if (isset($visitCount[$patient_id]) && $visitCount[$patient_id] >= 25) {
//                continue;
//            }
//
//            // Increase the counter for the patient
//            if (!isset($visitCount[$patient_id])) {
//                $visitCount[$patient_id] = 0;
//            }
//            $visitCount[$patient_id]++;
//
//            // Sample Arabic names for generating patient details
//            $firstNames = [
//                'محمد', 'عبدالله', 'علي', 'فهد', 'سعود', 'خالد', 'سلطان', 'يوسف', 'إبراهيم', 'ناصر',
//                'عبدالعزيز', 'تركي', 'راشد', 'سلمان', 'عبدالرحمن', 'ماجد', 'فيصل', 'أحمد', 'حسن', 'سامي',
//                'منصور', 'عبدالمجيد', 'زياد', 'عبدالملك', 'طارق', 'صالح', 'ثامر', 'وليد', 'حمود', 'ماهر',
//                'جاسم', 'مبارك', 'عبدالإله', 'يحيى', 'صابر', 'رائد', 'مراد', 'حسين', 'عدنان', 'زياد', 'زيد',
//                'حمد', 'أديب', 'بدر', 'فايز', 'عمر', 'سامر', 'غالب', 'أيمن', 'سعد', 'مرشد'
//            ];
//            $lastNames = [
//                'العتيبي', 'الشهري', 'الزهراني', 'الحربي', 'المطيري', 'القحطاني', 'الغامدي', 'العنزي', 'الخالد', 'الفهيد',
//                'الأنصاري', 'الشريف', 'البكري', 'السعدي', 'الصالح', 'السلمي', 'الجهني', 'الشيباني', 'الهذلي', 'العمري',
//                'الرشيدي', 'العسيري', 'الحارثي', 'الدوسري', 'المالكي', 'المهدي', 'الحازمي', 'المشيخي', 'الفقيه', 'الجبيري',
//                'الخالدي', 'الشمراني', 'المسعودي', 'الربيع', 'البدر', 'الشهواني', 'العجلان', 'الصويان', 'الغانم', 'المنصور',
//                'الطويل', 'الحربي', 'العثمان', 'الحمود', 'القرني', 'النعيمي', 'الفارس', 'السويلم', 'المانع', 'الراضي'
//            ];
//
//            // Find or create the patient
//            $patient = Patient::find($patient_id);
//
//            if (!$patient) {
//                do {
//                    $username = 'patient_' . $patient_id . '_' . rand(1000, 9999);
//                } while (Patient::where('username', $username)->exists());
//                do {
//                    $email = $patient_id . rand(1000, 9999) . '@patient.com';
//                } while (Patient::where('email', $email)->exists());
//                $patient = Patient::create(
//                    [
//                        'id' => $patient_id,
//                        'fullname' => $firstNames[rand(0, 49)] . ' ' . $lastNames[rand(0, 49)], // Random Arabic name
//                        'username' => $username,  // Unique username
//                        'email' => $email,  // Unique email
//                        'password' => '$2y$10$S39XUMcyeQKyFqyg9DccqeP4Aql2xoCoBhwU7RKjHeyFDkh9Afxwe', // Predefined password
//                        'phone' => '05' . rand(100000000, 999999999),  // Generate KSA phone number
//                        'doctor_id' => rand(1, 6),  // Random doctor ID between 1 and 6
//                    ]
//                );
//            }
//
//            // Generate random visit date
//            $visit_date = Carbon::create(rand(2020, 2024), rand(1, 12), rand(1, 28))->toDateString();
//
//            // Check or create visit
//            $visit = Visit::firstOrCreate(
//                ['id' => $visit_id],
//                [
//                    'visit_month' => $visit_month,
//                    'patient_id' => $patient->id,
//                    'visit_date' => $visit_date,
//                    'doctor_id' => rand(1, 6),
//                ]
//            );
//
//            // Create or update peptide data
//            $d = \App\Models\Protein::create(
//                [
//                    'visit_id' => $visit->id,
//                    'patient_id' => $patient->id,
//                    'UniProt' => $UniProt,
//                    'visit_month' => $visit_month,
////                    'Peptide' => $Peptide,
//                    'NPX' => $NPX
//                ]
//            );
//        }
//
//        // Commit the transaction
//        DB::commit();
//
//    } catch (\Exception $e) {
//        // Rollback the transaction on error
//        DB::rollback();
//        dd($e->getMessage());
//    }
//})->name('home');
Route::view('admin', 'website.admin.start')->name('admin.start');
Route::view('doctor', 'website.doctor.start')->name('doctor.start');
Route::view('patient', 'website.patient.start')->name('patient.start');


Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AdminController::class, 'login'])->name('login.submit');
    Route::get('register', [AdminController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AdminController::class, 'register'])->name('register.submit');

    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [AdminController::class, 'logout'])->name('logout');
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('patient-requests', [AdminController::class, 'patientRequests'])->name('patientRequests');
        Route::post('patient/{id}/approve', [AdminController::class, 'approvePatient'])->name('patient.approve');
        Route::post('patient/{id}/reject', [AdminController::class, 'rejectPatient'])->name('patient.reject');

        Route::get('doctor-requests', [AdminController::class, 'doctorRequests'])->name('doctorRequests');
        Route::post('doctor/{id}/approve', [AdminController::class, 'approveDoctor'])->name('doctor.approve');
        Route::post('doctor/{id}/reject', [AdminController::class, 'rejectDoctor'])->name('doctor.reject');

        Route::get('accepted-doctors', [AdminController::class, 'acceptedDoctors'])->name('doctors');
        Route::get('accepted-patients', [AdminController::class, 'acceptedPatients'])->name('patients');

        Route::get('visits', [AdminController::class, 'listVisits'])->name('visits');
        Route::get('visit/{id}', [AdminController::class, 'viewVisit'])->name('visit.view');
        Route::get('surveys', [AdminController::class, 'surveys'])->name('surveys');
        Route::get('profile', [AdminController::class, 'showProfile'])->name('profile');
        Route::post('profile/update', [AdminController::class, 'updateProfile'])->name('profile.update');

        Route::post('patient/protein-info', [AdminController::class, 'getProteinInfo'])->name('proteinInfo');
        Route::get('visit_upload/file', [AdminController::class, 'uploadFile'])->name('uploadFile');
        Route::any('visit_upload/process_upload', [AdminController::class, 'processUpload'])->name('visit.process_upload');
        Route::post('visit_upload/confirm_upload', [AdminController::class, 'confirmUpload'])->name('visit.confirm_upload');

    });
});


// Doctor routes
Route::prefix('doctor')->name('doctor.')->group(function () {
    Route::get('login', 'App\Http\Controllers\Doctor\DoctorAuthController@showLoginForm')->name('login');
    Route::post('login', 'App\Http\Controllers\Doctor\DoctorAuthController@login');

    Route::get('register', 'App\Http\Controllers\Doctor\DoctorAuthController@showRegisterForm')->name('register');
    Route::post('register', 'App\Http\Controllers\Doctor\DoctorAuthController@register');
    Route::middleware('auth:doctor')->group(function () {
        Route::post('logout', [DoctorAuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [DoctorAuthController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [DoctorAuthController::class, 'profile'])->name('profile');
        Route::post('profile', [DoctorAuthController::class, 'updateProfile'])->name('profile.update');
        Route::post('logout', [DoctorAuthController::class, 'logout'])->name('logout');
        Route::get('my-patients', [DoctorAuthController::class, 'myPatients'])->name('my-patients');
        Route::get('my-patients/{id}', [DoctorAuthController::class, 'showPatient'])->name('patients.show');
        Route::post('patient/protein-info', [AdminController::class, 'getProteinInfo'])->name('proteinInfo');
        Route::resource('visits', VisitController::class);
        Route::get('surveys/select-part', [App\Http\Controllers\Doctor\SurveyController::class, 'selectPart'])->name('surveys.selectPart');
        Route::get('surveys/create', [App\Http\Controllers\Doctor\SurveyController::class, 'create'])->name('surveys.create');
        Route::post('surveys', [App\Http\Controllers\Doctor\SurveyController::class, 'store'])->name('surveys.store');
        Route::get('surveys/{survey_id}', [App\Http\Controllers\Doctor\SurveyController::class, 'show'])->name('surveys.show');


        Route::get('my-patients/{patient_id}/proteins', [DoctorAuthController::class, 'listProteins'])->name('patients.proteins');
        Route::get('my-patients/{patient_id}/peptides', [DoctorAuthController::class, 'listPeptides'])->name('patients.peptides');
        Route::get('my-patients/{patient_id}/details', [DoctorAuthController::class, 'showDetails'])->name('patients.showDetails');
        Route::get('fetch-protein-peptide', [DoctorAuthController::class, 'fetchProteinPeptide'])->name('fetch.protein.peptide');

    });

});


// Patient routes
Route::prefix('patient')->name('patient.')->group(function () {

    Route::get('login',  [PatientAuthController::class, 'showLoginForm'])->name('login');

    Route::post('login', [PatientAuthController::class, 'login'])->name('login');

    Route::get('register', [PatientAuthController::class, 'showRegisterForm'])->name('register');

    Route::post('register', [PatientAuthController::class, 'register'])->name('register');

    Route::middleware('auth:patient')->group(function () {
        Route::get('dashboard', [PatientAuthController::class, 'dashboard'])->name('dashboard');
        Route::get('profile', [PatientAuthController::class, 'profile'])->name('profile');
        Route::post('profile/update', [PatientAuthController::class, 'updateProfile'])->name('profile.update');
        Route::post('logout', [PatientAuthController::class, 'logout'])->name('logout');
        Route::get('my-visits', [PatientAuthController::class, 'getMyVisits'])->name('my-visits');

        Route::get('surveys/select-part', [PatientAuthController::class, 'selectPart'])->name('surveys.selectPart');
        Route::get('surveys/create', [PatientAuthController::class, 'create'])->name('surveys.create');
        Route::post('surveys', [PatientAuthController::class, 'store'])->name('surveys.store');
        Route::get('surveys/{survey_id}', [PatientAuthController::class, 'show'])->name('surveys.show');
    });
});
