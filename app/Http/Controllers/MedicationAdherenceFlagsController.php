<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicationAdherence;
use App\Models\PatientAccount;
use Carbon\Carbon;

class MedicationAdherenceFlagsController extends Controller
{
    public function index(Request $request)
    {
        $days = (int) $request->input('days', 7);
        $since = Carbon::now()->subDays($days)->toDateString();

        $usernames = MedicationAdherence::where('status', 'missed')
            ->whereDate('date', '>=', $since)
            ->pluck('username')
            ->unique()
            ->values();

        $accounts = PatientAccount::whereIn('acc_username', $usernames)
            ->with('patient')
            ->get();

        $flagged = $accounts->map(function ($acc) {
            $patient = $acc->patient;

            $adherenceLogs = MedicationAdherence::where('username', $acc->acc_username)
                ->orderBy('date', 'desc')
                ->pluck('status', 'date');

            // count consecutive missed
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
                'consecutive_missed' => $consecutiveMissed,
            ];
        })
        ->filter(fn($row) => !is_null($row['patient_id']))
        // ✅ Sort by most missed first
        ->sortByDesc('consecutive_missed')
        ->values();

        return view('medication.index', [
            'flagged' => $flagged,
            'days' => $days,
        ]);
    }
}
