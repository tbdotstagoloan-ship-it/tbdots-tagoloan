<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicationAdherence;
use App\Models\PatientAccount;
use App\Models\Patient;
use Carbon\Carbon;

class MedicationAdherenceFlagsController extends Controller
{
    /**
     * Show patients flagged for missed medication.
     * Optional query param `days` controls lookback window (default 7).
     */
    public function index(Request $request)
    {
        $days = (int) $request->input('days', 7);
        $since = Carbon::now()->subDays($days)->toDateString();

        // get usernames that have at least one 'missed' in the lookback window
        $usernames = MedicationAdherence::where('status', 'missed')
            ->whereDate('date', '>=', $since)
            ->pluck('username')
            ->unique()
            ->values();

        // get patient accounts for those usernames and eager load patient
        $accounts = PatientAccount::whereIn('acc_username', $usernames)
            ->with('patient')
            ->get();

        // map to view-friendly rows
        $flagged = $accounts->map(function ($acc) {
        $patient = $acc->patient;

        // Get all adherence logs for this user (sorted by most recent first)
        $adherenceLogs = MedicationAdherence::where('username', $acc->acc_username)
            ->orderBy('date', 'desc')
            ->pluck('status', 'date');

        // Count how many *consecutive* missed starting from most recent
        $consecutiveMissed = 0;
        foreach ($adherenceLogs as $status) {
            if ($status === 'missed') {
                $consecutiveMissed++;
            } else {
                break;
            }
        }

        return [
            'patient_id' => $patient->id ?? null,
            'full_name' => $patient->pat_full_name ?? $acc->acc_username,
            'username' => $acc->acc_username,
            'contact' => $patient->pat_contact_number ?? null,
            'last_missed' => MedicationAdherence::where('username', $acc->acc_username)
                ->where('status', 'missed')
                ->orderByDesc('date')
                ->value('date'),
            'consecutive_missed' => $consecutiveMissed, // ✅ numeric count
        ];
    })->filter(function ($row) {
        return !is_null($row['patient_id']);
    })->values();


        return view('medication.index', [
            'flagged' => $flagged,
            'days' => $days,
        ]);
    }
}