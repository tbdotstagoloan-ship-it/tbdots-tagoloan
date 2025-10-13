<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientAuthController;

// Patient Authentication Routes
Route::prefix('patient')->group(function () {
    Route::post('/login', [PatientAuthController::class, 'login']);
    Route::post('/check-username', [PatientAuthController::class, 'checkUsername']);
});

// routes/api.php
Route::post('/patient-login', [PatientAuthController::class, 'patientLogin']);
