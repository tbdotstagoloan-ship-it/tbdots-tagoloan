<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChestXray;

class ChestXrayController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'xray_date_examined' => 'required|date',
            'xray_impression' => 'required|string|max:255',
            'xray_descriptive_comment' => 'nullable|string|max:255',
        ]);

        ChestXray::create([
            'patient_id' => $patientId,
            'xray_date_examined' => $request->xray_date_examined,
            'xray_impression' => $request->xray_impression,
            'xray_descriptive_comment' => $request->xray_descriptive_comment,
        ]);

        return redirect()->back()->with('success', 'Chest X-ray record added successfully.');
    }
}
