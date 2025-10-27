<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdverseEvent;

class AdverseEventController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'adv_ae_date' => 'required|date',
            'adv_specific_ae' => 'required|string|max:255',
            'adv_fda_reported_date' => 'nullable|date',
        ]);

        AdverseEvent::create([
            'patient_id' => $patientId,
            'adv_ae_date' => $request->adv_ae_date,
            'adv_specific_ae' => $request->adv_specific_ae,
            'adv_fda_reported_date' => $request->adv_fda_reported_date,
        ]);

        return redirect()->back()->with('success', 'Adverse Event saved successfully.');
    }
}
