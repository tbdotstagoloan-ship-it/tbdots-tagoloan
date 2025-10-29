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

        // Find usernames that missed a dose recently
        $usernames = MedicationAdherence::where('status', 'missed')
            ->whereDate('date', '>=', $since)
            ->pluck('username')
            ->unique()
            ->values();

        // Load patient accounts with patient info
        $accounts = PatientAccount::whereIn('acc_username', $usernames)
            ->with('patient')
            ->get();

        $flagged = $accounts->map(function ($acc) {
            $patient = $acc->patient;

            // Get logs (newest first)
            $adherenceLogs = MedicationAdherence::where('username', $acc->acc_username)
                ->orderBy('date', 'desc')
                ->pluck('status', 'date');

            // Count consecutive missed starting from latest
            $consecutiveMissed = 0;
            foreach ($adherenceLogs as $status) {
                if ($status === 'missed') {
                    $consecutiveMissed++;
                } else {
                    break;
                }
            }

            // Only include if 2 or more consecutive missed
            if ($consecutiveMissed <= 2) {
                return null;
            }

            $lastMissed = MedicationAdherence::where('username', $acc->acc_username)
                ->where('status', 'missed')
                ->orderByDesc('date')
                ->value('date');

            return [
                'patient_id' => $patient->id ?? null,
                'full_name' => $patient->pat_full_name ?? $acc->acc_username,
                'username' => $acc->acc_username,
                'contact' => $patient->pat_contact_number ?? null,
                'last_missed' => $lastMissed,
                'consecutive_missed' => $consecutiveMissed,
            ];
        })
        ->filter() // remove nulls
        ->sortByDesc('consecutive_missed') // sort highest first
        ->values();

        return view('medication.index', [
            'flagged' => $flagged,
            'days' => $days,
        ]);
    }

}