<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SputumMonitoring;

class SputumMonitoringController extends Controller
{
    public function store(Request $request, $id)
{
    $request->validate([
        'sput_date_collected' => 'required|date',
        'sput_smear_result' => 'nullable|string|max:255',
        'sput_xpert_result' => 'required|string|max:255',
        'lab_test_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Handle file upload
    $filePath = null;
    if ($request->hasFile('lab_test_photo')) {
        $file = $request->file('lab_test_photo');
        $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());


        // Store inside storage/app/public/sputum/{patient_id}
        $filePath = $file->storeAs('sputum/' . $id, $fileName, 'public');
    }

    // 1. Save sputum record
    SputumMonitoring::create([
        'patient_id' => $id,
        'sput_date_collected' => $request->sput_date_collected,
        'sput_smear_result' => $request->sput_smear_result,
        'sput_xpert_result' => $request->sput_xpert_result,
        'lab_test_photo' => $filePath,
    ]);

    // 2. Count MTB Negative Xpert results
    $negativeCount = SputumMonitoring::where('patient_id', $id)
        ->where('sput_xpert_result', 'MTB NEGATIVE')
        ->count();

    // 3. If 3+ MTB Negative → Create/update Treatment Outcome
    if ($negativeCount >= 3) {

        // Check latest treatment outcome
        $treatment = \App\Models\TreatmentOutcome::where('patient_id', $id)
            ->orderBy('created_at', 'desc')
            ->first();

        // Create ONLY if not already cured
        if (!$treatment || $treatment->out_outcome !== 'Cured') {
            \App\Models\TreatmentOutcome::create([
                'patient_id' => $id,
                'out_outcome' => 'Cured',
                'out_date' => now()->toDateString(),
                'out_reason' => '3 consecutive MTB Negative Xpert results',
            ]);
        }

        return redirect()
            ->back()
            ->with('success', 'Sputum result added successfully! Patient is now marked as CURED based on 3 MTB Negative results.')
            ->with('stay_on_tab', 'lab');
    }

    // Default success message
    return redirect()
        ->back()
        ->with('success', 'Sputum result added successfully!')
        ->with('stay_on_tab', 'lab');
}

}
