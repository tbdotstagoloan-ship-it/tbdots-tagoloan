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

        // ✅ Create or update adherence record with patient_id
        $adherence = MedicationAdherence::updateOrCreate(
            [
                'patient_id' => $patient->id,
                'date' => $request->date,
            ],
            [
                'username' => $patient->username,
                'status' => $request->status,
            ]
        );

        return response()->json([
            'message' => 'Adherence logged successfully',
            'data' => [
                'id' => $adherence->id,
                'patient_id' => $patient->id,
                'username' => $patient->username,
                'date' => $adherence->date,
                'status' => $adherence->status,
            ],
        ], 200);
    }

    /**
     * 🔹 Fetch adherence data for a specific patient (for web dashboard)
     */
    public function getPatientAdherence($id)
    {
        $adherences = MedicationAdherence::where('patient_id', $id)
            ->orderBy('date', 'asc')
            ->get(['id', 'patient_id', 'username', 'date', 'status']);

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

        $patient = Patient::find($request->patient_id);

        $adherence = MedicationAdherence::create([
            'patient_id' => $patient->id,
            'username' => $patient->username,
            'date' => $request->date,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Adherence record created successfully',
            'data' => [
                'id' => $adherence->id,
                'patient_id' => $patient->id,
                'username' => $patient->username,
                'date' => $adherence->date,
                'status' => $adherence->status,
            ],
        ], 201);
    }
}
