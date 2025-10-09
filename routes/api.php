<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientAuthController;

Route::post('/patient/login', [PatientAuthController::class, 'login']);
