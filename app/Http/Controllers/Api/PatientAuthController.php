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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logout successful',
        ]);
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        
        $account = DB::table('tbl_patient_accounts')
            ->where('patient_id', $id)
            ->first();
        
        if (!$account) {
            return redirect()->back()->with('error', 'Patient does not have an account.');
        }
        
        DB::table('tbl_patient_accounts')
            ->where('patient_id', $id)
            ->update([
                'password' => Hash::make($request->password),
                'updated_at' => now()
            ]);
        
        return redirect()->back()->with('success', 'Password changed successfully for ' . $request->input('patient_name', 'patient') . '.');
    }

}
