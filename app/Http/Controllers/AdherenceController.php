<?php

namespace App\Http\Controllers;

use App\Models\Adherence;
use Illuminate\Http\Request;
use App\Models\Patient;

class AdherenceController extends Controller
{
    public function update(Request $request, $id)
    {
        // ✅ Validate all fields from all 3 tables (Supporter Info, Schedule, Measurements)
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
        ]);

        // ✅ Find existing records
        $patient = Patient::findOrFail($id);

        // --- Update Treatment Supporter Info ---
        if ($patient->txSupporters->isNotEmpty()) {
            $txSupporter = $patient->txSupporters->first();
            $txSupporter->update([
                'sup_location' => $request->sup_location,
                'sup_name' => $request->sup_name,
                'sup_designation' => $request->sup_designation,
                'sup_type' => $request->sup_type,
                'sup_contact_info' => $request->sup_contact_info,
                'sup_dat_used' => $request->sup_dat_used,
                'sup_treatment_schedule' => $request->sup_treatment_schedule,
            ]);
        }

        // --- Update Adherence (Schedule & Measurements) ---
        if ($patient->adherences->isNotEmpty()) {
            $adherence = $patient->adherences->first();
            $adherence->update([
                'pha_intensive_start' => $request->pha_intensive_start,
                'pha_intensive_end' => $request->pha_intensive_end,
                'pha_continuation_start' => $request->pha_continuation_start,
                'pha_continuation_end' => $request->pha_continuation_end,
                'pha_weight' => $request->pha_weight,
                'pha_child_height' => $request->pha_child_height,
            ]);
        }

        return redirect()->back()->with('success', 'Administration of drugs record updated successfully!');
    }



}
