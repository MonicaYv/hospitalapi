<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PatientRecordController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register-hospital', [HospitalController::class, 'register']);
Route::put('/update-hospital/{id}', [HospitalController::class, 'update']);
Route::get('/get-hospital/{id}', [HospitalController::class, 'getHospital']);
Route::post('/register-patient', [PatientController::class, 'register']);
Route::put('/update-patient/{id}', [PatientController::class, 'update']);
Route::get('/get-patient/{id}', [PatientController::class, 'getPatient']);
Route::post('/register-patientrecord', [PatientRecordController::class, 'register']);
Route::put('/update-patientrecord/{id}', [PatientRecordController::class, 'update']);
Route::get('/get-patient-records', [PatientRecordController::class, 'getPatientRecords']);


