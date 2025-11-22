<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HIVInfo;

class HivController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'hiv_information' => 'nullable|string|max:255',
            'hiv_test_date' => 'nullable|date',
            'hiv_confirmatory_test_date' => 'nullable|date',
            'hiv_result' => 'nullable|string|max:255',
            'hiv_art_started' => 'nullable|string|in:Yes,No',
            'hiv_cpt_started' => 'nullable|string|in:Yes,No',
        ]);

        HIVInfo::create([
            'patient_id' => $patientId,
            'hiv_information' => $request->hiv_information,
            'hiv_test_date' => $request->hiv_test_date,
            'hiv_confirmatory_test_date' => $request->hiv_confirmatory_test_date,
            'hiv_result' => $request->hiv_result,
            'hiv_art_started' => $request->hiv_art_started,
            'hiv_cpt_started' => $request->hiv_cpt_started,
        ]);

        return redirect()
            ->back()
            ->with('success', 'HIV information added successfully.')
            ->with('stay_on_tab', 'treatment');
    }
}
