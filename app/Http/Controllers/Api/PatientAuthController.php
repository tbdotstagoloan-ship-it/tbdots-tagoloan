<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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

        // Get patient info
        $patient = Patient::find($account->patient_id);

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $account->id,
                'username' => $account->acc_username,
                'patient_id' => $account->patient_id,
                'full_name' => $patient->pat_full_name ?? null,
                'contact_number' => $patient->pat_contact_number ?? null,
            ],
        ]);
    }
    

}