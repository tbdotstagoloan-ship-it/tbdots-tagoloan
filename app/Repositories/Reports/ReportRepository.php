<?php

namespace App\Repositories\Reports;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReportRepository implements ReportRepositoryInterface
{
    public function newlyDiagnosed(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
            ->where('t.clas_registration_group', 'new')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->paginate($perPage);
    }

    public function relapse(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
            ->paginate($perPage);
    }

    public function bacteriologicallyConfirmed(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
            ->paginate($perPage);
    }

    public function clinicallyDiagnosed(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
            ->paginate($perPage);
    }

    public function pulmonary(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
            ->paginate($perPage);
    }

    public function extraPulmonary(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
            ->paginate($perPage);
    }

    public function ongoingTreatment(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
            ->paginate($perPage);
    }

    public function barangayCases(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
            ->paginate($perPage);
    }

    public function intensiveTreatment(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
                        WHEN CURDATE() > a.pha_intensive_end THEN 'Completed'
                        ELSE DATEDIFF(CURDATE(), a.pha_intensive_start) + 1
                    END as treatment_day
                ")
            )
            ->where('pd.drug_name', '4FDC')
            ->where(function($q){
                $q->whereNull('t.out_outcome')->orWhere('t.out_outcome', 'Ongoing');
            })
            ->orderBy('a.pha_intensive_start', 'desc')
            ->paginate($perPage);
    }

    public function maintenanceTreatment(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_prescribed_drugs as pd', 'p.id', '=', 'pd.patient_id')
            ->join('tbl_adherences as a', 'p.id', '=', 'a.patient_id')
            ->leftJoin('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->select(
                'p.pat_full_name',
                'p.pat_sex',
                'pd.drug_con_name',
                'pd.drug_con_strength',
                'pd.drug_con_unit',
                'a.pha_continuation_start',
                'a.pha_continuation_end',
                't.out_outcome as outcome',
                DB::raw("
                    CASE 
                        WHEN CURDATE() > a.pha_continuation_end THEN 'Completed'
                        ELSE DATEDIFF(CURDATE(), a.pha_continuation_start) + 1
                    END as treatment_day
                ")
            )
            ->where('pd.drug_con_name', '2FDC')
            ->where(function($q){
                $q->whereNull('t.out_outcome')->orWhere('t.out_outcome', 'Ongoing');
            })
            ->orderBy('a.pha_continuation_start', 'desc')
            ->paginate($perPage);
    }

    public function underage(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
            ->paginate($perPage);
    }

    public function sputumMonitoring(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
            ->join('tbl_sputum_monitorings as s', 'p.id', '=', 's.patient_id')
            ->select(
                'p.pat_full_name',
                's.sput_date_collected',
                's.sput_smear_result',
                's.sput_xpert_result'
            )
            ->where('s.sput_xpert_result', 'Positive')
            ->orderBy('p.pat_full_name')
            ->orderBy('s.sput_date_collected', 'desc')
            ->paginate($perPage);
    }

    public function cured(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
            ->paginate($perPage);
    }

    public function treatmentCompleted(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
            ->paginate($perPage);
    }

    public function lostToFollowUp(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
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
            ->where('t.out_outcome', 'Lost to Follow-Up')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->paginate($perPage);
    }

    public function expired(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->join('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->select(
                'p.id',
                'p.pat_full_name',
                DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
                'p.pat_sex',
                'p.pat_permanent_address as barangay',
                'd.diag_tb_case_no',
                't.out_date as outcome_date',
                't.out_reason'
            )
            ->where('t.out_outcome', 'Died')
            ->orderBy('d.diag_tb_case_no', 'desc')
            ->paginate($perPage);
    }

    public function brgyCasesNotification(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_patients as p')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->leftJoin('tbl_treatment_outcomes as t', 'p.id', '=', 't.patient_id')
            ->join('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->select(
                'p.pat_permanent_address as barangay',
                DB::raw('SUM(CASE WHEN c.clas_registration_group = "New" THEN 1 ELSE 0 END) as new_cases'),
                DB::raw('SUM(CASE WHEN c.clas_registration_group = "Relapse" THEN 1 ELSE 0 END) as relapse'),
                DB::raw('
                    COUNT(d.id) 
                    - SUM(CASE WHEN t.out_outcome IN ("Cured","Treatment Completed","Died") THEN 1 ELSE 0 END)
                    as ongoing_cases
                '),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Cured' THEN 1 ELSE 0 END) as cured"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Treatment Completed' THEN 1 ELSE 0 END) as completed"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Lost to Follow-Up' THEN 1 ELSE 0 END) as ltfu"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Died' THEN 1 ELSE 0 END) as died"),
                DB::raw('COUNT(DISTINCT p.id) as total')
            )
            ->groupBy('p.pat_permanent_address')
            ->orderBy('barangay')
            ->paginate($perPage);
    }

    public function quarterlyCasesNotification(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_diagnosis as d')
            ->join('tbl_patients as p', 'd.patient_id', '=', 'p.id')
            ->leftJoin('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->select(
                DB::raw('QUARTER(d.diag_diagnosis_date) as quarter'),
                DB::raw('YEAR(d.diag_diagnosis_date) as year'),
                DB::raw('SUM(CASE WHEN c.clas_registration_group = "New" THEN 1 ELSE 0 END) as new_cases'),
                DB::raw('SUM(CASE WHEN c.clas_registration_group = "Relapse" THEN 1 ELSE 0 END) as relapse'),
                DB::raw('COUNT(d.id) as total')
            )
            ->groupBy('year', 'quarter')
            ->orderBy('year')
            ->orderBy('quarter')
            ->paginate($perPage);
    }

    public function quarterlyTBClassification(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_diagnosis as d')
            ->join('tbl_patients as p', 'd.patient_id', '=', 'p.id')
            ->join('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->select(
                DB::raw('YEAR(d.diag_diagnosis_date) as year'),
                DB::raw('QUARTER(d.diag_diagnosis_date) as quarter'),
                DB::raw("SUM(CASE WHEN c.clas_bacteriological_status = 'Bacteriologically-confirmed TB' THEN 1 ELSE 0 END) as bacteriological"),
                DB::raw("SUM(CASE WHEN c.clas_bacteriological_status = 'Clinically-diagnosed TB' THEN 1 ELSE 0 END) as clinical"),
                DB::raw('COUNT(d.id) as total')
            )
            ->groupBy('year', 'quarter')
            ->orderBy('year')
            ->orderBy('quarter')
            ->paginate($perPage);
    }

    public function quarterlyAnatomicalSite(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_diagnosis as d')
            ->join('tbl_patients as p', 'd.patient_id', '=', 'p.id')
            ->join('tbl_tb_classifications as c', 'p.id', '=', 'c.patient_id')
            ->select(
                DB::raw('YEAR(d.diag_diagnosis_date) as year'),
                DB::raw('QUARTER(d.diag_diagnosis_date) as quarter'),
                DB::raw("SUM(CASE WHEN c.clas_anatomical_site = 'Pulmonary' THEN 1 ELSE 0 END) as pulmonary"),
                DB::raw("SUM(CASE WHEN c.clas_anatomical_site = 'Extra-pulmonary' THEN 1 ELSE 0 END) as extra"),
                DB::raw('COUNT(d.id) as total')
            )
            ->groupBy('year', 'quarter')
            ->orderBy('year')
            ->orderBy('quarter')
            ->paginate($perPage);
    }

    public function quarterlyTreatmentOutcome(int $perPage = 10): LengthAwarePaginator
    {
        return DB::table('tbl_treatment_outcomes as t')
            ->join('tbl_patients as p', 't.patient_id', '=', 'p.id')
            ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
            ->select(
                DB::raw('YEAR(t.out_date) as year'),
                DB::raw('QUARTER(t.out_date) as quarter'),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Cured' THEN 1 ELSE 0 END) as cured"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Treatment Completed' THEN 1 ELSE 0 END) as completed"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Lost to Follow-Up' THEN 1 ELSE 0 END) as ltfu"),
                DB::raw("SUM(CASE WHEN t.out_outcome = 'Died' THEN 1 ELSE 0 END) as died"),
                DB::raw("SUM(CASE WHEN t.out_outcome IN ('Cured','Treatment Completed','Lost to Follow-up','Died') THEN 1 ELSE 0 END) as total"),
                DB::raw('ROUND(((SUM(CASE WHEN t.out_outcome = "Cured" THEN 1 ELSE 0 END) 
                    + SUM(CASE WHEN t.out_outcome = "Treatment Completed" THEN 1 ELSE 0 END))
                    / NULLIF(SUM(CASE WHEN t.out_outcome IN ("Cured","Treatment Completed","Lost to Follow-Up","Died") THEN 1 ELSE 0 END),0) * 100), 2) as tsr')
            )
            ->groupBy('year', 'quarter')
            ->orderBy('year')
            ->orderBy('quarter')
            ->paginate($perPage);
    }
}
