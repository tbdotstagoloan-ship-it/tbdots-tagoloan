<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Progress;

class PatientProgressController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'prog_date' => 'required|date',
            'prog_problem' => 'required|string|max:255',
            'prog_action_taken' => 'required|string|max:255',
            'prog_plan' => 'required|string|max:255',
        ]);

        Progress::create([
            'patient_id' => $patientId,
            'prog_date' => $request->prog_date,
            'prog_problem' => $request->prog_problem,
            'prog_action_taken' => $request->prog_action_taken,
            'prog_plan' => $request->prog_plan,
        ]);

        return redirect()->back()->with('success', 'Patient progress added successfully.');
    }
}
