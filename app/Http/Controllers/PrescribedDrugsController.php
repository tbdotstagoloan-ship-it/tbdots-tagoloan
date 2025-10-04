<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrescribedDrug;

class PrescribedDrugsController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'drug_con_date' => 'required|date',
            'drug_con_name' => 'required|string|max:255',
            'drug_con_strength' => 'nullable|string|max:255',
            'drug_con_unit' => 'nullable|string|max:255',
        ]);

        PrescribedDrug::create([
            'patient_id' => $patientId,
            'drug_con_date' => $request->drug_con_date,
            'drug_con_name' => $request->drug_con_name,
            'drug_con_strength' => $request->drug_con_strength,
            'drug_con_unit' => $request->drug_con_unit,
        ]);

        return redirect()->back()->with('success', 'Prescribed drug added successfully.');
    }
}
