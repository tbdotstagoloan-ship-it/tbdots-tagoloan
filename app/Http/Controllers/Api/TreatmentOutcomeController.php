<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TreatmentOutcome;
use Illuminate\Http\Request;

class TreatmentOutcomeController extends Controller
{
    public function getLatestByPatientId($patientId)
    {
        $outcome = TreatmentOutcome::where('patient_id', $patientId)
            ->orderBy('created_at', 'desc')
            ->first();
        
        if (!$outcome) {
            return response()->json(['out_outcome' => 'Ongoing'], 200);
        }
        
        return response()->json([
            'out_outcome' => $outcome->out_outcome,
            'out_date' => $outcome->out_date,
            'out_reason' => $outcome->out_reason,
        ]);
    }
}