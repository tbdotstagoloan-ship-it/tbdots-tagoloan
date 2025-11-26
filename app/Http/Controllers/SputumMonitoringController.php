<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SputumMonitoring;
use App\Models\Patient;
use App\Models\TreatmentOutcome;

class SputumMonitoringController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'sput_date_collected' => 'required|date',
            'sput_smear_result' => 'nullable|string|max:255',
            'sput_xpert_result' => 'required|string|max:255',
        ]);

        SputumMonitoring::create([
            'patient_id' => $id,
            'sput_date_collected' => $request->sput_date_collected,
            'sput_smear_result' => $request->sput_smear_result,
            'sput_xpert_result' => $request->sput_xpert_result,
        ]);

        // Check if patient has 3 consecutive negative results
        $this->checkForCuredStatus($id);

        return redirect()
            ->back()
            ->with('success', 'Sputum result added successfully!')
            ->with('stay_on_tab', 'lab');
    }

    private function checkForCuredStatus($patientId)
    {
        // Get the last 3 sputum results ordered by date
        $lastThreeResults = SputumMonitoring::where('patient_id', $patientId)
            ->orderBy('sput_date_collected', 'desc')
            ->take(3)
            ->get();

        // Check if we have exactly 3 results and all are negative
        if ($lastThreeResults->count() === 3) {
            $allNegative = $lastThreeResults->every(function ($result) {
                return strtolower($result->sput_xpert_result) === 'mtb negative';
            });

            if ($allNegative) {
                // Check if treatment outcome already exists
                $existingOutcome = TreatmentOutcome::where('patient_id', $patientId)->first();
                
                if (!$existingOutcome) {
                    // Create new treatment outcome
                    TreatmentOutcome::create([
                        'patient_id' => $patientId,
                        'out_outcome' => 'Cured',
                        'out_date' => now()->format('Y-m-d'),
                        'out_reason' => 'Three consecutive negative sputum results'
                    ]);

                    // Add success message
                    session()->flash('cured_notification', true);
                } else if ($existingOutcome->out_outcome !== 'Cured') {
                    // Update existing outcome if not already cured
                    $existingOutcome->update([
                        'out_outcome' => 'Cured',
                        'out_date' => now()->format('Y-m-d'),
                        'out_reason' => 'Three consecutive negative sputum results'
                    ]);

                    // Add success message
                    session()->flash('cured_notification', true);
                }
            }
        }
    }
}