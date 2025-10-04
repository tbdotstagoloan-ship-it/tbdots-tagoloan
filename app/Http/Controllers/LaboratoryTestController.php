<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LaboratoryTest;

class LaboratoryTestController extends Controller
{
    public function store(Request $request, $patientId)
    {
        $request->validate([
            'lab_smear_test_date' => 'nullable|date',
            'lab_smear_result' => 'nullable|string|max:255',
            'lab_tst_test_date' => 'nullable|date',
            'lab_tst_result' => 'nullable|string|max:255',
            'lab_other_test_date' => 'nullable|date',
            'lab_other_result' => 'nullable|string|max:255',
        ]);

        LaboratoryTest::create([
            'patient_id' => $patientId,
            'lab_smear_test_date' => $request->lab_smear_test_date,
            'lab_smear_result' => $request->lab_smear_result,
            'lab_tst_test_date' => $request->lab_tst_test_date,
            'lab_tst_result' => $request->lab_tst_result,
            'lab_other_test_date' => $request->lab_other_test_date,
            'lab_other_result' => $request->lab_other_result,
        ]);

        return redirect()->back()->with('success', 'Laboratory test added successfully.');
    }
}
