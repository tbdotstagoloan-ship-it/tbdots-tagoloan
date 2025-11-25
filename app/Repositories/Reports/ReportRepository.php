<?php

namespace App\Repositories\Reports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ReportRepository implements ReportRepositoryInterface
{
    // public function newlyDiagnosed(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    // {
    //     $query = DB::table('tbl_tb_classifications as t')
    //         ->join('tbl_patients as p', 'p.id', '=', 't.patient_id')
    //         ->join('tbl_diagnosis as d', 'p.id', '=', 'd.patient_id')
    //         ->select(
    //             'p.pat_full_name',
    //             DB::raw('TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) as pat_age'),
    //             'p.pat_sex',
    //             'p.pat_permanent_address as barangay',
    //             'd.diag_diagnosis_date',
    //             'd.diag_tb_case_no',
    //             't.clas_registration_group'
    //         )
    //         ->where('t.clas_registration_group', 'new');


        
    //     if ($startDate) {
    //         $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
    //     }
        
    //     if ($endDate) {
    //         $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
    //     }

    //     return Cache::remember(
    //     "newly_diagnosed_{$startDate}_{$endDate}_page_" . request('page', 1),
    //     120, 
    //     fn() => $query->orderBy('d.diag_tb_case_no', 'desc')->paginate($perPage)
    // );
    // }

    public function newlyDiagnosed(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
{
    // 1️⃣ Earliest TB classification per patient (must be NEW)
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
        ->where('t1.clas_registration_group', 'new');   // Ensure FIRST = NEW only



    // 2️⃣ Get diagnosis that is closest to the new classification date
    //    (but must be BEFORE the relapse)
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
            ORDER BY d2.id ASC   -- earliest diagnosis (matching NEW phase)
            LIMIT 1
        )');



    // 3️⃣ Main query
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



    // 4️⃣ Optional date filters
    if ($startDate) {
        $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
    }
    if ($endDate) {
        $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
    }



    // 5️⃣ Cache + paginate
    return Cache::remember(
        "newly_diagnosed_{$startDate}_{$endDate}_page_" . request('page', 1),
        120,
        fn() => $query->orderBy('d.diag_diagnosis_date', 'desc')->paginate($perPage)
    );
}



    public function relapse(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
{
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

    // 2️⃣ Get diagnosis that matches the relapse period (latest per patient)
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

    // 4️⃣ Optional date filters
    if ($startDate) {
        $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
    }
    if ($endDate) {
        $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
    }

    // 5️⃣ Sort by latest case no
    return $query->orderByDesc('d.diag_tb_case_no')->paginate($perPage);
}



    public function bacteriologicallyConfirmed(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
{
    // 1️⃣ Get the LATEST classification per patient where bacteriological status = BC
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

    // 5️⃣ Sort latest first and paginate
    return $query
        ->orderByDesc('d.diag_tb_case_no')
        ->paginate($perPage);
}


    public function clinicallyDiagnosed(
    int $perPage = 10, 
    ?string $startDate = null, 
    ?string $endDate = null
): LengthAwarePaginator {

    // Subquery: get latest diagnosis per patient
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
            DB::raw("TIMESTAMPDIFF(YEAR, p.pat_date_of_birth, CURDATE()) AS pat_age"),
            'p.pat_sex',
            'p.pat_permanent_address as barangay',
            'd.diag_tb_case_no',
            'd.diag_diagnosis_date',
            'c.clas_bacteriological_status as tb_classification'
        )
        ->where('c.clas_bacteriological_status', 'Clinically-diagnosed TB');

    // Date filters on latest diagnosis date
    if ($startDate) {
        $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
    }

    if ($endDate) {
        $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
    }

    // Sort by latest date, then TB case no (YYYY-XXXXX)
    return $query
        ->orderBy('d.diag_diagnosis_date', 'DESC')
        ->orderByRaw("
            STR_TO_DATE(SUBSTRING_INDEX(d.diag_tb_case_no, '-', 1), '%Y') DESC
        ")
        ->orderByRaw("
            CAST(SUBSTRING_INDEX(d.diag_tb_case_no, '-', -1) AS UNSIGNED) DESC
        ")
        ->paginate($perPage);
}




    public function pulmonary(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    {
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

        return $query
            ->orderBy('d.diag_diagnosis_date', 'DESC')
            ->orderByRaw("STR_TO_DATE(SUBSTRING_INDEX(d.diag_tb_case_no, '-', 1), '%Y') DESC")
            ->orderByRaw("CAST(SUBSTRING_INDEX(d.diag_tb_case_no, '-', -1) AS UNSIGNED) DESC")
            ->paginate($perPage);
    }

    public function extraPulmonary(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    {
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

        return $query
            ->orderBy('d.diag_diagnosis_date', 'DESC')
            ->orderByRaw("STR_TO_DATE(SUBSTRING_INDEX(d.diag_tb_case_no, '-', 1), '%Y') DESC")
            ->orderByRaw("CAST(SUBSTRING_INDEX(d.diag_tb_case_no, '-', -1) AS UNSIGNED) DESC")
            ->paginate($perPage);
    }

    public function ongoingTreatment(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    {
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

        return $query
            ->orderBy('r.reg_start_date', 'DESC')
            ->orderByRaw("STR_TO_DATE(SUBSTRING_INDEX(d.diag_tb_case_no, '-', 1), '%Y') DESC")
            ->orderByRaw("CAST(SUBSTRING_INDEX(d.diag_tb_case_no, '-', -1) AS UNSIGNED) DESC")
            ->paginate($perPage);
    }

    public function barangayCases(
    int $perPage = 10,
    ?string $startDate = null,
    ?string $endDate = null,
    ?string $barangay = null
    ): LengthAwarePaginator {
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

        // Optional filters
        if ($startDate) {
            $query->whereDate('d.diag_diagnosis_date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('d.diag_diagnosis_date', '<=', $endDate);
        }
        if ($barangay) {
            $query->where('p.pat_permanent_address', $barangay);
        }

        return $query->orderBy('barangay')
            ->orderByDesc('d.diag_tb_case_no')
            ->paginate($perPage);
    }

    public function intensiveTreatment(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    {
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
                        WHEN CURDATE() > a.pha_intensive_end THEN 'Completed'
                        ELSE DATEDIFF(CURDATE(), a.pha_intensive_start) + 1
                    END as treatment_day
                ")
            )
            ->where(function($q){
                $q->whereNull('t.out_outcome')->orWhere('t.out_outcome', 'Ongoing');
            });

        if ($startDate) {
            $query->whereDate('a.pha_intensive_start', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('a.pha_intensive_end', '<=', $endDate);
        }

        return $query
            ->orderBy('a.pha_intensive_start', 'desc')
            ->paginate($perPage);
    }

    public function maintenanceTreatment(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    {
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
                        WHEN CURDATE() > a.pha_continuation_end THEN 'Completed'
                        ELSE DATEDIFF(CURDATE(), a.pha_continuation_start) + 1
                    END as treatment_day
                ")
            )
            ->where(function($q){
                $q->whereNull('t.out_outcome')->orWhere('t.out_outcome', 'Ongoing');
            });

        if ($startDate) {
            $query->whereDate('a.pha_continuation_start', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('a.pha_continuation_end', '<=', $endDate);
        }

        return $query
            ->orderBy('a.pha_continuation_start', 'desc')
            ->paginate($perPage);
    }

    public function underage(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    {
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

            return $query->orderBy('d.diag_tb_case_no', 'desc')
            ->paginate($perPage);
    }

    public function sputumMonitoring(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    {
        $query = DB::table('tbl_patients as p')
            ->join('tbl_sputum_monitorings as s', 'p.id', '=', 's.patient_id')
            ->select(
                'p.pat_full_name',
                's.sput_date_collected',
                's.sput_smear_result',
                's.sput_xpert_result'
            )
            ->where('s.sput_xpert_result', 'Positive');

        if ($startDate) {
            $query->whereDate('s.sput_date_collected', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('s.sput_date_collected', '<=', $endDate);
        }

        return $query->orderBy('p.pat_full_name')
            ->orderByDesc('s.sput_date_collected')
            ->paginate($perPage);
    }


    public function cured(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    {
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

        return $query
            ->orderBy('t.out_date', 'DESC')
            ->orderByRaw("STR_TO_DATE(SUBSTRING_INDEX(d.diag_tb_case_no, '-', 1), '%Y') DESC")
            ->orderByRaw("CAST(SUBSTRING_INDEX(d.diag_tb_case_no, '-', -1) AS UNSIGNED) DESC")
            ->paginate($perPage);
    }

    public function treatmentCompleted(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    {
        $query=  DB::table('tbl_patients as p')
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

            return $query->orderBy('d.diag_tb_case_no', 'desc')
            ->paginate($perPage);
    }

    public function lostToFollowUp(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    {
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
            ->where('t.out_outcome', 'Lost to Follow-Up');

            if ($startDate) {
                $query->whereDate('t.out_date', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('t.out_date', '<=', $endDate);
            }

            return $query->orderBy('d.diag_tb_case_no', 'desc')
            ->paginate($perPage);
    }

    public function expired(int $perPage = 10, ?string $startDate = null, ?string $endDate = null): LengthAwarePaginator
    {
        $query = DB::table('tbl_patients as p')
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
                't.out_reason',
                't.out_outcome as out_outcome'
            )
            ->where('t.out_outcome', 'Died');

            if ($startDate) {
                $query->whereDate('t.out_date', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('t.out_date', '<=', $endDate);
            }

            return $query->orderBy('d.diag_tb_case_no', 'desc')
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
            ->havingRaw('total > 0')
            ->orderBy('year')
            ->orderBy('quarter')
            ->paginate($perPage);
    }
}
