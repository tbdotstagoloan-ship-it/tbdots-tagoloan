<?php

namespace App\Http\Controllers;

use App\Models\TBClassification;
use Illuminate\Http\Request;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PatientSummaryController extends Controller
{

    public function patientSummary($id)
    {
        // Get patient with joins
        $patient = DB::table('tbl_patients as p')
            ->leftJoin('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->leftJoin('tbl_prescribed_drugs as pd', 'p.id', '=', 'pd.patient_id')
            ->leftJoin('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->leftJoin('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->select(
                'p.id',
                'p.pat_full_name as name',
                'p.pat_date_of_birth as birth_date',
                'p.pat_age as age',
                'p.pat_sex as sex',
                'p.pat_current_address as address',
                'p.pat_current_city_mun as city',
                'p.pat_current_province as province',
                'p.pat_current_region as region',
                'p.pat_current_zip_code as zip_code',
                'p.pat_contact_number as contact',
                'd.diag_tb_case_no as tb_case_no',
                'd.diag_diagnosis_date as diagnosis_date',
                'c.clas_bacteriological_status',
                'c.clas_anatomical_site',
                'd.diag_attending_physician as physician',
                't.out_outcome as outcome',
                't.out_date as date',
                't.out_reason as reason'
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

        return $pdf->stream('Patient Summary Report' . '.pdf');
    }

    public function newlyDiagnosedPDF()
    {
        $new = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_tb_classifications as t', 'p.id', '=', 't.patient_id')
            ->select(
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_diagnosis_date',
                'd.diag_tb_case_no',
                't.clas_registration_group'
            )
            ->where('t.clas_registration_group', 'New')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.newly-diagnosed-report', compact('new'));
        return $pdf->stream('Newly Diagnosed Report.pdf');
    }

    public function relapsePDF()
    {
        $relapse = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_tb_classifications as t', 'p.id', '=', 't.patient_id')
            ->select(
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_diagnosis_date',
                'd.diag_tb_case_no',
                't.clas_registration_group'
            )
            ->where('t.clas_registration_group', 'Relapse')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.relapse-report', compact('relapse'));
        return $pdf->stream('Relapse Report.pdf');
    }

    public function bacteriologicallyConfirmedPDF()
    {
        $bacteriologicallyConfirmed = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->select(
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_tb_case_no',
                'd.diag_diagnosis_date',
                'c.clas_bacteriological_status as tb_classification'
            )
            ->where('c.clas_bacteriological_status', 'Bacteriologically-confirmed TB')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.bacteriologically-confirmed-report', compact('bacteriologicallyConfirmed'));
        return $pdf->stream('Bacteriologically-Confirmed TB Report.pdf');
    }

    public function clinicallyDiagnosedPDF()
    {
        $clinicallyDiagnosed = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->select(
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_tb_case_no',
                'd.diag_diagnosis_date',
                'c.clas_bacteriological_status as tb_classification'
            )
            ->where('c.clas_bacteriological_status', 'Clinically-diagnosed TB')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.clinically-diagnosed-report', compact('clinicallyDiagnosed'));
        return $pdf->stream('Clinically Diagnosed Report.pdf');
    }

    public function pulmonaryPDF()
    {
        $pulmonary = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->select(
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_tb_case_no',
                'd.diag_diagnosis_date',
                'c.clas_anatomical_site as anatomical_site'
            )
            ->where('c.clas_anatomical_site', 'Pulmonary')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.pulmonary-report', compact('pulmonary'));
        return $pdf->stream('Pulmonary TB Report.pdf');
    }

    public function extraPulmonaryPDF()
    {
        $extraPulmonary = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
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
            ->where('c.clas_anatomical_site', 'Extra-pulmonary')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.extra-pulmonary-report', compact('extraPulmonary'));
        return $pdf->stream('Extra Pulmonary TB Report.pdf');
    }

    public function ongoingTreatmentPDF()
    {
        $ongoingPatients = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->join('tbl_treatment_regimens as r', 'p.id', '=', 'r.patient_id')
            ->select(
                'd.diag_tb_case_no',
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'r.reg_start_date',
                't.out_outcome as outcome'
            )
            ->where('t.out_outcome', 'Ongoing')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.ongoing-treatment-report', compact('ongoingPatients'));
        return $pdf->stream('Ongoing Treatment Report.pdf');
    }

    public function barangayCasesPDF()
    {
        $brgyCases = DB::table('tbl_patients as p')
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
            )
            ->orderBy('barangay')
            ->orderBy('d.diag_tb_case_no','desc')
            ->get();

        $pdf = Pdf::loadView('pdf.barangay-cases-report', compact('brgyCases'));
        return $pdf->stream('Barangay Cases Report.pdf');
    }

    public function intensiveTreatmentPDF()
    {
        $intensive = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_prescribed_drugs as pd', 'p.id', '=', 'pd.patient_id')
            ->join('tbl_adherences as a', 'p.id', '=', 'a.patient_id')
            ->leftJoin('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->select(
                'p.pat_full_name',
                'p.pat_sex',
                'pd.drug_name',
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
            ->where('pd.drug_name', '4FDC')   // Intensive = 4FDC
            ->where(function($query) {
                $query->whereNull('t.out_outcome')
                    ->orWhere('t.out_outcome', 'Ongoing'); // only ongoing patients
            })
            // ->orderBy('p.pat_full_name')
            ->orderBy('a.pha_intensive_start', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.intensive-treatment-report', compact('intensive'));
        return $pdf->stream('Intensive Treatment Report.pdf'); 
    }

    public function maintenanceTreatmentPDF()
    {
        $maintenanceTreatment = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_prescribed_drugs as pd', 'p.id', '=', 'pd.patient_id')
            ->join('tbl_adherences as a', 'p.id', '=', 'a.patient_id')
            ->leftJoin('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->select(
                'p.pat_full_name',
                'p.pat_sex',
                'pd.drug_name',
                'pd.drug_strength',
                'pd.drug_unit',
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
            ->where('pd.drug_name', '2FDC')   // Maintenance = 2FDC
            ->where(function($query) {
                $query->whereNull('t.out_outcome')
                    ->orWhere('t.out_outcome', 'Ongoing'); // only ongoing patients
            })
            // ->orderBy('p.pat_full_name')
            ->orderBy('a.pha_continuation_start')
            ->get();

        $pdf = Pdf::loadView('pdf.maintenance-treatment-report', compact('maintenanceTreatment'));
        return $pdf->stream('Maintenance Treatment Report.pdf');

    }

    public function underagePDF()
    {
        $underage = DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->leftJoin('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->select(
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_tb_case_no',
                'd.diag_diagnosis_date',
                't.out_outcome as outcome'
            )
            ->whereRaw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) < 18')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.underage-report', compact('underage'));
        return $pdf->stream('Underage Patients Report.pdf');
    }

    public function sputumMonitoringPDF()
    {
        $sputum = DB::table('tbl_patients as p')
            ->join('tbl_sputum_monitorings as s', 'p.id', '=', 's.patient_id')
            ->select(
                'p.pat_full_name',
                's.sput_date_collected',
                's.sput_smear_result',
                's.sput_xpert_result'
            )
            ->where('s.sput_xpert_result', 'Positive')
            ->orderBy('p.pat_full_name')
            ->orderBy('s.sput_date_collected')
            ->get();

        $pdf = Pdf::loadView('pdf.sputum-monitoring-report', compact('sputum'));
        return $pdf->stream('Sputum Monitoring Report.pdf');
    }

    public function curedPDF()
    {
        $cured = DB::table('tbl_patients as p')
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
                't.out_outcome as outcome'
            )
            ->where('t.out_outcome', 'Cured')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.cured-report', compact('cured'));
        return $pdf->stream('Cured Patients Report.pdf'); 
    }

    public function treatmentCompletedPDF()
    {
        $treatmentCompleted = DB::table('tbl_patients as p')
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
            ->where('t.out_outcome', 'Treatment Completed')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.treatment-completed-report', compact('treatmentCompleted'));
        return $pdf->stream('Treatment Completed Report.pdf'); 
    }

    public function lostToFollowUpPDF()
    {
        $lostToFollowUp = DB::table('tbl_patients as p')
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
            ->where('t.out_outcome', 'Lost to follow-up')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.lost-to-follow-up-report', compact('lostToFollowUp'));
        return $pdf->stream('Lost to Follow Up Report.pdf');
    }

    public function expiredPDF()
    {
        $expired = DB::table('tbl_patients as p')
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
                't.out_reason'
            )
            ->where('t.out_outcome', 'Died')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->get();

        $pdf = Pdf::loadView('pdf.expired-report', compact('expired'));
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

        $pdf = Pdf::loadView('pdf.barangay-cases-notification-report', compact('brgyCasesNotification'));
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

        $pdf = Pdf::loadView('pdf.quarterly-cases-notification-report', compact('quarterlyCasesNotification'));
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

        $pdf = Pdf::loadView('pdf.quarterly-tb-classification-report', compact('quarterlyTBClassification'));
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

        $pdf = Pdf::loadView('pdf.quarterly-anatomical-site-report', compact('quarterlyAnatomicalSite'));
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
            ->orderBy('year')
            ->orderBy('quarter')
            ->get();
            
        $pdf = Pdf::loadView('pdf.quarterly-treatment-outcome-report', compact('quarterlyOutcome'));
        return $pdf->stream('Quarterly Treatment Outcome Report.pdf');
    }


    


}
