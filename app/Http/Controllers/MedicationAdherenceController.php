<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicationAdherence;
use App\Models\Patient;

class MedicationAdherenceController extends Controller
{
    // 🔹 For Flutter mobile sync
    public function logAdherence(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|in:taken,missed',
        ]);

        // ✅ Find the patient by username
        $patient = Patient::where('username', $request->username)->first();

        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        // ✅ Save or update adherence
        $adherence = MedicationAdherence::updateOrCreate(
            [
                'patient_id' => $patient->id,
                'date' => $request->date,
            ],
            [
                'status' => $request->status,
                'username' => $patient->username,
            ]
        );

        return response()->json([
            'message' => 'Adherence logged successfully',
            'data' => $adherence,
        ], 200);
    }

    // 🔹 For web calendar view
    public function getPatientAdherence($id)
    {
        $adherences = MedicationAdherence::where('patient_id', $id)
            ->get(['date', 'status']);
        return response()->json($adherences);
    }
}
