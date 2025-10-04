<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosis;

class ReferralController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'diag_referred_to' => 'required|string|max:255',
            'diag_address' => 'nullable|string|max:255',
            'diag_facility_code' => 'nullable|string|max:255',
            'diag_province' => 'nullable|string|max:255',
            'diag_region' => 'nullable|string|max:255',
        ]);

        Diagnosis::create([
            'patient_id' => $patientId,
            'diag_referred_to' => $request->diag_referred_to,
            'diag_address' => $request->diag_address,
            'diag_facility_code' => $request->diag_facility_code,
            'diag_province' => $request->diag_province,
            'diag_region' => $request->diag_region,
        ]);

        return redirect()->back()->with('success', 'Referral saved successfully.');
    }
}
