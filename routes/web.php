<?php

use App\Http\Controllers\PhysicianController;
use App\Http\Controllers\DiagnosingFacilityController;
use App\Http\Controllers\Api\MedicationAdherenceController;
use App\Http\Controllers\AdherenceController;
use App\Http\Controllers\SputumMonitoringController;
use App\Http\Controllers\CloseContactController;
use App\Http\Controllers\PatientProgressController;
use App\Http\Controllers\AdverseEventController;
use App\Http\Controllers\DiagnosisController;
use App\Http\Controllers\LaboratoryTestController;
use App\Http\Controllers\PrescribedDrugsController;
use App\Http\Controllers\TreatmentOutcomeController;
use App\Http\Controllers\HivController;
use App\Http\Controllers\ComorbidityController;
use App\Http\Controllers\TreatmentHistoryController;
use App\Http\Controllers\PostTreatmentFollowUpController;
use App\Http\Controllers\ChestXrayController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientSummaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportGenerationController;
use App\Models\Patient;
use Illuminate\Support\Facades\Route;




Route::get('/dashboard', function () {
    return view('/dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/', function () {
    return view ('auth.login');
});


// Admin
Route::get('admin/dashboard', [AdminController::class,'index'])->middleware(['auth'])->name('admin.index');
Route::get('patient', [AdminController::class, 'patient'])->middleware(['auth'])->name('admin.patient');
Route::get('patient-profile/{id}', [AdminController::class, 'patientProfile'])
    ->middleware(['auth'])
    ->name('admin.patientProfile');

Route::get('form/page1', [AdminController::class, 'page1'])->middleware(['auth']);
Route::post('submitpage1', [AdminController::class, 'submitpage1'])->middleware(['auth']);
Route::get('form/page2', [AdminController::class, 'page2'])->middleware(['auth']);
Route::post('submitpage2', [AdminController::class, 'submitpage2'])->middleware(['auth']);
Route::get('form/page3', [AdminController::class, 'page3'])->middleware(['auth']);
Route::post('submitpage3', [AdminController::class, 'submitpage3'])->middleware(['auth']);
Route::get('reports', [AdminController::class, 'reports'])->middleware(['auth']);
Route::get('error', [AdminController::class, 'error'])->middleware(['auth']);

Route::delete('/patients/{id}', [AdminController::class, 'destroy'])->name('patients.destroy');
Route::get('/patients/edit/{id}', [AdminController::class, 'edit'])->name('patients.edit');
Route::put('/patients/update/{id}', [AdminController::class, 'update'])->name('patients.update');
Route::get('/admin/patient-profile/{id}', [AdminController::class, 'patientProfile'])->name('admin.patientProfile');

Route::get('create-patient-account/{patient}', [PatientController::class, 'createAccount'])->middleware(['auth'])->name('patient.account');
Route::post('/patient/register', [PatientController::class, 'store'])->name('patient.register');
Route::get('patient-accounts', [PatientController::class, 'patientAccount'])->middleware(['auth']);

// Home
Route::get('notification', [AdminController::class, 'notification'])->middleware(['auth']);

// Reports
Route::get('/chart/monthly-patients', [PatientController::class, 'monthlyPatients']);

Route::get('newly-diagnosed', [ReportGenerationController::class, 'newlyDiagnosed'])->middleware(['auth']);
Route::get('relapse', [ReportGenerationController::class, 'relapse'])->middleware(['auth']);
Route::get('bacteriologically-confirmed', [ReportGenerationController::class, 'bacteriologicallyConfirmed'])->middleware(['auth'])->name('reports.bacteriologically-confirmed');
Route::get('clinically-diagnosed', [ReportGenerationController::class, 'clinicallyDiagnosed'])->middleware(['auth'])->name('reports.clinically-diagnosed');
Route::get('pulmonary', [ReportGenerationController::class, 'pulmonary'])->middleware(['auth']);
Route::get('extra-pulmonary', [ReportGenerationController::class, 'extraPulmonary'])->middleware(['auth']);
Route::get('ongoing-treatment', [ReportGenerationController::class, 'ongoingTreatment'])->middleware(['auth']);
Route::get('barangay-cases', [ReportGenerationController::class, 'barangayCases'])->middleware(['auth']);
Route::get('intensive-treatment', [ReportGenerationController::class, 'intensiveTreatment'])->middleware(['auth']);
Route::get('maintenance-treatment', [ReportGenerationController::class, 'maintenanceTreatment'])->middleware(['auth']);
Route::get('underage', [ReportGenerationController::class, 'underage'])->middleware(['auth']);
Route::get('sputum-monitoring', [ReportGenerationController::class, 'sputumMonitoring'])->middleware(['auth']);
Route::get('cured', [ReportGenerationController::class, 'cured'])->middleware(['auth']);
Route::get('treatment-completed', [ReportGenerationController::class, 'treatmentCompleted'])->middleware(['auth']);
Route::get('lost-to-follow-up', [ReportGenerationController::class, 'lostToFollowUp'])->middleware(['auth']);
Route::get('expired', [ReportGenerationController::class, 'expired'])->middleware(['auth']);
Route::get('barangay-cases-notification', [ReportGenerationController::class, 'brgyCasesNotification'])->middleware(['auth']);
Route::get('quarterly-cases-notification', [ReportGenerationController::class, 'quarterlyCasesNotification'])->middleware(['auth']);
Route::get('quarterly-tb-classification', [ReportGenerationController::class, 'quarterlyTBClassification'])->middleware(['auth']);
Route::get('quarterly-anatomical-site', [ReportGenerationController::class, 'quarterlyAnatomicalSite'])->middleware(['auth']);
Route::get('quarterly-treatment-outcome', [ReportGenerationController::class, 'quarterlyTreatmentOutcome'])->middleware(['auth']);


// PDF
Route::get('patient-summary', [PatientSummaryController::class, 'patientSummary']);
Route::get('/patients/{id}/summary', [PatientSummaryController::class, 'patientSummary'])->name('patient.summary');

Route::get('/pdf/newly-diagnosed/pdf', [PatientSummaryController::class, 'newlyDiagnosedPDF'])->name('pdf.newly-diagnosed.pdf');
Route::get('/pdf/relapse/pdf', [PatientSummaryController::class, 'relapsePDF'])->name('pdf.relapse.pdf');
Route::get('/pdf/bacteriologically-confirmed/pdf', [PatientSummaryController::class, 'bacteriologicallyConfirmedPDF'])->name('pdf.bacteriologically-confirmed.pdf');
Route::get('/pdf/clinically-diagnosed/pdf', [PatientSummaryController::class, 'clinicallyDiagnosedPDF'])->name('pdf.clinically-diagnosed.pdf');
Route::get('/pdf/pulmonary/pdf', [PatientSummaryController::class, 'pulmonaryPDF'])->name('pdf.pulmonary.pdf');
Route::get('/pdf/extra-pulmonary/pdf', [PatientSummaryController::class, 'extraPulmonaryPDF'])->name('pdf.extra-pulmonary.pdf');
Route::get('/pdf/ongoing-treatment/pdf', [PatientSummaryController::class, 'ongoingTreatmentPDF'])->name('pdf.ongoing-treatment.pdf');
Route::get('/pdf/barangay-cases/pdf', [PatientSummaryController::class, 'barangayCasesPDF'])->name('pdf.barangay-cases.pdf');
Route::get('/pdf/intensive-treatment/pdf', [PatientSummaryController::class, 'intensiveTreatmentPDF'])->name('pdf.intensive-treatment.pdf');
Route::get('/pdf/maintenance-treatment/pdf', [PatientSummaryController::class, 'maintenanceTreatmentPDF'])->name('pdf.maintenance-treatment.pdf');
Route::get('/pdf/underage/pdf', [PatientSummaryController::class, 'underagePDF'])->name('pdf.underage.pdf');
Route::get('/pdf/sputum-monitoring/pdf', [PatientSummaryController::class, 'sputumMonitoringPDF'])->name('pdf.sputum-monitoring.pdf');
Route::get('/pdf/cured/pdf', [PatientSummaryController::class, 'curedPDF'])->name('pdf.cured.pdf');
Route::get('/pdf/treatment-completed/pdf', [PatientSummaryController::class, 'treatmentCompletedPDF'])->name('pdf.treatment-completed.pdf');
Route::get('/pdf/lost-to-follow-up/pdf', [PatientSummaryController::class, 'lostToFollowUpPDF'])->name('pdf.lost-to-follow-up.pdf');
Route::get('/pdf/expired/pdf', [PatientSummaryController::class, 'expiredPDF'])->name('pdf.expired.pdf');
Route::get('/pdf/barangay-cases-notification/pdf', [PatientSummaryController::class, 'brgyCasesNotificationPDF'])->name('pdf.barangay-cases-notification.pdf');
Route::get('/pdf/quarterly-cases-notification/pdf', [PatientSummaryController::class, 'quarterlyCasesNotificationPDF'])->name('pdf.quarterly-cases-notification.pdf');
Route::get('/pdf/quarterly-tb-classification/pdf', [PatientSummaryController::class, 'quarterlyTBClassificationPDF'])->name('pdf.quarterly-tb-classification.pdf');
Route::get('/pdf/quarterly-anatomical-site/pdf', [PatientSummaryController::class, 'quarterlyAnatomicalSitePDF'])->name('pdf.quarterly-anatomical-site.pdf');
Route::get('/pdf/quarterly-treatment-outcome/pdf', [PatientSummaryController::class, 'quarterlyTreatmentOutcomePDF'])->name('pdf.quarterly-treatment-outcome.pdf');

// Validate
Route::post('validatePage1', [PatientController::class, 'validatePage1'])->middleware(['auth']);
Route::post('validatePage2', [PatientController::class, 'validatePage2'])->middleware(['auth']);
Route::post('validatePage3', [PatientController::class, 'validatePage3'])->middleware(['auth']);







// Follow Up
Route::post('/patients/{id}/adverse-events', [AdverseEventController::class, 'store'])->name('adverse.store');
Route::post('/patients/{id}/progress', [PatientProgressController::class, 'store'])->name('patient-progress.store');
Route::post('/patients/{id}/close-contact', [CloseContactController::class, 'store'])->name('close-contact.store');
Route::post('/patients/{id}/sputum', [SputumMonitoringController::class, 'store'])->name('sputum.store');
Route::post('/patients/{id}/chest-xray', [ChestXrayController::class, 'store'])->name('chest-xray.store');
Route::post('/patients/{id}/post-treatment-follow-up', [PostTreatmentFollowUpController::class, 'store'])->name('post-treatment-follow-up.store');
Route::post('/patients/{id}/treatment-history', [TreatmentHistoryController::class, 'store'])->name('treatment-history.store');
Route::post('/patients/{id}/comorbidities', [ComorbidityController::class, 'store'])->name('comorbidities.store');
Route::post('/patients/{id}/hiv', [HivController::class, 'store'])->name('hiv.store');
// Route::post('/patients/{id}/treatment-outcome', [TreatmentOutcomeController::class, 'store'])->name('treatment-outcome.store');
Route::post('/patients/{id}/prescribed-drugs', [PrescribedDrugsController::class, 'store'])->name('prescribed-drugs.store');

Route::post('/patients/{id}/laboratory-tests', [LaboratoryTestController::class, 'store'])->name('laboratory-tests.store');
Route::put('/laboratory-tests/{id}', [LaboratoryTestController::class, 'update'])->name('laboratory-tests.update');

Route::put('/referrals/{id}', [DiagnosisController::class, 'update'])->name('referrals.update');

Route::put('/patients/adherence/{id}', [AdherenceController::class, 'update'])->name('adherence.update');

Route::post('/patients/{id}/treatment-outcome', [TreatmentOutcomeController::class, 'store'])
    ->name('treatment-outcome.store');

// Update route (for editing)
Route::put('/treatment-outcome/{id}', [TreatmentOutcomeController::class, 'update'])
    ->name('treatment-outcome.update');

Route::get('/diagnosing-facility/default', [DiagnosingFacilityController::class, 'getDefault']);

// Physician
Route::get('physician', [PhysicianController::class, 'index'])->middleware(['auth'])->name('admin.physician');
Route::post('/physician/store', [PhysicianController::class, 'store'])->name('physician.store');
Route::put('/physician/{id}', [PhysicianController::class, 'update'])->name('physician.update');
Route::delete('/physician/{id}', [PhysicianController::class, 'destroy'])->name('physician.destroy');

// Facility
Route::get('facilities', [DiagnosingFacilityController::class,'index'])->middleware(['auth'])->name('facility.facilities');
Route::post('/facilities/store', [DiagnosingFacilityController::class, 'store'])->name('facilities.store');
Route::put('/facilities/edit/{id}', [DiagnosingFacilityController::class, 'update'])->name('facilities.update');
Route::delete('/facilities/{id}', [DiagnosingFacilityController::class, 'destroy'])->name('facilities.destroy');

// Medication
Route::get('medication-adherence-flags', [MedicationAdherenceController::class,'index'])->middleware(['auth'])->name('medication.index');

