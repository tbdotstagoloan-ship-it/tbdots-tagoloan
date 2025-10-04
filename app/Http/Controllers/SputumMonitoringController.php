<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SputumMonitoring;

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

        return redirect()->back()->with('success', 'Sputum monitoring result added successfully!');
    }
}
