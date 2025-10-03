<?php

namespace App\Http\Controllers;
use App\Models\Notification;
use App\Models\Adherence;
use App\Models\Admin;
use App\Models\AdverseEvent;
use App\Models\BaselineInfo;
use App\Models\ChestXray;
use App\Models\CloseContact;
use App\Models\Comorbidity;
use App\Models\Diagnosis;
use App\Models\HIVInfo;
use App\Models\LaboratoryTest;
use App\Models\PostTreatmentFollowUp;
use App\Models\PrescribedDrug;
use App\Models\Progress;
use App\Models\Screening;
use App\Models\Patient;
use App\Models\DiagnosingFacility;
use App\Models\SputumMonitoring;
use App\Models\TBClassification;
use App\Models\TreatmentFacility;
use App\Models\TreatmentHistory;
use App\Models\TreatmentOutcome;
use App\Models\TreatmentRegimen;
use App\Models\TxSupporter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
        public function monthlyPatients() 
        { 
            $patients = DB::table('tbl_diagnosis')
                ->selectRaw('MONTH(diag_diagnosis_date) as month, COUNT(*) as total')
                ->whereYear('diag_diagnosis_date', date('Y')) // current year only
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month');

            $data = [];
            for ($i = 1; $i <= 12; $i++) {
                $data[] = $patients[$i] ?? 0;
            }

            return response()->json($data);
        }

        public function getAgeGroupDistribution()
        {
            $data = DB::table('tbl_patients')
                ->selectRaw("
                    SUM(CASE WHEN pat_age BETWEEN 0 AND 14 THEN 1 ELSE 0 END) as age_0_14,
                    SUM(CASE WHEN pat_age BETWEEN 15 AND 24 THEN 1 ELSE 0 END) as age_15_24,
                    SUM(CASE WHEN pat_age BETWEEN 25 AND 44 THEN 1 ELSE 0 END) as age_25_44,
                    SUM(CASE WHEN pat_age BETWEEN 45 AND 64 THEN 1 ELSE 0 END) as age_45_64,
                    SUM(CASE WHEN pat_age >= 65 THEN 1 ELSE 0 END) as age_65
                ")->first();

            return response()->json($data);
        }

        public function validatePage1 (Request $request) {

            // Diagnosing Facility
            $diagnosing_facility_validate = $request->validate([
                'fac_name' => 'required',
                'fac_ntp_code' => 'required',
                'fac_province' => 'required',
                'fac_region' => 'required'
            ]);

            $diagnosing_facility_validate['user_id'] = Auth::id();
            $facility = DiagnosingFacility::create($diagnosing_facility_validate);

            // Patient Demographic
            $patient_validate = $request->validate([
                'pat_full_name' => 'required',
                'pat_date_of_birth' => 'required',
                'pat_age' => 'required',
                'pat_sex' => 'required',
                'pat_civil_status' => 'required',
                'pat_permanent_address' => 'required',
                'pat_permanent_city_mun' => 'required',
                'pat_permanent_province' => 'required',
                'pat_permanent_region' => 'required',
                'pat_permanent_zip_code' => 'required',
                'pat_current_address' => 'required',
                'pat_current_city_mun' => 'required',
                'pat_current_province' => 'required',
                'pat_current_region' => 'required',
                'pat_current_zip_code' => 'required',
                'pat_contact_number' => 'required',
                'pat_other_contact' => 'nullable',
                'pat_philhealth_no' => 'nullable',
                'pat_nationality' => 'required'
            ]);
            
            $patient_validate['diagfacility_id'] = $facility->id; // link patient to facility
            $patient_validate['user_id'] = Auth::id();
            $patient = Patient::create($patient_validate);

            // Screening
            $screening_validate = $request->validate([
                'scr_referred_by' => 'required',
                'scr_location' => 'required',
                'scr_referrer_type' => 'required',
                'scr_screening_mode' => 'required',
                'scr_screening_date' => 'required'
            ]);

            $screening_validate['patient_id'] = $patient->id;
            Screening::create($screening_validate);

            // Laboratory Tests
            $labtest_validate = $request->validate([
                'lab_xpert_test_date' => 'required',
                'lab_xpert_result' => 'required',
                'lab_smear_test_date' => 'nullable',
                'lab_smear_result' => 'nullable',
                'lab_cxray_test_date' => 'required',
                'lab_cxray_result' => 'required',
                'lab_tst_test_date' => 'nullable',
                'lab_tst_result' => 'nullable',
                'lab_other_test_date' => 'nullable',
                'lab_other_result' => 'nullable',
            ]);

            $labtest_validate['patient_id'] = $patient->id;
            $labtest_validate['diagfacility_id'] = $facility->id;
            LaboratoryTest::create($labtest_validate);

            // Diagnosis
            $diagnosis_validate = $request->validate([
                'diag_diagnosis_date' => 'required',
                'diag_notification_date' => 'required',
                // 'diag_tb_case_no' => 'required',
                'diag_attending_physician' => 'required',
                'diag_referred_to' => 'nullable',
                'diag_address' => 'nullable',
                'diag_facility_code' => 'nullable',
                'diag_province' => 'nullable',
                'diag_region' => 'nullable'
            ]);

            // Auto-generate TB Case Number
            $latestNumber = Diagnosis::max('id'); // kunin yung pinakamataas na id
            $nextId = $latestNumber ? $latestNumber + 1 : 1;

            $tbCaseNo = 'TB-' . date('Y') . '-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            $diagnosis_validate['diag_tb_case_no'] = $tbCaseNo;
            $diagnosis_validate['patient_id'] = $patient->id;
            $labtest_validate['diagfacility_id'] = $facility->id;

            Diagnosis::create($diagnosis_validate);


            // TB Classification
            $tbclassification_validate = $request->validate([
                'clas_bacteriological_status' => 'required',
                'clas_drug_resistance_status' => 'required',
                'clas_other_drug_resistant' => 'nullable',
                'clas_anatomical_site' => 'required',
                'clas_site_other' => 'nullable',
                'clas_registration_group' => 'required'
            ]);

            $tbclassification_validate['patient_id'] = $patient->id;
            TBClassification::create($tbclassification_validate);

            // Save IDs to session
            session(['patient_id' => $patient->id]);
            session(['diagfacility_id' => $facility->id]);

            // after validation and saving Page 1
            session([
                'trea_name' => $request->fac_name,
                'trea_ntp_code' => $request->fac_ntp_code,
                'trea_province' => $request->fac_province,
                'trea_region' => $request->fac_region,
            ]);

            return redirect ('form/page2')->with('success', 'You have successfully completed Page 1.');
        }

        public function validatePage2 (Request $request) {

            $patientId = session('patient_id');

            // Treatment Facility
            $treatment_facility_validate = $request->validate([
                'trea_name' => 'required',
                'trea_ntp_code' => 'required',
                'trea_province' => 'required',
                'trea_region' => 'required'
            ]);

            $treatment_facility_validate['patient_id'] = $patientId;
            $treatmentFacility = TreatmentFacility::create($treatment_facility_validate);

            // Treatment History
            $treatment_history_validate = $request->validate([
                'hist_date_tx_started' => 'nullable',
                'hist_treatment_unit' => 'nullable',
                'hist_regimen' => 'nullable',
                'hist_outcome' => 'nullable'
            ]);

            $treatment_history_validate['patient_id'] = $patientId;
            $treatment_history_validate['treatfacility_id'] = $treatmentFacility->id;

            TreatmentHistory::create($treatment_history_validate);

            // HIV Infos
            $hiv_info_validate = $request->validate([
                'hiv_information' => 'nullable',
                'hiv_test_date' => 'nullable',
                'hiv_confirmatory_test_date' => 'nullable',
                'hiv_result' => 'nullable',
                'hiv_art_started' => 'nullable',
                'hiv_cpt_started' => 'nullable',
            ]);

            $hiv_info_validate['patient_id'] = $patientId;
            HIVInfo::create($hiv_info_validate);

            // Baseline Info
            $baseline_info_validate = $request->validate([
                'base_weight' => 'required',
                'base_height' => 'required',
                'base_vital_signs' => 'required',
                'base_emergency_contact_name' => 'required',
                'base_relationship' => 'required',
                'base_contact_info' => 'required',
                'base_diabetes_screening' => 'required',
                'base_four_ps_beneficiary' => 'required',
                'base_fbs_screening' => 'required',
                'base_date_tested' => 'required',
                'base_occupation' => 'required'
            ]);

            $baseline_info_validate['patient_id'] = $patientId;
            BaselineInfo::create($baseline_info_validate);

            // Comorbidities
            $comorbidity_validate = $request->validate([
                'com_date_diagnosed' => 'nullable',
                'com_type' => 'nullable',
                'com_other' => 'nullable',
                'com_treatment' => 'nullable'
            ]);

            $comorbidity_validate['patient_id'] = $patientId;
            Comorbidity::create($comorbidity_validate);

            // Treatment Regimen
            $treatment_regimen_validate = $request->validate([
                'reg_start_type' => 'required',
                'reg_start_date' => 'required',
                'reg_end_type' => 'nullable'
            ]);

            $treatment_regimen_validate['patient_id'] = $patientId;
            TreatmentRegimen::create($treatment_regimen_validate);

            // Treatment Outcome
            $treatment_outcome_validate = $request->validate([
                'out_outcome' => 'nullable',
                'out_date' => 'nullable',
                'out_reason' => 'nullable'
            ]);

            $treatment_outcome_validate['patient_id'] = $patientId;
            TreatmentOutcome::create($treatment_outcome_validate);

            // Prescribed Drug
            $prescribed_drug_validate = $request->validate([
                'drug_start_date' => 'required',
                'drug_name' => 'required',
                'drug_strength' => 'required',
                'drug_unit' => 'required',
                'drug_con_date' => 'nullable',
                'drug_con_name' => 'nullable',
                'drug_con_strength' => 'nullable',
                'drug_con_unit' => 'nullable'
            ]);

            $prescribed_drug_validate['patient_id'] = $patientId;
            PrescribedDrug::create($prescribed_drug_validate);

            // Tx Supporter
            $tx_supporter_validate = $request->validate([
                'sup_location' => 'required',
                'sup_name' => 'required',
                'sup_designation' => 'required',
                'sup_type' => 'required',
                'sup_contact_info' => 'required',
                'sup_treatment_schedule' => 'required',
                'sup_dat_used' => 'nullable'
            ]);

            $tx_supporter_validate['patient_id'] = $patientId;
            TxSupporter::create($tx_supporter_validate);

            // Adherence
            $adherence_validate = $request->validate([
                'pha_intensive_start' => 'required',
                'pha_intensive_end' => 'nullable',
                'pha_continuation_start' => 'nullable',
                'pha_continuation_end' => 'nullable',
                'pha_month' => 'nullable',
                'pha_monthly_doses' => 'nullable',
                'pha_cumulative_doses' => 'nullable',
                'pha_monthly_missed' => 'nullable',
                'pha_adherence_percent' => 'nullable',
                'pha_weight' => 'nullable',
                'pha_child_height' => 'nullable'
            ]);

            $adherence_validate['patient_id'] = $patientId;
            Adherence::create($adherence_validate);

            return redirect('form/page3')->with('success', 'You have successfully completed Page 2.');
        }

        public function validatePage3 (Request $request) {

            $patientId = session('patient_id');

            // Adverse Events
            $adverse_events_validate = $request->validate([
                'adv_ae_date' => 'nullable',
                'adv_specific_ae' => 'nullable',
                'adv_fda_reported_date' => 'nullable'
            ]);

            $adverse_events_validate['patient_id'] = $patientId;
            AdverseEvent::create($adverse_events_validate);

            // Patient Progress
            $progress_validate = $request->validate([
                'prog_date' => 'nullable',
                'prog_problem' => 'nullable',
                'prog_action_taken' => 'nullable',
                'prog_plan' => 'nullable'
            ]);

            $progress_validate['patient_id'] = $patientId;
            Progress::create($progress_validate);

            // Close Contact
            $close_contact_validate = $request->validate([
                'con_name' => 'nullable',
                'con_age' => 'nullable',
                'con_sex' => 'nullable',
                'con_relationship' => 'nullable',
                'con_initial_screening' => 'nullable',
                'con_follow_up' => 'nullable',
                'con_remarks' => 'nullable'
            ]);

            $close_contact_validate['patient_id'] = $patientId;
            CloseContact::create($close_contact_validate);

            // Sputum Monitoring
            $sputum_monitoring_validate = $request->validate([
                'sput_date_collected' => 'nullable',
                'sput_smear_result' => 'nullable',
                'sput_xpert_result' => 'nullable'
            ]);

            $sputum_monitoring_validate['patient_id'] = $patientId;
            SputumMonitoring::create($sputum_monitoring_validate);

            // Chest Xray
            $chest_xray_validate = $request->validate([
                'xray_date_examined' => 'nullable',
                'xray_impression' => 'nullable',
                'xray_descriptive_comment' => 'nullable'
            ]);

            $chest_xray_validate['patient_id'] = $patientId;
            ChestXray::create($chest_xray_validate);

            // Post Treatment Follow Up
            $post_treatment_validate = $request->validate([
                'fol_months_after_tx' => 'nullable',
                'fol_date' => 'nullable',
                'fol_cxr_findings' => 'nullable',
                'fol_smear_xpert' => 'nullable',
                'fol_tbc_dst' => 'nullable'
            ]);

            $post_treatment_validate['patient_id'] = $patientId;
            PostTreatmentFollowUp::create($post_treatment_validate);

            return redirect()->route('admin.patient')->with('success', 'Added Patient Successfully!');
        }

        public function createAccount (Patient $patient)
        {
            $facilities = DiagnosingFacility::all();

            return view ('admin.create-patient-account', compact('patient', 'facilities'));
        }

        public function store(Request $request)
        {
            $validator = Validator::make($request->all(), [
                'adm_username'    => 'required|string|max:255|unique:tbl_admins,adm_username',
                'adm_password'    => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/[A-Z]/',
                    'regex:/[a-z]/',
                    'regex:/[0-9]/',
                    'regex:/[\W]/', 
                ],
                'patient_id'      => 'required|exists:tbl_patients,id',
                'diagfacility_id' => 'nullable|exists:tbl_diagnosing_facilities,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            Admin::create([
                'adm_username'    => $request->adm_username,
                'adm_password'    => Hash::make($request->adm_password),
                'patient_id'      => $request->patient_id,
                'diagfacility_id' => $request->diagfacility_id,
            ]);

            return redirect()->route('admin.patient')
                            ->with('success', 'Patient account created successfully.');
        }

        public function patientAccount(Request $request)
    {
        $patientAccount = DB::table('tbl_patients as p')
            ->join('tbl_admins as a', 'p.id', '=', 'a.patient_id')
            ->select(
                'p.id',
                'p.pat_full_name',
                'a.adm_username',
                'a.adm_password'
            )
        ->paginate(10);

        return view ('admin.patient-accounts', compact('patientAccount'));
    }
    


}
