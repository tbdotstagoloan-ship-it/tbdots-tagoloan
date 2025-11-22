<?php

namespace App\Http\Controllers;

use App\Models\Adherence;
use App\Models\PrescribedDrug;
use Illuminate\Http\Request;
use App\Models\Patient;

class AdherenceController extends Controller
{
    public function update(Request $request, $id)
{
    // ✅ Validate all fields
    $validated = $request->validate([
        // Treatment Supporter Information
        'sup_location' => 'nullable|string|max:255',
        'sup_name' => 'nullable|string|max:255',
        'sup_designation' => 'nullable|string|max:255',
        'sup_type' => 'nullable|string|max:255',
        'sup_contact_info' => 'nullable|string|max:255',
        'sup_dat_used' => 'nullable|string|max:255',
        'sup_treatment_schedule' => 'nullable|string|max:255',

        // Treatment Schedule Details
        'pha_intensive_start' => 'nullable|date',
        'pha_intensive_end' => 'nullable|date',
        'pha_continuation_start' => 'nullable|date',
        'pha_continuation_end' => 'nullable|date',

        // Measurements
        'pha_weight' => 'nullable|numeric|min:0',
        'pha_child_height' => 'nullable|numeric|min:0',

        // Prescribed Drugs
        'drug_con_date' => 'nullable|date',
        'drug_con_name' => 'nullable|string|max:255',
        'drug_con_no_of_tablets' => 'nullable|string|max:255',
        'drug_con_strength' => 'nullable|string|max:255',
        'drug_con_unit' => 'nullable|string|max:255',
    ]);

    // ✅ Find patient with relationships
    $patient = Patient::with(['txSupporters', 'adherences', 'prescribedDrugs'])->findOrFail($id);

    // --- Update LATEST Treatment Supporter Info ---
    if ($patient->txSupporters->isNotEmpty()) {
        $latestSupporter = $patient->txSupporters->sortByDesc('created_at')->first();
        $latestSupporter->update([
            'sup_location' => $request->sup_location,
            'sup_name' => $request->sup_name,
            'sup_designation' => $request->sup_designation,
            'sup_type' => $request->sup_type,
            'sup_contact_info' => $request->sup_contact_info,
            'sup_dat_used' => $request->sup_dat_used,
            'sup_treatment_schedule' => $request->sup_treatment_schedule,
        ]);
    }

    // --- Update LATEST Adherence (Schedule & Measurements) ---
    if ($patient->adherences->isNotEmpty()) {
        $latestAdherence = $patient->adherences->sortByDesc('created_at')->first();
        $latestAdherence->update([
            'pha_intensive_start' => $request->pha_intensive_start,
            'pha_intensive_end' => $request->pha_intensive_end,
            'pha_continuation_start' => $request->pha_continuation_start,
            'pha_continuation_end' => $request->pha_continuation_end,
            'pha_weight' => $request->pha_weight,
            'pha_child_height' => $request->pha_child_height,
        ]);
    }

    // --- Update or Create Prescribed Drugs (latest episode) ---
    $latestDrug = $patient->prescribedDrugs->sortByDesc('created_at')->first();

    if ($latestDrug) {
        $latestDrug->update([
            'drug_con_date' => $request->drug_con_date,
            'drug_con_name' => $request->drug_con_name,
            'drug_con_no_of_tablets' => $request->drug_con_no_of_tablets,
            'drug_con_strength' => $request->drug_con_strength,
            'drug_con_unit' => $request->drug_con_unit,
        ]);
    } else {
        // If no record exists, create new
        PrescribedDrug::create([
            'patient_id' => $patient->id,
            'drug_con_date' => $request->drug_con_date,
            'drug_con_name' => $request->drug_con_name,
            'drug_con_no_of_tablets' => $request->drug_con_no_of_tablets,
            'drug_con_strength' => $request->drug_con_strength,
            'drug_con_unit' => $request->drug_con_unit,
        ]);
    }

    return redirect()
        ->back()
        ->with('success', 'Record updated successfully!')
        ->with('stay_on_tab', 'treatment');
}

}
