<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicationAdherence;

class MedicationAdherenceFlagsController extends Controller
{
    // public function index ()
    // {
    //     return view ('medication.index');
    // }

    // public function logAdherence(Request $request)
    // {
    //     $validated = $request->validate([
    //         'username' => 'required|string',
    //         'date' => 'required|date',
    //         'status' => 'required|in:taken,missed',
    //     ]);

    //     MedicationAdherence::updateOrCreate(
    //         ['username' => $validated['username'], 'date' => $validated['date']],
    //         ['status' => $validated['status']]
    //     );

    //     return response()->json([
    //         'message' => 'Adherence logged successfully',
    //         'data' => $validated
    //     ]);
    // }

    // public function getAdherence($username)
    // {
    //     $logs = MedicationAdherence::where('username', $username)
    //         ->orderBy('date', 'asc')
    //         ->get();

    //     return response()->json($logs);
    // }
}
