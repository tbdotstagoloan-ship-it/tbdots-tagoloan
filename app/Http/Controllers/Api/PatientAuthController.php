<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PatientAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Find the patient account
        $account = DB::table('tbl_patient_accounts')
            ->where('acc_username', $request->username)
            ->first();

        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid username or password',
            ], 401);
        }

        // Verify password (hashed via bcrypt)
        if (!Hash::check($request->password, $account->acc_password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid username or password',
            ], 401);
        }

        // Get basic patient info
        $patient = DB::table('tbl_patients')
            ->where('id', $account->patient_id)
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'patient' => $patient,
        ]);
    }
}
