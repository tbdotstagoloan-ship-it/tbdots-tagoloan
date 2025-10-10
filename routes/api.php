<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

Route::post('/patient-login', function (Request $request) {
    $username = $request->input('username');
    $password = $request->input('password');

    $account = DB::table('tbl_patient_accounts')
        ->where('acc_username', $username)
        ->first();

    if (!$account || !Hash::check($password, $account->acc_password)) {
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    return response()->json([
        'message' => 'Login successful',
        'patient_id' => $account->patient_id,
        'username' => $account->acc_username,
    ]);
});
