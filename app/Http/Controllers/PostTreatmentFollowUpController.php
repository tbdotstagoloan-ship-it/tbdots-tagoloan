<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostTreatmentFollowUp;

class PostTreatmentFollowUpController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'fol_months_after_tx' => 'required|integer|min:0',
            'fol_date' => 'required|date',
            'fol_cxr_findings' => 'nullable|string|max:255',
            'fol_smear_xpert' => 'nullable|string|max:255',
            'fol_tbc_dst' => 'nullable|string|max:255',
        ]);

        PostTreatmentFollowUp::create([
            'patient_id' => $patientId,
            'fol_months_after_tx' => $request->fol_months_after_tx,
            'fol_date' => $request->fol_date,
            'fol_cxr_findings' => $request->fol_cxr_findings,
            'fol_smear_xpert' => $request->fol_smear_xpert,
            'fol_tbc_dst' => $request->fol_tbc_dst,
        ]);

        return redirect()->back()->with('success', 'Follow-up record added successfully.');
    }
}
