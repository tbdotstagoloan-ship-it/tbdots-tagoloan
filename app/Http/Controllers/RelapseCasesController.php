<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Diagnosis;
use App\Models\DiagnosingFacility;
use App\Models\Screening;
use App\Models\LaboratoryTest;
use App\Models\TBClassification;
use App\Models\TreatmentFacility;
use App\Models\TreatmentHistory;
use App\Models\HIVInfo;
use App\Models\BaselineInfo;
use App\Models\TreatmentRegimen;
use App\Models\TreatmentOutcome;
use App\Models\Comorbidity;
use App\Models\PrescribedDrug;
use App\Models\TxSupporter;
use App\Models\Adherence;
use App\Models\AdverseEvent;
use App\Models\Progress;
use App\Models\CloseContact;
use App\Models\SputumMonitoring;
use App\Models\ChestXray;
use App\Models\PostTreatmentFollowUp;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RelapseCasesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view ('relapse.index');
    }

    

    public function relapseFormPage1($id)
    {
        $patient = Patient::with('diagnosingFacility', 'latestScreening')->findOrFail($id);

        $latestCase = Diagnosis::orderBy('id', 'desc')->first();
        $nextId = $latestCase ? $latestCase->id + 1 : 1;
        $tbCaseNo = 'TB-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('relapse.relapse-form-page1', compact('tbCaseNo', 'patient'));
    }

    public function validateRelapsePage1(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $facility = $patient->diagnosingFacility;

        // Validate all sections at once
        $validated = $request->validate([

            // Screening Information (Required)
            'scr_referred_by' => 'required|string',
            'scr_location' => 'required|string',
            'scr_referrer_type' => 'required|string',
            'scr_screening_mode' => 'required|string',
            'scr_screening_date' => 'required|date',

            // Laboratory Tests (Required)
            'lab_xpert_test_date' => 'required|date',
            'lab_xpert_result' => 'required|string',
            'lab_cxray_test_date' => 'required|date',
            'lab_cxray_result' => 'required|string',

             // Laboratory Tests (Optional)
            'lab_smear_test_date' => 'nullable|date',
            'lab_smear_result' => 'nullable|string',
            'lab_tst_test_date' => 'nullable|date',
            'lab_tst_result' => 'nullable|string',
            'lab_other_test_name' => 'nullable|string',
            'lab_other_result' => 'nullable|string',
            'lab_other_test_date' => 'nullable|date',

            // Diagnosis (Required)
            'diag_diagnosis_date' => 'required|date',
            'diag_notification_date' => 'required|date',
            'diag_attending_physician' => 'required|string',

            // TB Classification (Required)
            'clas_bacteriological_status' => 'required|string',
            'clas_drug_resistance_status' => 'required|string',
            'clas_anatomical_site' => 'required|string',
            
            // TB Classification (Optional)
            'clas_other_drug_resistant' => 'nullable|string',
            'clas_site_other' => 'nullable|string',
        ]);

        // Screening Information
        Screening::create([
            'patient_id' => $patient->id,
            'scr_referred_by' => $validated['scr_referred_by'],
            'scr_location' => $validated['scr_location'],
            'scr_referrer_type' => $validated['scr_referrer_type'],
            'scr_screening_mode' => $validated['scr_screening_mode'],
            'scr_screening_date' => $validated['scr_screening_date'],
        ]);

        // 1️⃣ Laboratory Tests
        LaboratoryTest::create([
            'patient_id' => $patient->id,
            'diagfacility_id' => $facility->id,
            'lab_xpert_test_date' => $validated['lab_xpert_test_date'],
            'lab_xpert_result' => $validated['lab_xpert_result'],
            'lab_cxray_test_date' => $validated['lab_cxray_test_date'],
            'lab_cxray_result' => $validated['lab_cxray_result'],
            'lab_smear_test_date' => $validated['lab_smear_test_date'] ?? null,
            'lab_smear_result' => $validated['lab_smear_result'] ?? null,
            'lab_tst_test_date' => $validated['lab_tst_test_date'] ?? null,
            'lab_tst_result' => $validated['lab_tst_result'] ?? null,
            'lab_other_test_name' => $validated['lab_other_test_name'] ?? null,
            'lab_other_result' => $validated['lab_other_result'] ?? null,
            'lab_other_test_date' => $validated['lab_other_test_date'] ?? null,
        ]);

        // 2️⃣ Diagnosis
        $latestNumber = Diagnosis::max('id');
        $nextId = $latestNumber ? $latestNumber + 1 : 1;
        $tbCaseNo = 'TB-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        Diagnosis::create([
            'patient_id' => $patient->id,
            'diagfacility_id' => $facility->id,
            'diag_diagnosis_date' => $validated['diag_diagnosis_date'],
            'diag_notification_date' => $validated['diag_notification_date'],
            'diag_tb_case_no' => $tbCaseNo,
            'diag_attending_physician' => $validated['diag_attending_physician'],
        ]);

        // 3️⃣ TB Classification
        TBClassification::create([
            'patient_id' => $patient->id,
            'clas_bacteriological_status' => $validated['clas_bacteriological_status'],
            'clas_drug_resistance_status' => $validated['clas_drug_resistance_status'],
            'clas_other_drug_resistant' => $validated['clas_other_drug_resistant'] ?? null,
            'clas_anatomical_site' => $validated['clas_anatomical_site'],
            'clas_site_other' => $validated['clas_site_other'] ?? null,
            'clas_registration_group' => 'Relapse', // Hardcoded since it's always "Relapse"
        ]);

        // Redirect to Page 2
        return redirect()->route('relapse.page2', $patient->id)
                         ->with('success', 'Page 1 submitted successfully.');
    }

    public function relapseFormPage2($id)
    {
        $patient = Patient::with([
            'diagnosingFacility', 
            'latestScreening',
            'latestTreatmentFacility',
            'latestBaselineInfo'
        ])->findOrFail($id);

        return view('relapse.relapse-form-page2', compact('patient'));
    }

    public function validateRelapsePage2(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);
        $treatmentFacility = $patient->latestTreatmentFacility;

        // Validate all required fields
        $validated = $request->validate([
            // History of TB Treatment (Optional)
            'hist_date_tx_started' => 'nullable|date',
            'hist_treatment_unit' => 'nullable|string|max:255',
            'hist_drug' => 'nullable|string|max:255',
            'hist_treatment_duration' => 'nullable|string|max:255',
            'hist_outcome' => 'nullable|string',

            // HIV Information (Optional)
            'hiv_information' => 'nullable|string',
            'hiv_test_date' => 'nullable|date',
            'hiv_confirmatory_test_date' => 'nullable|date',
            'hiv_result' => 'nullable|string',
            'hiv_art_started' => 'nullable|string',
            'hiv_cpt_started' => 'nullable|string',

            // Baseline Information (Required)
            'base_height' => 'required|numeric',
            'base_weight' => 'required|numeric',
            'base_blood_pressure' => 'required|string|max:20',
            'base_pulse_rate' => 'required|string|max:20',
            'base_temperature' => 'required|string|max:20',
            'base_diabetes_screening' => 'required|string',
            'base_four_ps_beneficiary' => 'required|string',
            'base_fbs_screening' => 'nullable|string',
            'base_date_tested' => 'nullable|date',

            // Co-morbidities (Optional)
            'com_date_diagnosed' => 'nullable|date',
            'com_type' => 'nullable|string',
            'com_other' => 'nullable|string|max:255',
            'com_treatment' => 'nullable|string|max:255',

            // Treatment Regimen (Required)
            'reg_start_type' => 'required|string',
            'reg_start_date' => 'required|date',
            'reg_end_type' => 'nullable|string',

            // Prescribed Drugs (Required)
            'drug_start_date' => 'required|date',
            'drug_name' => 'required|string',
            'drug_no_of_tablets' => 'required|string',
            'drug_strength' => 'required|string',
            'drug_unit' => 'required|string',

            // Administration of Drugs (Required)
            'sup_location' => 'required|string',
            'sup_name' => 'required|string|max:255',
            'sup_designation' => 'required|string',
            'sup_type' => 'required|string',
            'sup_contact_info' => 'required|string|size:11',
            'sup_treatment_schedule' => 'nullable|string',
            'sup_dat_used' => 'nullable|string|max:255',
            'pha_intensive_start' => 'nullable|date',
            'pha_intensive_end' => 'nullable|date',
        ]);

        // 1️⃣ History of TB Treatment (only if data exists)
        if ($validated['hist_date_tx_started'] || $validated['hist_treatment_unit']) {
            TreatmentHistory::create([
                'patient_id' => $patient->id,
                'hist_date_tx_started' => $validated['hist_date_tx_started'] ?? null,
                'hist_treatment_unit' => $validated['hist_treatment_unit'] ?? null,
                'hist_drug' => $validated['hist_drug'] ?? null,
                'hist_treatment_duration' => $validated['hist_treatment_duration'] ?? null,
                'hist_outcome' => $validated['hist_outcome'] ?? null,
            ]);
        }

        // 2️⃣ HIV Information (only if data exists)
        if ($request->filled('hiv_information') || $request->filled('hiv_test_date')) {
            HIVInfo::create([
                'patient_id' => $patient->id,
                'hiv_information' => $request->input('hiv_information'),
                'hiv_test_date' => $request->input('hiv_test_date'),
                'hiv_confirmatory_test_date' => $request->input('hiv_confirmatory_test_date'),
                'hiv_result' => $request->input('hiv_result'),
                'hiv_art_started' => $request->input('hiv_art_started'),
                'hiv_cpt_started' => $request->input('hiv_cpt_started'),
            ]);
        }


        // 3️⃣ Baseline Information
        BaselineInfo::create([
            'patient_id' => $patient->id,
            'base_height' => $validated['base_height'],
            'base_weight' => $validated['base_weight'],
            'base_blood_pressure' => $validated['base_blood_pressure'],
            'base_pulse_rate' => $validated['base_pulse_rate'],
            'base_temperature' => $validated['base_temperature'],
            'base_diabetes_screening' => $validated['base_diabetes_screening'],
            'base_four_ps_beneficiary' => $validated['base_four_ps_beneficiary'],
            'base_fbs_screening' => $validated['base_fbs_screening'] ?? null,
            'base_date_tested' => $validated['base_date_tested'] ?? null,
            // Get from previous baseline info (readonly fields)
            'base_emergency_contact_name' => $patient->latestBaselineInfo->base_emergency_contact_name ?? null,
            'base_relationship' => $patient->latestBaselineInfo->base_relationship ?? null,
            'base_contact_info' => $patient->latestBaselineInfo->base_contact_info ?? null,
            'base_occupation' => $patient->latestBaselineInfo->base_occupation ?? null,
        ]);

        // 5️⃣ Comorbidities (optional)
        if ($request->filled('com_type') || $request->filled('com_date_diagnosed')) {
            Comorbidity::create([
                'patient_id' => $patient->id,
                'com_date_diagnosed' => $request->input('com_date_diagnosed'),
                'com_type' => $request->input('com_type'),
                'com_other' => $request->input('com_other'),
                'com_treatment' => $request->input('com_treatment'),
            ]);
        }

        // 6️⃣ Treatment Regimen (required)
        $request->validate([
            'reg_start_type' => 'required',
            'reg_start_date' => 'required',
        ]);

        TreatmentRegimen::create([
            'patient_id' => $patient->id,
            'reg_start_type' => $request->input('reg_start_type'),
            'reg_start_date' => $request->input('reg_start_date'),
            'reg_end_type' => $request->input('reg_end_type'),
        ]);

        // 6️⃣ Prescribed Drugs
        PrescribedDrug::create([
            'patient_id' => $patient->id,
            'drug_start_date' => $validated['drug_start_date'],
            'drug_name' => $validated['drug_name'],
            'drug_no_of_tablets' => $validated['drug_no_of_tablets'],
            'drug_strength' => $validated['drug_strength'],
            'drug_unit' => $validated['drug_unit'],
        ]);

        // 7️⃣ Treatment Supporter
        TxSupporter::create([
            'patient_id' => $patient->id,
            'sup_location' => $validated['sup_location'],
            'sup_name' => $validated['sup_name'],
            'sup_designation' => $validated['sup_designation'],
            'sup_type' => $validated['sup_type'],
            'sup_contact_info' => $validated['sup_contact_info'],
            'sup_treatment_schedule' => $validated['sup_treatment_schedule'] ?? 'Daily',
            'sup_dat_used' => $validated['sup_dat_used'] ?? null,
        ]);

        // 8️⃣ Treatment Phase (Intensive Phase dates)
        if ($validated['pha_intensive_start'] && $validated['pha_intensive_end']) {
            Adherence::create([
                'patient_id' => $patient->id,
                'pha_intensive_start' => $validated['pha_intensive_start'],
                'pha_intensive_end' => $validated['pha_intensive_end'],
            ]);
        }

        // Redirect to success page or patient list
        return redirect()->route('relapse.page3', $patient->id)
                        ->with('success', 'Page 2 submitted successfully.');
    }


    public function relapseFormPage3($id)
    {
        $patient = Patient::findOrFail($id);
        return view('relapse.relapse-form-page3', compact('patient'));
    }

    public function validateRelapsePage3(Request $request, $id)
    {
        $patient = Patient::findOrFail($id);

        // ✅ Validate all fields
        $validated = $request->validate([
            // Adverse Events (Optional)
            'adv_ae_date' => 'nullable|date',
            'adv_specific_ae' => 'nullable|string|max:255',
            'adv_fda_reported_date' => 'nullable|date',

            // Close Contacts (Multiple entries - Optional)
            'con_name' => 'nullable|array',
            'con_name.*' => 'nullable|string|max:255',
            'con_age' => 'nullable|array',
            'con_age.*' => 'nullable|integer|min:0|max:120',
            'con_sex' => 'nullable|array',
            'con_sex.*' => 'nullable|string',
            'con_relationship' => 'nullable|array',
            'con_relationship.*' => 'nullable|string',
            'con_initial_screening' => 'nullable|array',
            'con_initial_screening.*' => 'nullable|date',
            'con_follow_up' => 'nullable|array',
            'con_follow_up.*' => 'nullable|date',
            'con_remarks' => 'nullable|array',
            'con_remarks.*' => 'nullable|string|max:255',
        ]);

        // 1️⃣ Adverse Events (only if data exists)
        if ($validated['adv_ae_date'] || $validated['adv_specific_ae']) {
            AdverseEvent::create([
                'patient_id' => $patient->id,
                'adv_ae_date' => $validated['adv_ae_date'] ?? null,
                'adv_specific_ae' => $validated['adv_specific_ae'] ?? null,
                'adv_fda_reported_date' => $validated['adv_fda_reported_date'] ?? null,
            ]);
        }

        // 2️⃣ Close Contacts (Multiple entries)
        if ($request->has('con_name') && is_array($request->con_name)) {
            foreach ($request->con_name as $index => $name) {
                // Skip completely empty entries
                if (empty($name) && 
                    empty($request->con_age[$index] ?? null) && 
                    empty($request->con_sex[$index] ?? null) &&
                    empty($request->con_relationship[$index] ?? null)) {
                    continue;
                }

                CloseContact::create([
                    'patient_id' => $patient->id,
                    'con_name' => $name ?? null,
                    'con_age' => $request->con_age[$index] ?? null,
                    'con_sex' => $request->con_sex[$index] ?? null,
                    'con_relationship' => $request->con_relationship[$index] ?? null,
                    'con_initial_screening' => $request->con_initial_screening[$index] ?? null,
                    'con_follow_up' => $request->con_follow_up[$index] ?? null,
                    'con_remarks' => $request->con_remarks[$index] ?? null,
                ]);
            }
        }

        // 3️⃣ Create Treatment Outcome with "Ongoing" status for new relapse case
        TreatmentOutcome::create([
            'patient_id' => $patient->id,
            'out_outcome' => 'Ongoing',
            'out_date' => null, // Will be filled when treatment is completed
            'out_reason' => null,
        ]);

        // ✅ Redirect to patient list with success message
        return redirect()->route('admin.patient', $patient->id)
                        ->with('success', 'Relapse case registered successfully!');
    }

    
}
