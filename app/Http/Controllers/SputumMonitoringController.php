<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SputumMonitoring;
use App\Models\Patient;

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

        // Check if patient has 3 consecutive MTB negative results
        $patient = Patient::findOrFail($id);
        $recentResults = SputumMonitoring::where('patient_id', $id)
            ->orderBy('sput_date_collected', 'desc')
            ->take(3)
            ->get();

        // Check if we have exactly 3 results and all are MTB NEGATIVE
        if ($recentResults->count() === 3) {
            $allNegative = $recentResults->every(function ($result) {
                return $result->sput_xpert_result === 'MTB NEGATIVE';
            });

            if ($allNegative) {
                return redirect()
                    ->back()
                    ->with('success', 'Sputum result added successfully!')
                    ->with('cure_notification', 'Patient has 3 consecutive MTB NEGATIVE results. Patient may be cured!')
                    ->with('stay_on_tab', 'lab');
            }
        }

        return redirect()
            ->back()
            ->with('success', 'Sputum result added successfully!')
            ->with('stay_on_tab', 'lab');
    }
}