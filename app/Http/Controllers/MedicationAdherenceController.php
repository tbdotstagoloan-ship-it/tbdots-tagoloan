<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicationAdherence;

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
            'patient_id' => 'nullable|integer',
            'username' => 'required|string',
            'date' => 'required|date',
            'status' => 'required|in:taken,missed',
        ]);

        MedicationAdherence::updateOrCreate(
[
                'username' => $validated['username'],
                'date' => $validated['date']
            ],

    [
                'patient_id' => $validated['patient_id'] ?? null,
                'status' => $validated['status']
            ]
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
}
