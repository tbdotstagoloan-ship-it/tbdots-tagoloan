<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicationAdherence;
use App\Models\Patient;

class MedicationAdherenceController extends Controller
{
    /**
     * 🔹 Store or update adherence from the Flutter app.
     */
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

        // ✅ Create or update adherence record
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

    /**
     * 🔹 Fetch adherence data for a specific patient (for web dashboard)
     */
    public function getPatientAdherence($id)
    {
        $adherences = MedicationAdherence::where('patient_id', $id)
            ->orderBy('date', 'asc')
            ->get(['date', 'status']);

        if ($adherences->isEmpty()) {
            return response()->json(['message' => 'No adherence records found'], 404);
        }

        return response()->json($adherences);
    }

    /**
     * 🔹 Optional: Store manually via web interface
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
            'status' => 'required|in:taken,missed',
        ]);

        $adherence = MedicationAdherence::create([
            'patient_id' => $request->patient_id,
            'username' => Patient::find($request->patient_id)->username,
            'date' => $request->date,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Adherence record created successfully',
            'data' => $adherence,
        ], 201);
    }
}
