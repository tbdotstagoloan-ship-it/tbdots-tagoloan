<?php
// app/Http/Controllers/MedicationController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MedicationController extends Controller
{
    /**
     * Get confirmed medication logs for a user
     */
    public function getConfirmedLogs(Request $request)
    {
        $request->validate([
            'username' => 'required|string'
        ]);

        $logs = DB::table('medication_logs')
            ->where('username', $request->username)
            ->orderBy('date', 'desc')
            ->select('date')
            ->get();

        return response()->json($logs);
    }

    /**
     * Get missed medication logs for a user
     */
    public function getMissedLogs(Request $request)
    {
        $request->validate([
            'username' => 'required|string'
        ]);

        $logs = DB::table('missed_logs')
            ->where('username', $request->username)
            ->orderBy('date', 'desc')
            ->select('date')
            ->get();

        return response()->json($logs);
    }

    /**
     * Get both confirmed and missed logs (combined endpoint)
     */
    public function getCombinedLogs(Request $request)
    {
        $request->validate([
            'username' => 'required|string'
        ]);

        $confirmed = DB::table('medication_logs')
            ->where('username', $request->username)
            ->orderBy('date', 'desc')
            ->select('date')
            ->get();

        $missed = DB::table('missed_logs')
            ->where('username', $request->username)
            ->orderBy('date', 'desc')
            ->select('date')
            ->get();

        return response()->json([
            'confirmed' => $confirmed,
            'missed' => $missed
        ]);
    }

    /**
     * Insert a confirmed medication log
     */
    public function confirmMedication(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'date' => 'required|date'
        ]);

        // Check if already confirmed for this date
        $exists = DB::table('medication_logs')
            ->where('username', $request->username)
            ->whereDate('date', $request->date)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Already confirmed for this date'
            ], 409);
        }

        DB::table('medication_logs')->insert([
            'username' => $request->username,
            'date' => $request->date,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'message' => 'Medication confirmed successfully'
        ], 201);
    }

    /**
     * Insert a missed medication log
     */
    public function markMissed(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'date' => 'required|date'
        ]);

        // Check if already marked as missed
        $exists = DB::table('missed_logs')
            ->where('username', $request->username)
            ->whereDate('date', $request->date)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Already marked as missed for this date'
            ], 409);
        }

        DB::table('missed_logs')->insert([
            'username' => $request->username,
            'date' => $request->date,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'message' => 'Marked as missed successfully'
        ], 201);
    }

    /**
     * Get adherence statistics
     */
    public function getAdherenceStats(Request $request)
    {
        $request->validate([
            'username' => 'required|string'
        ]);

        $totalTreatmentDays = 180;
        
        $confirmedCount = DB::table('medication_logs')
            ->where('username', $request->username)
            ->count();

        $missedCount = DB::table('missed_logs')
            ->where('username', $request->username)
            ->count();

        $adherenceRate = $totalTreatmentDays > 0 
            ? round(($confirmedCount / $totalTreatmentDays) * 100, 1)
            : 0;

        return response()->json([
            'days_taken' => $confirmedCount,
            'days_missed' => $missedCount,
            'adherence_rate' => $adherenceRate,
            'total_treatment_days' => $totalTreatmentDays
        ]);
    }
}
?>