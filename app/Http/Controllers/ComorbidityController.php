<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comorbidity;

class ComorbidityController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'com_date_diagnosed' => 'required|date',
            'com_type' => 'required|string|max:255',
            'com_other' => 'nullable|string|max:255',
            'com_treatment' => 'nullable|string|max:255',
        ]);

        Comorbidity::create([
            'patient_id' => $patientId,
            'com_date_diagnosed' => $request->com_date_diagnosed,
            'com_type' => $request->com_type,
            'com_other' => $request->com_other,
            'com_treatment' => $request->com_treatment,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Co-morbidity added successfully.')
            ->with('stay_on_tab', 'treatment');
    }
}
