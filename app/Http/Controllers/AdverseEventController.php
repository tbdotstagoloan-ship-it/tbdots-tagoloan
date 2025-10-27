<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdverseEvent;
use App\Models\Patient;
use Illuminate\Support\Facades\Validator;

class AdverseEventController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'adv_ae_date' => 'required|date',
            'adv_specific_ae' => 'required|string|max:255',
            'adv_fda_reported_date' => 'nullable|date',
        ]);

        AdverseEvent::create([
            'patient_id' => $patientId,
            'adv_ae_date' => $request->adv_ae_date,
            'adv_specific_ae' => $request->adv_specific_ae,
            'adv_fda_reported_date' => $request->adv_fda_reported_date,
        ]);

        return redirect()->back()->with('success', 'Adverse Event saved successfully.');
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id'   => 'nullable|integer|exists:patients,id',
            'username'     => 'nullable|string',
            'symptom'      => 'nullable|string',
            'description'  => 'nullable|string',
            'adv_fda_reported_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $patientId = $request->input('patient_id');

        if (!$patientId && $request->filled('username')) {
            $patient = Patient::where('username', $request->input('username'))->first();
            if ($patient) {
                $patientId = $patient->id;
            } else {
                return response()->json(['message' => 'Patient not found'], 404);
            }
        }

        if (!$patientId) {
            return response()->json(['message' => 'patient_id or username required'], 422);
        }

        $ae = AdverseEvent::create([
            'adv_ae_date' => now(),
            'adv_specific_ae' => $request->input('description') ?? $request->input('symptom') ?? '',
            'adv_fda_reported_date' => $request->input('adv_fda_reported_date'),
            'patient_id' => $patientId,
        ]);

        return response()->json(['data' => $ae], 201);
    }
    
}
