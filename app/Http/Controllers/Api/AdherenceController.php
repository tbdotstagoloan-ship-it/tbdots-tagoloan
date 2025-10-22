<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class AdherenceController extends Controller
{
    public function getAdherence($username)
    {
        // Get all "taken" dates from tbl_medication_logs
        $taken = DB::table('tbl_medication_logs')
            ->where('username', $username)
            ->pluck('date');

        // Get all "missed" dates from tbl_missed_logs
        $missed = DB::table('tbl_missed_logs')
            ->where('username', $username)
            ->pluck('date');

        // Return JSON
        return response()->json([
            'taken' => $taken,
            'missed' => $missed,
        ]);
    }
}
