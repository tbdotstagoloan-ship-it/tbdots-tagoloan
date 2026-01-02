<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PatientAccount;
use Illuminate\Http\Request;

class PatientAccountController extends Controller
{
    public function getByUsername($username)
    {
        $account = PatientAccount::where('acc_username', $username)->first();
        
        if (!$account) {
            return response()->json(['error' => 'Account not found'], 404);
        }
        
        return response()->json([
            'patient_id' => $account->patient_id,
            'username' => $account->acc_username,
        ]);
    }
}