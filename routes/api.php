<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientAuthController;

Route::get('/test-api', function () {
    return response()->json(['message' => 'API route loaded!']);
});

Route::post('/patient/login', [PatientAuthController::class, 'patientLogin']);
Route::middleware('auth:sanctum')->post('/patient/logout', [PatientAuthController::class, 'logout']);