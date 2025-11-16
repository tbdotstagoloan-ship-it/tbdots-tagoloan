<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MedicationAdherence;
use App\Models\PatientAccount;

class MedicationAdherenceController extends Controller
{
    public function index ()
    {
        return view ('medication.index');
    }

    // POST /api/adherence/log
    public function logAdherence(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|in:taken,missed',
        ]);

        MedicationAdherence::updateOrCreate(
            ['username' => $validated['username'], 'date' => $validated['date']],
            ['status' => $validated['status']]
        );

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
        // try to find the account username for this patient
        $account = PatientAccount::where('patient_id', $id)->first();

        if (! $account) {
            return response()->json([]);
        }

        // reuse existing method logic: query by username
        return $this->getAdherence($account->acc_username);
    }

    public function deleteAdherence($username, $date)
{
    MedicationAdherence::where('username', $username)
        ->where('date', $date)
        ->delete();

    return response()->json(['message' => 'Adherence deleted successfully']);
}

}
