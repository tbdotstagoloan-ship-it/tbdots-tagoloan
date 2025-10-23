<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicationAdherence;
use App\Models\Patient;

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

        // ✅ Find the patient using the username
        $patient = Patient::where('username', $validated['username'])->first();

        if (!$patient) {
            return response()->json([
                'message' => 'Patient not found for the given username.'
            ], 404);
        }

        // ✅ Create or update adherence log linked to patient_id
        MedicationAdherence::updateOrCreate(
            [
                'patient_id' => $patient->id,
                'date' => $validated['date'],
            ],
            [
                'username' => $validated['username'],
                'status' => $validated['status'],
            ]
        );

        return response()->json([
            'message' => 'Adherence logged successfully',
            'data' => [
                'patient_id' => $patient->id,
                'username' => $validated['username'],
                'date' => $validated['date'],
                'status' => $validated['status'],
            ]
        ]);
    }

    // GET /api/adherence/patient/{id}
    public function getAdherenceByPatient($id)
    {
        $logs = MedicationAdherence::where('patient_id', $id)
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($logs);
    }
}
