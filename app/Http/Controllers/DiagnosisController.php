<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnosis;

class DiagnosisController extends Controller
{
   public function update(Request $request, $id)
{
    $request->validate([
        'diag_diagnosis_date' => 'nullable|date',
        'diag_notification_date' => 'nullable|date',
        'diag_tb_case_no' => 'nullable|string|max:255',
        'diag_attending_physician' => 'nullable|string|max:255',
        'diag_referred_to' => 'nullable|string|max:255',
        'diag_address' => 'nullable|string|max:255',
        'diag_facility_code' => 'nullable|string|max:255',
        'diag_province' => 'nullable|string|max:255',
        'diag_region' => 'nullable|string|max:255',
    ]);

    $diagnosis = Diagnosis::findOrFail($id);
    $diagnosis->update($request->only([
        'diag_diagnosis_date', 'diag_notification_date', 'diag_tb_case_no',
        'diag_attending_physician', 'diag_referred_to', 'diag_address',
        'diag_facility_code', 'diag_province', 'diag_region',
    ]));

    return redirect()
        ->back()
        ->with('success', 'Referral updated successfully!')
        ->with('stay_on_tab', 'diagnosis');
}



}
