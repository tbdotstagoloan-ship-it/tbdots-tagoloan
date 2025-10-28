<?php

use App\Http\Controllers\PhysicianController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiagnosingFacilityController;
use App\Http\Controllers\Api\PatientAuthController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdverseEventController;
use App\Http\Controllers\Api\MedicationAdherenceController;



Route::post('/patient/login', [PatientAuthController::class, 'patientLogin']);
Route::middleware('auth:sanctum')->post('/patient/logout', [PatientAuthController::class, 'logout']);



Route::get('/regions', [AddressController::class, 'regions']);
Route::get('/provinces/{regCode}', [AddressController::class, 'provinces']);
Route::get('/cities/{provCode}', [AddressController::class, 'cities']);
Route::get('/barangays/{citymunCode}', [AddressController::class, 'barangays']);
Route::get('/zipcode/{citymunCode}', [AddressController::class, 'zipcode']);


Route::get('/facilities', [DiagnosingFacilityController::class, 'show']);
Route::get('/physicians', [PhysicianController::class, 'show']);

Route::post('/adherence/log', [MedicationAdherenceController::class, 'logAdherence']);
Route::get('/adherence/{username}', [MedicationAdherenceController::class, 'getAdherence']);
Route::get('/adherence/{patient_id}', [MedicationAdherenceController::class, 'getAdherence']);


Route::get('/adherence/patient/{id}', [MedicationAdherenceController::class, 'getAdherenceByPatientId']);

// Adverse Event
Route::post('patients/{username}/adverse-events', [AdverseEventController::class, 'storeFromMobile']);

