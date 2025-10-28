<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MedicationAdherence;
use App\Models\PatientAccount;
use App\Models\Patient; // <-- Add this
use Carbon\Carbon;

class MedicationAdherenceController extends Controller
{
    public function index()
    {
        return view('medication.index');
    }

    // POST /api/adherence/log
    public function logAdherence(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|in:taken,missed',
        ]);

        // Save adherence log
        $adherence = MedicationAdherence::updateOrCreate(
            ['username' => $validated['username'], 'date' => $validated['date']],
            ['status' => $validated['status']]
        );

        // If the dose was missed, extend treatment duration by 1 day
        if ($validated['status'] === 'missed') {
            $account = PatientAccount::where('acc_username', $validated['username'])->first();

            if ($account) {
                $patient = Patient::find($account->patient_id);

                if ($patient) {

                    // Option 2: If you have an end date column (e.g., pha_continuation_end)
                    if (isset($patient->pha_continuation_end)) {
                        $endDate = Carbon::parse($patient->pha_continuation_end)->addDay();
                        $patient->pha_continuation_end = $endDate->format('Y-m-d');
                        $patient->save();
                    }
                }
            }
        }

        return response()->json([
            'message' => 'Adherence logged successfully',
            'data' => $validated
        ]);
    }

    // GET /api/adherence/{username}
    public function getAdherence($username)
    {
        $logs = MedicationAdherence::where('username', $username)
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($logs);
    }

    public function getAdherenceByPatientId($id)
    {
        $account = PatientAccount::where('patient_id', $id)->first();

        if (!$account) {
            return response()->json([]);
        }

        return $this->getAdherence($account->acc_username);
    }
}
