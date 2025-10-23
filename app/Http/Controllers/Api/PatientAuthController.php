<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\PatientAccount;
use App\Models\Patient;

class PatientAuthController extends Controller
{
    public function patientLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $account = PatientAccount::where('acc_username', $request->username)->first();

        if (!$account || !Hash::check($request->password, $account->acc_password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // ✅ Generate Sanctum token
        $token = $account->createToken('patient_token')->plainTextToken;

        // ✅ Get linked patient record
        $patient = Patient::find($account->patient_id);

        // ✅ Return both account + patient info for Flutter
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'patient' => [ // ← you’ll use this in Flutter
                'id' => $patient->id ?? $account->patient_id, // this is the patient_id
                'username' => $account->acc_username,
                'full_name' => $patient->pat_full_name ?? null,
                'contact_number' => $patient->pat_contact_number ?? null,
            ],
        ]);
    }

}
