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

        return redirect()
            ->back()
            ->with('success', 'Adverse Event saved successfully.')
            ->with('stay_on_tab', 'lab');
    }

    public function storeFromMobile(Request $request, $username)
    {
        \Log::info('Mobile adverse event request', [
            'body' => $request->all()
        ]);

        $request->validate([
            'adv_ae_date' => 'required|date',
            'adv_specific_ae' => 'required|string|max:255',
            'adv_fda_reported_date' => 'nullable|date',
        ]);

        // 🔍 Find the patient using PatientAccount
        $account = \App\Models\PatientAccount::where('acc_username', $username)->first();

        if (!$account) {
            \Log::error('Account not found', ['username' => $username]);
            return response()->json([
                'message' => 'Account not found for username: ' . $username
            ], 404);
        }

        $patient = Patient::find($account->patient_id);

        if (!$patient) {
            \Log::error('Patient not found for account', ['username' => $username]);
            return response()->json([
                'message' => 'Patient not found for account username: ' . $username
            ], 404);
        }

        // 💾 Save the Adverse Event
        $ae = AdverseEvent::create([
            'patient_id' => $patient->id,
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
