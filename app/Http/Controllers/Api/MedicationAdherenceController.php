<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\MedicationAdherence;
use App\Models\Patient;

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
    // MedicationAdherenceController.php
    public function getAdherence($patient_id)
    {
        // Find the patient first to get their username
        $patient = Patient::findOrFail($patient_id);
        
        // Then get their adherence logs using the username
        $logs = MedicationAdherence::where('username', $patient->username)
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($logs);
    }
}
