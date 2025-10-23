<?php

namespace App\Http\Controllers;

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
    public function store(Request $request)
    {
        // 🧠 Validate request
        $validated = $request->validate([
            'patient_id' => 'required|exists:tbl_patients,id',
            'date' => 'required|date',
            'status' => 'required|in:taken,missed',
        ]);

        // 💾 Save adherence record
        $adherence = MedicationAdherence::create([
            'patient_id' => $validated['patient_id'],
            'date' => $validated['date'],
            'status' => $validated['status'],
        ]);

        return response()->json([
            'message' => 'Adherence record saved successfully',
            'data' => $adherence
        ]);
    }


    // GET /api/adherence/{username}
    public function getAdherence($patientId)
    {
        $logs = MedicationAdherence::where('patient_id', $patientId)
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($logs);
    }

    public function fetchAdherence($patientId)
    {
        // 🔍 Check if patient exists
        $patient = Patient::find($patientId);
        if (!$patient) {
            return response()->json(['error' => 'Patient not found'], 404);
        }

        // 🧠 Fetch adherence data using patient_id
        $adherenceRecords = MedicationAdherence::where('patient_id', $patientId)->get();

        // 🧮 Calculate adherence rate
        $totalDays = $adherenceRecords->count();
        $daysTaken = $adherenceRecords->where('status', 'taken')->count();
        $daysMissed = $adherenceRecords->where('status', 'missed')->count();
        $adherenceRate = $totalDays > 0 ? round(($daysTaken / $totalDays) * 100, 2) : 0;

        return response()->json([
            'adherenceRate' => $adherenceRate,
            'daysTaken' => $daysTaken,
            'daysMissed' => $daysMissed,
            'records' => $adherenceRecords
        ]);
    }

    public function getPatientAdherence($id)
    {
        $adherences = MedicationAdherence::where('patient_id', $id)->get(['date', 'status']);
        return response()->json($adherences);
    }

}
