<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TreatmentHistory;

class TreatmentHistoryController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'hist_date_tx_started' => 'required|date',
            'hist_treatment_unit' => 'required|string|max:255',
            'hist_regimen' => 'required|string|max:255',
            'hist_outcome' => 'required|string|max:50',
            'treatfacility_id' => 'nullable|integer|exists:treatment_facilities,id',
        ]);

        TreatmentHistory::create([
            'patient_id' => $patientId,
            'hist_date_tx_started' => $request->hist_date_tx_started,
            'hist_treatment_unit' => $request->hist_treatment_unit,
            'hist_regimen' => $request->hist_regimen,
            'hist_outcome' => $request->hist_outcome,
            'treatfacility_id' => $request->treatfacility_id, // ✅ Added this
        ]);


        return redirect()->back()->with('success', 'Treatment history added successfully.');
    }
}
