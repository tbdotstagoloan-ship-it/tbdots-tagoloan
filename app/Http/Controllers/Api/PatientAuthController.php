<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\PatientAccount;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;


class PatientAuthController extends Controller
{
    public function patientLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $account = PatientAccount::whereRaw('BINARY acc_username = ?', [$request->username])->first();

        if (!$account || !Hash::check($request->password, $account->acc_password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        // ✅ Generate Sanctum token
        $token = $account->createToken('patient_token')->plainTextToken;

        $patient = Patient::find($account->patient_id);

        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $account->id,
                'username' => $account->acc_username,
                'patient_id' => $account->patient_id,
                'full_name' => $patient->pat_full_name ?? null,
                'contact_number' => $patient->pat_contact_number ?? null,
            ],
        ]);
    }

    // public function logout(Request $request)
    // {
    //     $request->user()->currentAccessToken()->delete();

    //     return response()->json([
    //         'message' => 'Logout successful',
    //     ]);
    // }

    // ✅ Verify username and get patient info
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ]);

        $account = PatientAccount::whereRaw('BINARY acc_username = ?', [$request->username])->first();

        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Username not found.'
            ], 404);
        }

        $patient = Patient::find($account->patient_id);

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient record not found.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Username verified. You can now reset your password.',
            'patient_info' => [
                'full_name' => $patient->pat_full_name,
                'contact_number' => $patient->pat_contact_number,
            ]
        ]);
    }

    // ✅ Reset password directly using username
    public function resetPassword(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|min:8|confirmed', // needs password_confirmation
        ]);

        $account = PatientAccount::whereRaw('BINARY acc_username = ?', [$request->username])->first();

        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Username not found.'
            ], 404);
        }

        // Update password
        $account->acc_password = Hash::make($request->password);
        $account->save();

        return response()->json([
            'success' => true,
            'message' => 'Password has been reset successfully. You can now login with your new password.'
        ]);
    }

}
