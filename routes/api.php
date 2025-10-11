<?php

use App\Http\Controllers\Api\PatientAuthController;

Route::post('/patient/login', [PatientAuthController::class, 'login']);

