<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdverseEvent;
use App\Models\Patient;

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

    public function storeFromMobile(Request $request, $username)
    {
        \Log::info('Mobile adverse event request', [
            'username' => $username,
            'body' => $request->all()
        ]);

        $request->validate([
            'adv_ae_date' => 'required|date',
            'adv_specific_ae' => 'required|string|max:255',
            'adv_fda_reported_date' => 'nullable|date',
        ]);

        // Find patient by username
        $patient = Patient::where('username', $username)->first();
        
        if (!$patient) {
            \Log::error('Patient not found', ['username' => $username]);
            return response()->json([
                'message' => 'Patient not found with username: ' . $username
            ], 404);
        }

        $ae = AdverseEvent::create([
            'patient_id' => $patient->id,
            'username' => $username,  // Add this line
            'adv_ae_date' => $request->adv_ae_date,
            'adv_specific_ae' => $request->adv_specific_ae,
            'adv_fda_reported_date' => $request->adv_fda_reported_date,
        ]);

        \Log::info('Mobile adverse event created', ['id' => $ae->id]);

        return response()->json([
            'message' => 'Adverse Event saved successfully.',
            'data' => $ae
        ], 201);
    }
}
