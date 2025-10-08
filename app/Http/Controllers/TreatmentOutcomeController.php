<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TreatmentOutcome;

class TreatmentOutcomeController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'out_outcome' => 'required|string',
            'out_date' => 'nullable|date',
            'out_reason' => 'nullable|string|max:255',
        ]);

        TreatmentOutcome::create([
            'patient_id' => $patientId,
            'out_outcome' => $request->out_outcome,
            'out_date' => $request->out_date,
            'out_reason' => $request->out_reason,
        ]);

        return redirect()->back()->with('success', 'Treatment outcome added successfully.');
    }

    // Update method (for editing existing records)
    public function update(Request $request, $id)
    {
        $request->validate([
            'out_outcome' => 'required|string',
            'out_date' => 'nullable|date',
            'out_reason' => 'nullable|string|max:255',
        ]);

        try {
            $outcome = TreatmentOutcome::findOrFail($id);
            
            $outcome->update([
                'out_outcome' => $request->out_outcome,
                'out_date' => $request->out_date,
                'out_reason' => $request->out_reason,
            ]);

            return redirect()->back()->with('success', 'Treatment outcome updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update treatment outcome: ' . $e->getMessage());
        }
    }
}
