<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrescribedDrug;

class PrescribedDrugsController extends Controller
{
    // public function store(Request $request, $patientId)
    // {
    //     $request->validate([
    //         'drug_con_date' => 'required|date',
    //         'drug_con_name' => 'required|string|max:255',
    //         'drug_con_no_of_tablets' => 'required|string|max:255',
    //         'drug_con_strength' => 'nullable|string|max:255',
    //         'drug_con_unit' => 'nullable|string|max:255',
    //     ]);

    //     PrescribedDrug::create([
    //         'patient_id' => $patientId,
    //         'drug_con_date' => $request->drug_con_date,
    //         'drug_con_name' => $request->drug_con_name,
    //         'drug_con_no_of_tablets' => $request->drug_con_no_of_tablets,
    //         'drug_con_strength' => $request->drug_con_strength,
    //         'drug_con_unit' => $request->drug_con_unit,
    //     ]);

    //     return redirect()->back()->with('success', 'Prescribed drug added successfully.');
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'drug_start_date' => 'nullable|date',
            'drug_name' => 'nullable|string|max:255',
            'drug_no_of_tablets' => 'nullable|string|max:255',
            'drug_strength' => 'nullable|string|max:255',
            'drug_unit' => 'nullable|string|max:255',
            'drug_con_date' => 'nullable|date',
            'drug_con_name' => 'nullable|string|max:255',
            'drug_con_no_of_tablets' => 'nullable|string|max:255',
            'drug_con_strength' => 'nullable|string|max:255',
            'drug_con_unit' => 'nullable|string|max:255',
        ]);

        // Find the prescribed drug record by patient_id (not prescribed_drug id)
        $prescribedDrug = PrescribedDrug::where('patient_id', $id)->first();

        if ($prescribedDrug) {
            // Update existing record
            $prescribedDrug->update($request->all());
        } else {
            // Or create new one if none exists
            $prescribedDrug = PrescribedDrug::create(array_merge(
                $request->all(),
                ['patient_id' => $id]
            ));
        }

        return redirect()
            ->back()
            ->with('success', 'Prescribed drug updated successfully!')
            ->with('stay_on_tab', 'treatment');
    }

}
