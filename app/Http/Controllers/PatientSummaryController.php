<?php

namespace App\Http\Controllers;

use App\Models\TBClassification;
use Illuminate\Http\Request;
use App\Models\Patient;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;


class PatientSummaryController extends Controller
{

    public function patientSummary($id)
    {
        // Get patient with joins
        $patient = DB::table('tbl_patients as p')
            // ->leftJoin('tbl_diagnosing_facilities as df', 'p.id', '=', 'df.patient_id')
            ->leftJoin('tbl_screenings as si', 'p.id', '=', 'si.patient_id')
            ->leftJoin('tbl_laboratory_tests as lt', 'p.id', '=', 'lt.patient_id')
            ->leftJoin('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->leftJoin('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->leftJoin('tbl_treatment_facilities as tf', 'p.id', '=', 'tf.patient_id')
            ->leftJoin('tbl_treatment_histories as th', 'p.id', '=', 'th.patient_id')
            ->leftJoin('tbl_comorbidities as co', 'p.id', '=', 'co.patient_id')
            ->leftJoin('tbl_baseline_infos as bi', 'p.id', '=', 'bi.patient_id')
            ->leftJoin('tbl_hiv_infos as h', 'p.id', '=', 'h.patient_id')
            ->leftJoin('tbl_treatment_regimens as tr', 'p.id', '=', 'tr.patient_id')
            ->leftJoin('tbl_tx_supporters as tx', 'p.id', '=', 'tx.patient_id')
            ->leftJoin('tbl_adherences as a', 'p.id', '=', 'a.patient_id')
            ->leftJoin('tbl_prescribed_drugs as pd', 'p.id', '=', 'pd.patient_id')
            ->leftJoin('tbl_treatment_outcomes as to', 'p.id', '=', 'to.patient_id')
            ->leftJoin('tbl_adverse_events as e', 'p.id', '=', 'e.patient_id')
            ->leftJoin('tbl_progress as pr', 'p.id', '=', 'pr.patient_id')
            ->leftJoin('tbl_close_contacts as cc', 'p.id', '=', 'cc.patient_id')
            ->leftJoin('tbl_sputum_monitorings as sp', 'p.id', '=', 'sp.patient_id')
            ->leftJoin('tbl_chest_xrays as x', 'p.id', '=', 'x.patient_id')
            ->leftJoin('tbl_post_treatment_follow_ups as f', 'p.id', '=', 'f.patient_id')
            ->select(
                // Diagnosing Facility
                // 'df.fac_name',
                // 'df.fac_ntp_code',
                // 'df.fac_province',
                // 'df.fac_region',

                // Patient Demographic
                'p.id',
                'p.pat_full_name as name',
                'p.pat_date_of_birth as birth_date',
                'p.pat_age as age',
                'p.pat_sex as sex',
                'p.pat_civil_status as civil_status',
                'p.pat_other_contact as other_contact',
                'p.pat_philhealth_no as philhealth_no',
                'p.pat_nationality as nationality',
                'p.pat_current_address as address',
                'p.pat_current_city_mun as city',
                'p.pat_current_province as province',
                'p.pat_current_region as region',
                'p.pat_current_zip_code as zip_code',
                'p.pat_contact_number as contact',
                
                // Screening Information
                'si.scr_referred_by',
                'si.scr_location',
                'si.scr_referrer_type',
                'si.scr_screening_mode',
                'si.scr_screening_date',

                // Laboratory Tests
                'lt.lab_xpert_test_date',
                'lt.lab_xpert_result',
                'lt.lab_smear_test_date',
                'lt.lab_smear_result',
                'lt.lab_cxray_test_date',
                'lt.lab_cxray_result',
                'lt.lab_tst_test_date',
                'lt.lab_tst_result',
                'lt.lab_other_test_date',
                'lt.lab_other_result',

                // Diagnosis
                'd.diag_diagnosis_date',
                'd.diag_notification_date',
                'd.diag_tb_case_no',
                'd.diag_attending_physician',
                'd.diag_referred_to',
                'd.diag_address',
                'd.diag_facility_code',
                'd.diag_province',
                'd.diag_region',

                // TB Disease Classification
                'c.clas_bacteriological_status',
                'c.clas_drug_resistance_status',
                'c.clas_other_drug_resistant',
                'c.clas_anatomical_site',
                'c.clas_site_other',
                'c.clas_registration_group',

                // Treatment Facility
                'tf.trea_name',
                'tf.trea_ntp_code',
                'tf.trea_province',
                'tf.trea_region',
                
                // History of TB Treatment
                'th.hist_date_tx_started',
                'th.hist_treatment_unit',
                'th.hist_drug',
                'th.hist_treatment_duration',
                'th.hist_outcome',

                // Co-morbidities
                'co.com_date_diagnosed',
                'co.com_type',
                'co.com_other',
                'co.com_treatment',

                // Baseline Information
                'bi.base_weight',
                'bi.base_height',
                'bi.base_blood_pressure',
                'bi.base_pulse_rate',
                'bi.base_temperature',
                'bi.base_emergency_contact_name',
                'bi.base_relationship',
                'bi.base_contact_info',
                'bi.base_diabetes_screening',
                'bi.base_four_ps_beneficiary',
                'bi.base_fbs_screening',
                'bi.base_date_tested',
                'bi.base_occupation',

                // HIV Information
                'h.hiv_information',
                'h.hiv_test_date',
                'h.hiv_confirmatory_test_date',
                'h.hiv_result',
                'h.hiv_art_started',
                'h.hiv_cpt_started',
                
                // Treatment Regimen
                'tr.reg_start_type',
                'tr.reg_start_date',
                'tr.reg_end_type',

                // Tx Supporter
                'tx.sup_location',
                'tx.sup_name',
                'tx.sup_designation',
                'tx.sup_type',
                'tx.sup_contact_info',
                'tx.sup_treatment_schedule',
                'tx.sup_dat_used',

                // Adherence
                'a.pha_intensive_start',
                'a.pha_intensive_end',
                'a.pha_continuation_start',
                'a.pha_continuation_end',
                'a.pha_weight',
                'a.pha_child_height',

                // Prescribed Drugs
                'pd.drug_start_date',
                'pd.drug_name',
                'pd.drug_no_of_tablets',
                'pd.drug_strength',
                'pd.drug_unit',
                'pd.drug_con_date',
                'pd.drug_con_name',
                'pd.drug_con_no_of_tablets',
                'pd.drug_con_strength',
                'pd.drug_con_unit',

                // Treatment Outcome
                'to.out_outcome',
                'to.out_date',
                'to.out_reason',
                
                // Adverse Event
                'e.adv_ae_date',
                'e.adv_specific_ae',
                'e.adv_fda_reported_date',

                // Patient Progress
                'pr.prog_date',
                'pr.prog_problem',
                'pr.prog_action_taken',
                'pr.prog_plan',

                // Close Contact
                'cc.con_name',
                'cc.con_age',
                'cc.con_sex',
                'cc.con_relationship',
                'cc.con_initial_screening',
                'cc.con_follow_up',
                'cc.con_remarks',

                // Sputum Monitoring
                'sp.sput_date_collected',
                'sp.sput_smear_result',
                'sp.sput_xpert_result',

                // Chest X-ray
                'x.xray_date_examined',
                'x.xray_impression',
                'x.xray_descriptive_comment',

                // Post Treatment Follow Up
                'f.fol_months_after_tx',
                'f.fol_date',
                'f.fol_cxr_findings',
                'f.fol_smear_xpert',
                'f.fol_tbc_dst',

            )
            ->where('p.id', $id)
            ->first();

        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found.');
        }

        // Load PDF view
        $pdf = PDF::loadView('pdf.patient-summary-report', [
            'patient' => $patient,
            'generated' => now()->format('F d, Y'),
            'clinic' => 'TB DOTS Tagoloan' // replace with your facility name
        ])->setPaper('A4', 'portrait');

        // ✅ Add Page Number
    $canvas = $pdf->getDomPDF()->getCanvas();
    $canvas->page_text(
        520, // X position
        30, // Y position
        // "Page {PAGE_NUM} of {PAGE_COUNT}",
        "{PAGE_NUM}", 
        null, 
        10, 
        [0, 0, 0] // Text color (black)
    );

        return $pdf->stream('Patient Summary Report' . '.pdf');
    }

    public function newlyDiagnosedPDF(Request $request)
{
    ini_set('memory_limit', '512M');
    set_time_limit(300);

    // Optional filters
    $startDate = $request->query('start_date');
    $endDate = $request->query('end_date');

    /**
     * 1️⃣ EARLIEST classification per patient
     *    We only include patient if FIRST = "new"
     */
    $firstClass = DB::table('tbl_tb_classifications as t1')
        ->select(
            't1.id',
            't1.patient_id',
            't1.clas_registration_group',
            't1.created_at as class_date'
        )
        ->whereRaw('t1.id = (
            SELECT t2.id 
            FROM tbl_tb_classifications t2
            WHERE t2.patient_id = t1.patient_id
            ORDER BY t2.id ASC
            LIMIT 1
        )')
        ->where('t1.clas_registration_group', 'new');  // only earliest = new
    /**
     * 2️⃣ EARLIEST diagnosis per patient
     *     (Diagnosis recorded during the NEW phase,
     *      NOT relapse or later diagnosis)
     */
    $diagnosisAtNew = DB::table('tbl_diagnosis as d1')
        ->select(
            'd1.id',
            'd1.patient_id',
            'd1.diag_diagnosis_date',
            'd1.diag_tb_case_no'
        )
        ->whereRaw('d1.id = (
            SELECT d2.id
            FROM tbl_diagnosis d2
            WHERE d2.patient_id = d1.patient_id
            ORDER BY d2.id ASC   -- earliest diagnosis
            LIMIT 1
        )');
    /**
     * 3️⃣ MAIN QUERY: combine filtered first classification + first diagnosis
     */
    $query = DB::table('tbl_patients as p')
        ->joinSub($firstClass, 't', 'p.id', '=', 't.patient_id')
        ->leftJoinSub($diagnosisAtNew, 'd', 'p.id', '=', 'd.patient_id')
        ->select(
            'p.pat_full_name',
            DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
            'p.pat_sex',
            'p.pat_permanent_address as barangay',
            'd.diag_diagnosis_date',
            'd.diag_tb_case_no',
            't.clas_registration_group'
        );
    /**
     * 4️⃣ Optional date range filter
     */
    if ($startDate) {
        $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
    }

    if ($endDate) {
        $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
    }
    /**
     * 5️⃣ CACHE
     */
    $cacheKey = "newly_diagnosed_pdf_{$startDate}_{$endDate}";
    $patients = Cache::remember($cacheKey, 300, function () use ($query) {
        return $query->orderBy('d.diag_diagnosis_date', 'desc')->get();
    });
    /**
     * 6️⃣ GENERATE PDF
     */
    $pdf = PDF::loadView('pdf.newly-diagnosed-report', ['new' => $patients])
        ->setPaper('A4', 'landscape');
    // Page Number
    $pdf->output();
    $canvas = $pdf->getDomPDF()->getCanvas();
    $w = $canvas->get_width();
    $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
    $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

    return $pdf->stream('Newly Diagnosed Report.pdf');
}




    public function relapsePDF(Request $request)
{
    ini_set('memory_limit', '512M');
    set_time_limit(300);

    $startDate = $request->query('start_date');
    $endDate = $request->query('end_date');

    // 1️⃣ Get only the LATEST relapse classification per patient
    $latestRelapse = DB::table('tbl_tb_classifications as t1')
        ->select(
            't1.id',
            't1.patient_id',
            't1.clas_registration_group',
            't1.created_at'
        )
        ->where('t1.clas_registration_group', 'Relapse')
        ->whereRaw("t1.id = (
            SELECT t2.id
            FROM tbl_tb_classifications t2
            WHERE t2.patient_id = t1.patient_id
              AND t2.clas_registration_group = 'Relapse'
            ORDER BY t2.id DESC
            LIMIT 1
        )");

    // 2️⃣ Get the LATEST diagnosis per patient
    $latestDiagnosis = DB::table('tbl_diagnosis as d1')
        ->select(
            'd1.id',
            'd1.patient_id',
            'd1.diag_diagnosis_date',
            'd1.diag_tb_case_no'
        )
        ->whereRaw("d1.id = (
            SELECT d2.id
            FROM tbl_diagnosis d2
            WHERE d2.patient_id = d1.patient_id
            ORDER BY d2.id DESC
            LIMIT 1
        )");

    // 3️⃣ Main query
    $query = DB::table('tbl_patients as p')
        ->joinSub($latestRelapse, 't', 'p.id', '=', 't.patient_id')
        ->leftJoinSub($latestDiagnosis, 'd', 'p.id', '=', 'd.patient_id')
        ->select(
            'p.pat_full_name',
            DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
            'p.pat_sex',
            'p.pat_permanent_address as barangay',
            'd.diag_diagnosis_date',
            'd.diag_tb_case_no',
            't.clas_registration_group'
        );

    // 4️⃣ Date filter
    if ($startDate) {
        $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
    }
    if ($endDate) {
        $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
    }

    // 5️⃣ Sort by latest TB case
    $patients = $query->orderByDesc('d.diag_tb_case_no')->get();

    // 6️⃣ Generate PDF
    $pdf = Pdf::loadView('pdf.relapse-report', ['relapse' => $patients])
        ->setPaper('A4', 'landscape');

    $pdf->output();
    $canvas = $pdf->getDomPDF()->getCanvas();
    $w = $canvas->get_width();
    $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
    $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

    return $pdf->stream('Relapse Report.pdf');
}



    public function bacteriologicallyConfirmedPDF(Request $request)
{
    ini_set('memory_limit', '512M');
    set_time_limit(300);

    $startDate = $request->query('start_date');
    $endDate = $request->query('end_date');

    // 1️⃣ Latest BC classification per patient
    $latestBC = DB::table('tbl_tb_classifications as c1')
        ->select(
            'c1.id',
            'c1.patient_id',
            'c1.clas_bacteriological_status',
            'c1.created_at'
        )
        ->where('c1.clas_bacteriological_status', 'Bacteriologically-confirmed TB')
        ->whereRaw("c1.id = (
            SELECT c2.id
            FROM tbl_tb_classifications c2
            WHERE c2.patient_id = c1.patient_id
              AND c2.clas_bacteriological_status = 'Bacteriologically-confirmed TB'
            ORDER BY c2.id DESC
            LIMIT 1
        )");

    // 2️⃣ Latest diagnosis per patient
    $latestDiagnosis = DB::table('tbl_diagnosis as d1')
        ->select(
            'd1.id',
            'd1.patient_id',
            'd1.diag_diagnosis_date',
            'd1.diag_tb_case_no'
        )
        ->whereRaw("d1.id = (
            SELECT d2.id
            FROM tbl_diagnosis d2
            WHERE d2.patient_id = d1.patient_id
            ORDER BY d2.id DESC
            LIMIT 1
        )");

    // 3️⃣ Main Query
    $query = DB::table('tbl_patients as p')
        ->joinSub($latestBC, 'c', 'p.id', '=', 'c.patient_id')
        ->leftJoinSub($latestDiagnosis, 'd', 'p.id', '=', 'd.patient_id')
        ->select(
            'p.pat_full_name',
            DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
            'p.pat_sex',
            'p.pat_permanent_address as barangay',
            'd.diag_tb_case_no',
            'd.diag_diagnosis_date',
            'c.clas_bacteriological_status as tb_classification'
        );

    // 4️⃣ Date filters
    if ($startDate) {
        $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
    }
    if ($endDate) {
        $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
    }

    // 5️⃣ Fetch final sorted list
    $patients = $query->orderByDesc('d.diag_tb_case_no')->get();

    // 6️⃣ Generate PDF
    $pdf = Pdf::loadView('pdf.bacteriologically-confirmed-report', [
        'bacteriologicallyConfirmed' => $patients
    ])->setPaper('A4', 'landscape');

    $pdf->output();
    $canvas = $pdf->getDomPDF()->getCanvas();
    $w = $canvas->get_width();
    $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
    $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

    return $pdf->stream('Bacteriologically-Confirmed TB Report.pdf');
}


    public function clinicallyDiagnosedPDF(Request $request)
{
    ini_set('memory_limit', '512M');
    set_time_limit(300);

    $startDate = $request->query('start_date');
    $endDate = $request->query('end_date');

    // Subquery: get latest diagnosis date per patient
    $latestDiagnosis = DB::table('tbl_diagnosis')
        ->select(
            'patient_id',
            DB::raw('MAX(diag_diagnosis_date) as latest_date')
        )
        ->groupBy('patient_id');

    // Subquery: get latest classification per patient
    $latestClassification = DB::table('tbl_tb_classifications')
        ->select(
            'patient_id',
            DB::raw('MAX(id) as latest_classification_id')
        )
        ->groupBy('patient_id');

    $query = DB::table('tbl_patients as p')
        ->joinSub($latestDiagnosis, 'ld', function ($join) {
            $join->on('p.id', '=', 'ld.patient_id');
        })
        ->join('tbl_diagnosis as d', function ($join) {
            $join->on('d.patient_id', '=', 'p.id')
                 ->on('d.diag_diagnosis_date', '=', 'ld.latest_date');
        })
        ->joinSub($latestClassification, 'lc', function ($join) {
            $join->on('p.id', '=', 'lc.patient_id');
        })
        ->join('tbl_tb_classifications as c', function ($join) {
            $join->on('c.patient_id', '=', 'p.id')
                 ->on('c.id', '=', 'lc.latest_classification_id');
        })
        ->select(
            'p.pat_full_name',
            DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
            'p.pat_sex',
            'p.pat_permanent_address as barangay',
            'd.diag_tb_case_no',
            'd.diag_diagnosis_date',
            'c.clas_bacteriological_status as tb_classification'
        )
        ->where('c.clas_bacteriological_status', 'Clinically-diagnosed TB');

    // DATE FILTERS (applied to latest record only)
    if ($startDate) {
        $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
    }

    if ($endDate) {
        $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
    }

    // SORTING
    $patient = $query
        ->orderBy('d.diag_diagnosis_date', 'DESC')
        ->orderByRaw("
            STR_TO_DATE(SUBSTRING_INDEX(d.diag_tb_case_no, '-', 1), '%Y') DESC
        ")
        ->orderByRaw("
            CAST(SUBSTRING_INDEX(d.diag_tb_case_no, '-', -1) AS UNSIGNED) DESC
        ")
        ->get();

    // PDF GENERATION
    $pdf = Pdf::loadView('pdf.clinically-diagnosed-report', [
        'clinicallyDiagnosed' => $patient
    ])->setPaper('A4', 'landscape');

    // PAGE NUMBERING
    $pdf->output();
    $canvas = $pdf->getDomPDF()->getCanvas();
    $w = $canvas->get_width();
    $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
    $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

    return $pdf->stream('Clinically Diagnosed Report.pdf');
}



    public function pulmonaryPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Subquery: get latest diagnosis ID per patient (using both date and id)
        $latestDiagnosis = DB::table('tbl_diagnosis as d1')
            ->select('d1.patient_id', DB::raw('MAX(d1.id) as latest_diag_id'))
            ->whereIn('d1.id', function($query) {
                $query->select(DB::raw('MAX(d2.id)'))
                    ->from('tbl_diagnosis as d2')
                    ->whereColumn('d2.patient_id', 'd1.patient_id')
                    ->groupBy('d2.patient_id');
            })
            ->groupBy('d1.patient_id');

        // Subquery: get latest classification ID per patient
        $latestClassification = DB::table('tbl_tb_classifications')
            ->select(
                'patient_id',
                DB::raw('MAX(id) as latest_classification_id')
            )
            ->groupBy('patient_id');

        $query = DB::table('tbl_patients as p')
            ->joinSub($latestDiagnosis, 'ld', function ($join) {
                $join->on('p.id', '=', 'ld.patient_id');
            })
            ->join('tbl_diagnosis as d', 'd.id', '=', 'ld.latest_diag_id')
            ->joinSub($latestClassification, 'lc', function ($join) {
                $join->on('p.id', '=', 'lc.patient_id');
            })
            ->join('tbl_tb_classifications as c', 'c.id', '=', 'lc.latest_classification_id')
            ->select(
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_tb_case_no',
                'd.diag_diagnosis_date',
                'c.clas_anatomical_site as anatomical_site'
            )
            ->where('c.clas_anatomical_site', 'Pulmonary');

        if ($startDate) {
            $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
        }

        $patients = $query
            ->orderBy('d.diag_diagnosis_date', 'DESC')
            ->orderByRaw("STR_TO_DATE(SUBSTRING_INDEX(d.diag_tb_case_no, '-', 1), '%Y') DESC")
            ->orderByRaw("CAST(SUBSTRING_INDEX(d.diag_tb_case_no, '-', -1) AS UNSIGNED) DESC")
            ->get();

        $pdf = Pdf::loadView('pdf.pulmonary-report', ['pulmonary' => $patients])
            ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Pulmonary TB Report.pdf');
    }

    public function extraPulmonaryPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Subquery: get latest diagnosis ID per patient
        $latestDiagnosis = DB::table('tbl_diagnosis as d1')
            ->select('d1.patient_id', DB::raw('MAX(d1.id) as latest_diag_id'))
            ->whereIn('d1.id', function($query) {
                $query->select(DB::raw('MAX(d2.id)'))
                    ->from('tbl_diagnosis as d2')
                    ->whereColumn('d2.patient_id', 'd1.patient_id')
                    ->groupBy('d2.patient_id');
            })
            ->groupBy('d1.patient_id');

        // Subquery: get latest classification ID per patient
        $latestClassification = DB::table('tbl_tb_classifications')
            ->select(
                'patient_id',
                DB::raw('MAX(id) as latest_classification_id')
            )
            ->groupBy('patient_id');

        $query = DB::table('tbl_patients as p')
            ->joinSub($latestDiagnosis, 'ld', function ($join) {
                $join->on('p.id', '=', 'ld.patient_id');
            })
            ->join('tbl_diagnosis as d', 'd.id', '=', 'ld.latest_diag_id')
            ->joinSub($latestClassification, 'lc', function ($join) {
                $join->on('p.id', '=', 'lc.patient_id');
            })
            ->join('tbl_tb_classifications as c', 'c.id', '=', 'lc.latest_classification_id')
            ->select(
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_tb_case_no',
                'd.diag_diagnosis_date',
                'c.clas_anatomical_site as anatomical_site',
                'c.clas_site_other as site_other'
            )
            ->where('c.clas_anatomical_site', 'Extra-pulmonary');

        if ($startDate) {
            $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
        }

        $patients = $query
            ->orderBy('d.diag_diagnosis_date', 'DESC')
            ->orderByRaw("STR_TO_DATE(SUBSTRING_INDEX(d.diag_tb_case_no, '-', 1), '%Y') DESC")
            ->orderByRaw("CAST(SUBSTRING_INDEX(d.diag_tb_case_no, '-', -1) AS UNSIGNED) DESC")
            ->get();

        $pdf = Pdf::loadView('pdf.extra-pulmonary-report', ['extraPulmonary' => $patients])
            ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Extra Pulmonary TB Report.pdf');
    }

    public function ongoingTreatmentPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Subquery: get latest diagnosis ID per patient
        $latestDiagnosis = DB::table('tbl_diagnosis as d1')
            ->select('d1.patient_id', DB::raw('MAX(d1.id) as latest_diag_id'))
            ->whereIn('d1.id', function($query) {
                $query->select(DB::raw('MAX(d2.id)'))
                    ->from('tbl_diagnosis as d2')
                    ->whereColumn('d2.patient_id', 'd1.patient_id')
                    ->groupBy('d2.patient_id');
            })
            ->groupBy('d1.patient_id');

        // Subquery: get latest treatment outcome ID per patient
        $latestOutcome = DB::table('tbl_treatment_outcomes')
            ->select(
                'patient_id',
                DB::raw('MAX(id) as latest_outcome_id')
            )
            ->groupBy('patient_id');

        // Subquery: get latest treatment regimen ID per patient
        $latestRegimen = DB::table('tbl_treatment_regimens')
            ->select(
                'patient_id',
                DB::raw('MAX(id) as latest_regimen_id')
            )
            ->groupBy('patient_id');

        $query = DB::table('tbl_patients as p')
            ->joinSub($latestDiagnosis, 'ld', function ($join) {
                $join->on('p.id', '=', 'ld.patient_id');
            })
            ->join('tbl_diagnosis as d', 'd.id', '=', 'ld.latest_diag_id')
            ->joinSub($latestOutcome, 'lo', function ($join) {
                $join->on('p.id', '=', 'lo.patient_id');
            })
            ->join('tbl_treatment_outcomes as t', 't.id', '=', 'lo.latest_outcome_id')
            ->joinSub($latestRegimen, 'lr', function ($join) {
                $join->on('p.id', '=', 'lr.patient_id');
            })
            ->join('tbl_treatment_regimens as r', 'r.id', '=', 'lr.latest_regimen_id')
            ->select(
                'd.diag_tb_case_no',
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'r.reg_start_date',
                't.out_outcome as outcome'
            )
            ->where('t.out_outcome', 'Ongoing');

        if ($startDate) {
            $query->whereDate('r.reg_start_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('r.reg_start_date', '<=', $endDate);
        }

        $patients = $query
            ->orderBy('r.reg_start_date', 'DESC')
            ->orderByRaw("STR_TO_DATE(SUBSTRING_INDEX(d.diag_tb_case_no, '-', 1), '%Y') DESC")
            ->orderByRaw("CAST(SUBSTRING_INDEX(d.diag_tb_case_no, '-', -1) AS UNSIGNED) DESC")
            ->get();

        $pdf = Pdf::loadView('pdf.ongoing-treatment-report', ['ongoingPatients' => $patients])
            ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Ongoing Treatment Report.pdf');
    }

    public function barangayCasesPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $barangay = $request->query('barangay');

        $query = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->select(
                'p.id',
                'p.pat_permanent_address AS barangay',
                'p.pat_full_name AS patient_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'd.diag_diagnosis_date',
                'd.diag_tb_case_no',
                't.out_outcome'
            );

        if ($startDate) {
            $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
        }
        if ($barangay) {
            $query->where('p.pat_permanent_address', $barangay);
        }

        $brgyCases = $query
            ->orderBy('barangay')
            ->orderByDesc('d.diag_tb_case_no')
            ->get();

        $pdf = Pdf::loadView('pdf.barangay-cases-report', compact('brgyCases', 'barangay', 'startDate', 'endDate'))
            ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $fontMetrics = $pdf->getDomPDF()->getFontMetrics();
        $font = $fontMetrics->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Barangay Cases Report.pdf');
    }


    public function intensiveTreatmentPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Subquery: get latest diagnosis ID per patient
        $latestDiagnosis = DB::table('tbl_diagnosis as d1')
            ->select('d1.patient_id', DB::raw('MAX(d1.id) as latest_diag_id'))
            ->whereIn('d1.id', function($query) {
                $query->select(DB::raw('MAX(d2.id)'))
                    ->from('tbl_diagnosis as d2')
                    ->whereColumn('d2.patient_id', 'd1.patient_id')
                    ->groupBy('d2.patient_id');
            })
            ->groupBy('d1.patient_id');

        // Subquery: get latest prescribed drug ID per patient (4FDC only)
        $latestDrug = DB::table('tbl_prescribed_drugs')
            ->select(
                'patient_id',
                DB::raw('MAX(id) as latest_drug_id')
            )
            ->where('drug_name', '4FDC')
            ->groupBy('patient_id');

        // Subquery: get latest adherence ID per patient
        $latestAdherence = DB::table('tbl_adherences')
            ->select(
                'patient_id',
                DB::raw('MAX(id) as latest_adherence_id')
            )
            ->groupBy('patient_id');

        // Subquery: get latest treatment outcome ID per patient
        $latestOutcome = DB::table('tbl_treatment_outcomes')
            ->select(
                'patient_id',
                DB::raw('MAX(id) as latest_outcome_id')
            )
            ->groupBy('patient_id');

        $query = DB::table('tbl_patients as p')
            ->joinSub($latestDiagnosis, 'ld', function ($join) {
                $join->on('p.id', '=', 'ld.patient_id');
            })
            ->join('tbl_diagnosis as d', 'd.id', '=', 'ld.latest_diag_id')
            ->joinSub($latestDrug, 'lpd', function ($join) {
                $join->on('p.id', '=', 'lpd.patient_id');
            })
            ->join('tbl_prescribed_drugs as pd', 'pd.id', '=', 'lpd.latest_drug_id')
            ->joinSub($latestAdherence, 'la', function ($join) {
                $join->on('p.id', '=', 'la.patient_id');
            })
            ->join('tbl_adherences as a', 'a.id', '=', 'la.latest_adherence_id')
            ->leftJoinSub($latestOutcome, 'lo', function ($join) {
                $join->on('p.id', '=', 'lo.patient_id');
            })
            ->leftJoin('tbl_treatment_outcomes as t', 't.id', '=', 'lo.latest_outcome_id')
            ->select(
                'p.pat_full_name',
                'p.pat_sex',
                'pd.drug_name',
                'pd.drug_no_of_tablets',
                'pd.drug_strength',
                'pd.drug_unit',
                'a.pha_intensive_start',
                'a.pha_intensive_end',
                't.out_outcome as outcome',
                DB::raw("
                    CASE 
                        WHEN CURDATE() > a.pha_intensive_end 
                            THEN 'Completed'
                        ELSE DATEDIFF(CURDATE(), a.pha_intensive_start) + 1
                    END as treatment_day
                ")
            )
            ->where(function($query) {
                $query->whereNull('t.out_outcome')
                    ->orWhere('t.out_outcome', 'Ongoing');
            });

        if ($startDate) {
            $query->whereDate('a.pha_intensive_start', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('a.pha_intensive_end', '<=', $endDate);
        }

        $patients = $query->orderBy('a.pha_intensive_start', 'desc')->get();

        $pdf = Pdf::loadView('pdf.intensive-treatment-report', ['intensive' => $patients])
            ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Intensive Treatment Report.pdf'); 
    }

    public function maintenanceTreatmentPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Subquery: get latest diagnosis ID per patient
        $latestDiagnosis = DB::table('tbl_diagnosis as d1')
            ->select('d1.patient_id', DB::raw('MAX(d1.id) as latest_diag_id'))
            ->whereIn('d1.id', function($query) {
                $query->select(DB::raw('MAX(d2.id)'))
                    ->from('tbl_diagnosis as d2')
                    ->whereColumn('d2.patient_id', 'd1.patient_id')
                    ->groupBy('d2.patient_id');
            })
            ->groupBy('d1.patient_id');

        // Subquery: get latest prescribed drug ID per patient (2FDC only)
        $latestDrug = DB::table('tbl_prescribed_drugs')
            ->select(
                'patient_id',
                DB::raw('MAX(id) as latest_drug_id')
            )
            ->where('drug_con_name', '2FDC')
            ->groupBy('patient_id');

        // Subquery: get latest adherence ID per patient
        $latestAdherence = DB::table('tbl_adherences')
            ->select(
                'patient_id',
                DB::raw('MAX(id) as latest_adherence_id')
            )
            ->groupBy('patient_id');

        // Subquery: get latest treatment outcome ID per patient
        $latestOutcome = DB::table('tbl_treatment_outcomes')
            ->select(
                'patient_id',
                DB::raw('MAX(id) as latest_outcome_id')
            )
            ->groupBy('patient_id');

        $query = DB::table('tbl_patients as p')
            ->joinSub($latestDiagnosis, 'ld', function ($join) {
                $join->on('p.id', '=', 'ld.patient_id');
            })
            ->join('tbl_diagnosis as d', 'd.id', '=', 'ld.latest_diag_id')
            ->joinSub($latestDrug, 'lpd', function ($join) {
                $join->on('p.id', '=', 'lpd.patient_id');
            })
            ->join('tbl_prescribed_drugs as pd', 'pd.id', '=', 'lpd.latest_drug_id')
            ->joinSub($latestAdherence, 'la', function ($join) {
                $join->on('p.id', '=', 'la.patient_id');
            })
            ->join('tbl_adherences as a', 'a.id', '=', 'la.latest_adherence_id')
            ->leftJoinSub($latestOutcome, 'lo', function ($join) {
                $join->on('p.id', '=', 'lo.patient_id');
            })
            ->leftJoin('tbl_treatment_outcomes as t', 't.id', '=', 'lo.latest_outcome_id')
            ->select(
                'p.pat_full_name',
                'p.pat_sex',
                'pd.drug_con_name',
                'pd.drug_con_no_of_tablets',
                'pd.drug_con_strength',
                'pd.drug_con_unit',
                'a.pha_continuation_start',
                'a.pha_continuation_end',
                't.out_outcome as outcome',
                DB::raw("
                    CASE 
                        WHEN CURDATE() > a.pha_continuation_end 
                            THEN 'Completed'
                        ELSE DATEDIFF(CURDATE(), a.pha_continuation_start) + 1
                    END as treatment_day
                ")
            )
            ->where(function($query) {
                $query->whereNull('t.out_outcome')
                    ->orWhere('t.out_outcome', 'Ongoing');
            });

        if ($startDate) {
            $query->whereDate('a.pha_continuation_start', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('a.pha_continuation_end', '<=', $endDate);
        }

        $patients = $query->orderBy('a.pha_continuation_start', 'desc')->get();

        $pdf = Pdf::loadView('pdf.maintenance-treatment-report', ['maintenanceTreatment' => $patients])
            ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Maintenance Treatment Report.pdf');
    }

    public function underagePDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->leftJoin('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->select(
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_tb_case_no',
                'd.diag_diagnosis_date',
                't.out_outcome as out_outcome'
            )
            ->whereRaw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) < 18');

             if ($startDate) {
                $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
            }

            $patients = $query->orderBy('d.diag_tb_case_no', 'desc')->get();

        $pdf = Pdf::loadView('pdf.underage-report', ['underage' => $patients])
            ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Underage Patients Report.pdf');
    }

    public function sputumMonitoringPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = DB::table('tbl_patients as p')
            ->join('tbl_sputum_monitorings as s', 'p.id', '=', 's.patient_id')
            ->select(
                'p.pat_full_name',
                's.sput_date_collected',
                's.sput_smear_result',
                's.sput_xpert_result'
            );

        // Apply date range filters if provided
        if (!empty($startDate)) {
            $query->whereDate('s.sput_date_collected', '>=', $startDate);
        }

        if (!empty($endDate)) {
            $query->whereDate('s.sput_date_collected', '<=', $endDate);
        }

        // Fetch sputum records
        $patients = $query->orderBy('p.pat_full_name')
                        ->orderByDesc('s.sput_date_collected')
                        ->get();

        // Generate PDF
        $pdf = Pdf::loadView('pdf.sputum-monitoring-report', [
                'sputum' => $patients
            ])
            ->setPaper('A4', 'landscape');

        // Add page numbers
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Sputum Monitoring Report.pdf');
    }



    public function curedPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Subquery: get latest diagnosis ID per patient
        $latestDiagnosis = DB::table('tbl_diagnosis as d1')
            ->select('d1.patient_id', DB::raw('MAX(d1.id) as latest_diag_id'))
            ->whereIn('d1.id', function($query) {
                $query->select(DB::raw('MAX(d2.id)'))
                    ->from('tbl_diagnosis as d2')
                    ->whereColumn('d2.patient_id', 'd1.patient_id')
                    ->groupBy('d2.patient_id');
            })
            ->groupBy('d1.patient_id');

        // Subquery: get latest treatment outcome ID per patient
        $latestOutcome = DB::table('tbl_treatment_outcomes')
            ->select(
                'patient_id',
                DB::raw('MAX(id) as latest_outcome_id')
            )
            ->groupBy('patient_id');

        // Subquery: get latest treatment regimen ID per patient
        $latestRegimen = DB::table('tbl_treatment_regimens')
            ->select(
                'patient_id',
                DB::raw('MAX(id) as latest_regimen_id')
            )
            ->groupBy('patient_id');

        $query = DB::table('tbl_patients as p')
            ->joinSub($latestDiagnosis, 'ld', function ($join) {
                $join->on('p.id', '=', 'ld.patient_id');
            })
            ->join('tbl_diagnosis as d', 'd.id', '=', 'ld.latest_diag_id')
            ->joinSub($latestOutcome, 'lo', function ($join) {
                $join->on('p.id', '=', 'lo.patient_id');
            })
            ->join('tbl_treatment_outcomes as t', 't.id', '=', 'lo.latest_outcome_id')
            ->joinSub($latestRegimen, 'lr', function ($join) {
                $join->on('p.id', '=', 'lr.patient_id');
            })
            ->join('tbl_treatment_regimens as r', 'r.id', '=', 'lr.latest_regimen_id')
            ->select(
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_tb_case_no',
                'r.reg_start_date',
                't.out_date as outcome_date',
                't.out_outcome as outcome'
            )
            ->where('t.out_outcome', 'Cured');
            
        if ($startDate) {
            $query->whereDate('r.reg_start_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('r.reg_start_date', '<=', $endDate);
        }

        $patients = $query
            ->orderBy('t.out_date', 'DESC')
            ->orderByRaw("STR_TO_DATE(SUBSTRING_INDEX(d.diag_tb_case_no, '-', 1), '%Y') DESC")
            ->orderByRaw("CAST(SUBSTRING_INDEX(d.diag_tb_case_no, '-', -1) AS UNSIGNED) DESC")
            ->get();

        $pdf = Pdf::loadView('pdf.cured-report', ['cured' => $patients])
            ->setPaper('A4', 'landscape');
        
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Cured Patients Report.pdf'); 
    }

    public function treatmentCompletedPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->join('tbl_treatment_regimens as r', 'p.id', '=', 'r.patient_id')
            ->select(
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_tb_case_no',
                'r.reg_start_date',
                't.out_date as outcome_date',
                't.out_reason',
                't.out_outcome as outcome'
            )
            ->where('t.out_outcome', 'Treatment Completed');

            if ($startDate) {
                $query->whereDate('r.reg_start_date', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('r.reg_start_date', '<=', $endDate);
            }

            $patients = $query->orderBy('d.diag_tb_case_no', 'desc')->get();

        $pdf = Pdf::loadView('pdf.treatment-completed-report', ['treatmentCompleted' => $patients])
        ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Treatment Completed Report.pdf'); 
    }

    public function lostToFollowUpPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->select(
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_tb_case_no',
                't.out_date as outcome_date',
                't.out_reason',
                't.out_outcome as outcome'
            )
            ->where('t.out_outcome', 'Lost to follow-up');

            if ($startDate) {
                $query->whereDate('t.out_date', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('t.out_date', '<=', $endDate);
            }

            $patients = $query->orderBy('d.diag_tb_case_no', 'desc')->get();

        $pdf = Pdf::loadView('pdf.lost-to-follow-up-report', ['lostToFollowUp' => $patients])
        ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Lost to Follow Up Report.pdf');
    }

    public function expiredPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_treatment_regimens as r', 'p.id', '=', 'r.patient_id')
            ->join('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->select(
                'p.id',
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_tb_case_no',
                'r.reg_start_date',
                't.out_date as outcome_date',
                't.out_reason',
                't.out_outcome as outcome'
            )
            ->where('t.out_outcome', 'Died');
            
            if ($startDate) {
                $query->whereDate('t.out_date', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('t.out_date', '<=', $endDate);
            }

            $patients = $query->orderBy('d.diag_tb_case_no', 'desc')->get();

        $pdf = Pdf::loadView('pdf.expired-report', ['expired' => $patients])
        ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Expired Patients Report.pdf');
    }

    public function brgyCasesNotificationPDF()
    {
        $brgyCasesNotification = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->leftJoin('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->join('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->select(
                'p.pat_permanent_address as barangay',

                // New cases only kung Registration Group = "New"
                DB::raw('SUM(CASE WHEN c.clas_registration_group = "New" THEN 1 ELSE 0 END) as new_cases'),

                // Relapse cases
                DB::raw('SUM(CASE WHEN c.clas_registration_group = "Relapse" THEN 1 ELSE 0 END) as relapse'),

                // Ongoing = lahat ng diagnosis - (cured+completed+failed+died)
                DB::raw('
                    COUNT(d.id) 
                    - SUM(CASE WHEN t.out_outcome IN ("Cured","Treatment Completed","Failed","Died") THEN 1 ELSE 0 END)
                    as ongoing_cases
                '),

                DB::raw("SUM(CASE WHEN t.out_outcome = 'Cured' THEN 1 ELSE 0 END) as cured"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Treatment Completed' THEN 1 ELSE 0 END) as completed"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Lost to Follow-Up' THEN 1 ELSE 0 END) as ltfu"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Died' THEN 1 ELSE 0 END) as died"),

                // Total = lahat ng pasyente sa barangay
                DB::raw('COUNT(DISTINCT p.id) as total')
            )
            ->groupBy('p.pat_permanent_address')
            ->orderBy('barangay')
            ->get();

        $pdf = Pdf::loadView('pdf.barangay-cases-notification-report', compact('brgyCasesNotification'))
        ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $w = $canvas->get_width();
        $h = $canvas->get_height();

        // ✅ Get font using font metrics (this works in most Dompdf versions)
        $fontMetrics = $pdf->getDomPDF()->getFontMetrics();
        $font = $fontMetrics->getFont('helvetica', 'normal'); // 'times' is equivalent to Times New Roman

        // ✅ Page number at upper right corner
        $canvas->page_text(
            $w - 50,             // adjust X position
            30,                   // Y position (top)
            "{PAGE_NUM}",
            $font,                // formal font
            11,                   // font size
            [0, 0, 0]             // black text
        );

        return $pdf->stream('Barangay Cases Notification Report.pdf'); 
    }

    public function quarterlyCasesNotificationPDF()
    {
        $quarterlyCasesNotification = DB::table('tbl_diagnosis as d')
            ->join('tbl_patients as p', 'd.patient_id', '=', 'p.id')
            ->leftJoin('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->select(
                DB::raw('QUARTER(d.diag_diagnosis_date) as quarter'),
                DB::raw('YEAR(d.diag_diagnosis_date) as year'),

                // New cases = lahat ng diagnosis na may reg_group = New
                DB::raw('SUM(CASE WHEN c.clas_registration_group = "New" THEN 1 ELSE 0 END) as new_cases'),

                // Relapse count
                DB::raw('SUM(CASE WHEN c.clas_registration_group = "Relapse" THEN 1 ELSE 0 END) as relapse'),

                // Total = lahat ng diagnosis (hindi distinct para tama per quarter)
                DB::raw('COUNT(d.id) as total')
            )
            ->groupBy('year', 'quarter')
            ->orderBy('year')
            ->orderBy('quarter')
            ->get();

        $pdf = Pdf::loadView('pdf.quarterly-cases-notification-report', compact('quarterlyCasesNotification'))
        ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $w = $canvas->get_width();
        $h = $canvas->get_height();

        // ✅ Get font using font metrics (this works in most Dompdf versions)
        $fontMetrics = $pdf->getDomPDF()->getFontMetrics();
        $font = $fontMetrics->getFont('helvetica', 'normal'); // 'times' is equivalent to Times New Roman

        // ✅ Page number at upper right corner
        $canvas->page_text(
            $w - 50,             // adjust X position
            30,                   // Y position (top)
            "{PAGE_NUM}",
            $font,                // formal font
            11,                   // font size
            [0, 0, 0]             // black text
        );

        return $pdf->stream('Quarterly Cases Notification Report.pdf');
    }

    public function quarterlyTBClassificationPDF()
    {
        $quarterlyTBClassification = DB::table('tbl_diagnosis as d')
            ->join('tbl_patients as p', 'd.patient_id', '=', 'p.id')
            ->join('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->select(
                DB::raw('YEAR(d.diag_diagnosis_date) as year'),
                DB::raw('QUARTER(d.diag_diagnosis_date) as quarter'),

                // bilang ng bacteriologically-confirmed
                DB::raw("SUM(CASE WHEN c.clas_bacteriological_status = 'Bacteriologically-confirmed TB' THEN 1 ELSE 0 END) as bacteriological"),

                // bilang ng clinically-diagnosed
                DB::raw("SUM(CASE WHEN c.clas_bacteriological_status = 'Clinically-diagnosed TB' THEN 1 ELSE 0 END) as clinical"),

                // total = lahat ng diagnosis
                DB::raw('COUNT(d.id) as total'),

            )
            ->groupBy('year', 'quarter')
            ->orderBy('year')
            ->orderBy('quarter')
            ->get();

        $pdf = Pdf::loadView('pdf.quarterly-tb-classification-report', compact('quarterlyTBClassification'))
        ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $w = $canvas->get_width();
        $h = $canvas->get_height();

        // ✅ Get font using font metrics (this works in most Dompdf versions)
        $fontMetrics = $pdf->getDomPDF()->getFontMetrics();
        $font = $fontMetrics->getFont('helvetica', 'normal'); // 'times' is equivalent to Times New Roman

        // ✅ Page number at upper right corner
        $canvas->page_text(
            $w - 50,             // adjust X position
            30,                   // Y position (top)
            "{PAGE_NUM}",
            $font,                // formal font
            11,                   // font size
            [0, 0, 0]             // black text
        );

        return $pdf->stream('Quarterly TB Classification Report.pdf');
    }

    public function quarterlyAnatomicalSitePDF()
    {
        $quarterlyAnatomicalSite = DB::table('tbl_diagnosis as d')
            ->join('tbl_patients as p', 'd.patient_id', '=', 'p.id')
            ->join('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->select(
                DB::raw('YEAR(d.diag_diagnosis_date) as year'),
                DB::raw('QUARTER(d.diag_diagnosis_date) as quarter'),

                // bilang ng bacteriologically-confirmed
                DB::raw("SUM(CASE WHEN c.clas_anatomical_site = 'Pulmonary' THEN 1 ELSE 0 END) as pulmonary"),

                // bilang ng clinically-diagnosed
                DB::raw("SUM(CASE WHEN c.clas_anatomical_site = 'Extra-pulmonary' THEN 1 ELSE 0 END) as extra"),

                // total = lahat ng diagnosis
                DB::raw('COUNT(d.id) as total'),

            )
            ->groupBy('year', 'quarter')
            ->orderBy('year')
            ->orderBy('quarter')
            ->get();

        $pdf = Pdf::loadView('pdf.quarterly-anatomical-site-report', compact('quarterlyAnatomicalSite'))
        ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $w = $canvas->get_width();
        $h = $canvas->get_height();

        // ✅ Get font using font metrics (this works in most Dompdf versions)
        $fontMetrics = $pdf->getDomPDF()->getFontMetrics();
        $font = $fontMetrics->getFont('helvetica', 'normal'); // 'times' is equivalent to Times New Roman

        // ✅ Page number at upper right corner
        $canvas->page_text(
            $w - 50,             // adjust X position
            30,                   // Y position (top)
            "{PAGE_NUM}",
            $font,                // formal font
            11,                   // font size
            [0, 0, 0]             // black text
        );

        return $pdf->stream('Quarterly Anatomical Site Report.pdf');
    }

    public function quarterlyTreatmentOutcomePDF()
    {
        $quarterlyOutcome = DB::table('tbl_treatment_outcomes as t')
            ->join('tbl_patients as p', 't.patient_id', '=', 'p.id')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->select(
                DB::raw('YEAR(t.out_date) as year'),
                DB::raw('QUARTER(t.out_date) as quarter'),

                DB::raw("SUM(CASE WHEN t.out_outcome = 'Cured' THEN 1 ELSE 0 END) as cured"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Treatment Completed' THEN 1 ELSE 0 END) as completed"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Lost to Follow-up' THEN 1 ELSE 0 END) as ltfu"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Died' THEN 1 ELSE 0 END) as died"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Failed' THEN 1 ELSE 0 END) as failed"),

                // FIX: total = only patients with final outcomes (exclude NULL/ongoing)
                DB::raw("SUM(CASE WHEN t.out_outcome IN ('Cured','Treatment Completed','Lost to Follow-up','Died','Failed') THEN 1 ELSE 0 END) as total"),

                // TSR = (Cured + Completed) / Total * 100
                DB::raw('ROUND(
                    ( (SUM(CASE WHEN t.out_outcome = "Cured" THEN 1 ELSE 0 END) 
                    + SUM(CASE WHEN t.out_outcome = "Treatment Completed" THEN 1 ELSE 0 END)) 
                    / NULLIF(SUM(CASE WHEN t.out_outcome IN ("Cured","Treatment Completed","Lost to Follow-up","Died","Failed") THEN 1 ELSE 0 END),0) 
                    * 100), 2
                ) as tsr')
            )
            ->groupBy('year', 'quarter')
            ->havingRaw('total > 0')
            ->orderBy('year')
            ->orderBy('quarter')
            ->get();
            
        $pdf = Pdf::loadView('pdf.quarterly-treatment-outcome-report', compact('quarterlyOutcome'))
        ->setPaper('A4', 'landscape');

        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        $w = $canvas->get_width();
        $h = $canvas->get_height();

        // ✅ Get font using font metrics (this works in most Dompdf versions)
        $fontMetrics = $pdf->getDomPDF()->getFontMetrics();
        $font = $fontMetrics->getFont('helvetica', 'normal'); // 'times' is equivalent to Times New Roman

        // ✅ Page number at upper right corner
        $canvas->page_text(
            $w - 50,             // adjust X position
            30,                   // Y position (top)
            "{PAGE_NUM}",
            $font,                // formal font
            11,                   // font size
            [0, 0, 0]             // black text
        );

        return $pdf->stream('Quarterly Treatment Outcome Report.pdf');
    }

    public function adverseEventPDF(Request $request)
    {
        ini_set('memory_limit', '512M');
        set_time_limit(300);

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = DB::table('tbl_patients as p')
            ->join('tbl_adverse_events as a', 'p.id', '=', 'a.patient_id')
            ->select(
                'p.pat_full_name',
                'a.adv_ae_date',
                'a.adv_specific_ae',
                'a.adv_fda_reported_date'
            );

        // Apply date range filters if provided
        if (!empty($startDate)) {
            $query->whereDate('a.adv_ae_date', '>=', $startDate);
        }

        if (!empty($endDate)) {
            $query->whereDate('a.adv_ae_date', '<=', $endDate);
        }

        // Fetch Adverse Event records
        $patients = $query->orderBy('p.pat_full_name')
                        ->orderByDesc('a.adv_ae_date')
                        ->get();

        // Generate PDF
        $pdf = Pdf::loadView('pdf.adverse-event-report', [
                'adverseEvent' => $patients
            ])
            ->setPaper('A4', 'landscape');

        // Add page numbers
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();
        $w = $canvas->get_width();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('helvetica', 'normal');
        $canvas->page_text($w - 50, 30, "{PAGE_NUM}", $font, 11, [0, 0, 0]);

        return $pdf->stream('Adverse Event Report.pdf');
    }
    

    /**
     * Generate medication adherence report
     */
    public function generateReport(Request $request)
    {
        $validated = $request->validate([
            'patientName' => 'required|string',
            'patientId' => 'required',
            'username' => 'nullable|string',
            'reportDate' => 'required|string',
            'currentMonth' => 'required|string',
            'monthlyTaken' => 'required|integer',
            'monthlyMissed' => 'required|integer',
            'monthlyRate' => 'required|integer',
            'totalTaken' => 'required|integer',
            'totalMissed' => 'required|integer',
            'totalRate' => 'required|integer',
        ]);

        // Prepare data for PDF
        $data = [
            'patientName' => $validated['patientName'],
            'patientId' => $validated['patientId'],
            'username' => $validated['username'] ?? 'N/A',
            'reportDate' => $validated['reportDate'],
            'currentMonth' => $validated['currentMonth'],
            'monthlyTaken' => $validated['monthlyTaken'],
            'monthlyMissed' => $validated['monthlyMissed'],
            'monthlyRate' => $validated['monthlyRate'],
            'totalTaken' => $validated['totalTaken'],
            'totalMissed' => $validated['totalMissed'],
            'totalRate' => $validated['totalRate'],
        ];

        // Generate PDF
        $pdf = Pdf::loadView('reports.adherence-report', $data);
        
        // Set paper size and orientation
        $pdf->setPaper('A4', 'portrait');

        // Return PDF download
        return $pdf->download('adherence_report_' . date('Y-m-d') . '.pdf');
    }

}
