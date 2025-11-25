<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MedicationAdherence;
use App\Models\PatientAccount;

class PatientProfileController extends Controller
{
    public function getPatientDetails($username)
    {
        $account = DB::table('tbl_patient_accounts as a')
            ->join('tbl_patients as p', 'a.patient_id', '=', 'p.id')
            ->join('tbl_adherences as ad', 'a.patient_id', '=', 'ad.patient_id')
            ->join('tbl_baseline_infos as bi', 'a.patient_id', '=', 'bi.patient_id')
            ->select(
                'p.pat_full_name',
                'p.pat_contact_number',
                'bi.base_emergency_contact_name',
                'bi.base_contact_info',
                // Format dates properly
                DB::raw("DATE_FORMAT(ad.pha_intensive_start, '%Y-%m-%d') as pha_intensive_start"),
                DB::raw("DATE_FORMAT(ad.pha_intensive_end, '%Y-%m-%d') as pha_intensive_end"),
                DB::raw("DATE_FORMAT(ad.pha_continuation_start, '%Y-%m-%d') as pha_continuation_start"),
                DB::raw("DATE_FORMAT(ad.pha_continuation_end, '%Y-%m-%d') as pha_continuation_end")
            )
            ->where('a.acc_username', $username)
            ->first();

        if (!$account) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($account);
    }
}