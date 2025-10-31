<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CloseContact;
use App\Models\Patient;

class CloseContactController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'con_name' => 'required|string|max:255',
            'con_age' => 'required|integer',
            'con_sex' => 'required|string',
            'con_relationship' => 'required|string|max:255',
            'con_initial_screening' => 'nullable|date',
            'con_follow_up' => 'nullable|date',
            'con_remarks' => 'nullable|string|max:255',
        ]);

        CloseContact::create([
            'patient_id' => $id,
            'con_name' => $request->con_name,
            'con_age' => $request->con_age,
            'con_sex' => $request->con_sex,
            'con_relationship' => $request->con_relationship,
            'con_initial_screening' => $request->con_initial_screening,
            'con_follow_up' => $request->con_follow_up,
            'con_remarks' => $request->con_remarks,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Close contact added successfully!')
            ->with('stay_on_tab', 'lab');
    }
}
