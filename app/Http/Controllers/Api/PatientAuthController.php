<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientAuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'acc_username' => 'required|string',
            'acc_password' => 'required|string',
        ]);

        $account = DB::table('tbl_patient_accounts')
            ->where('acc_username', $request->acc_username)
            ->first();

        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => 'Account not found.',
            ], 404);
        }

        // 🔹 Check password (choose based on how your passwords are stored)
        // If passwords are HASHED in DB:
        if (Hash::check($request->acc_password, $account->acc_password)) {
            $token = base64_encode(bin2hex(random_bytes(40)));

            return response()->json([
                'success' => true,
                'message' => 'Login successful.',
                'token' => $token,
                'patient' => [
                    'id' => $account->id,
                    'username' => $account->acc_username,
                    'email' => $account->email ?? null,
                    'patient_id' => $account->patient_id,
                ],
            ]);
        }

        // If passwords are plain text, use this instead:
        // if ($request->acc_password === $account->acc_password) { ... }

        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials.',
        ], 401);
    }
}
