<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/videoconsultation', [\App\Http\Controllers\VideoconsultationController::class, 'videoconsultation'])
    ->name('videoconsultation');

Route::post('/videoconsultation/chat', [\App\Http\Controllers\VideoconsultationController::class, 'addChat'])
    ->name('addChat');

Route::post('/videoconsultation/evolution', [\App\Http\Controllers\VideoconsultationController::class, 'saveEvolution'])
    ->name('saveEvolution');

Route::get('/videoconsultation/files', [\App\Http\Controllers\VideoconsultationController::class, 'listFiles'])
    ->name('listFiles');

Route::post('/videoconsultation/files', [\App\Http\Controllers\VideoconsultationController::class, 'addFile'])
    ->name('addFile');

Route::get('/videoconsultation/files/{vc}/{id}', [\App\Http\Controllers\VideoconsultationController::class, 'downloadFile'])
    ->name('downloadFile');

Route::post('/videoconsultation/inicio', [\App\Http\Controllers\VideoconsultationController::class, 'setStart'])
    ->name('setStart');

Route::post('/videoconsultation/fin', [\App\Http\Controllers\VideoconsultationController::class, 'setFinish'])
    ->name('setFinish');

Route::post('/videoconsultation/attendance/patient', [\App\Http\Controllers\VideoconsultationController::class, 'setPatientAttendance'])
    ->name('setPatientAttendance');

Route::post('/videoconsultation/attendance/medic', [\App\Http\Controllers\VideoconsultationController::class, 'setMedicAttendance'])
    ->name('setMedicAttendance');

Route::post('/videoconsultation/ausence/medic', [\App\Http\Controllers\VideoconsultationController::class, 'unsetMedicAttendance'])
    ->name('unsetMedicAttendance');

Route::post('/videoconsultation/finished', [\App\Http\Controllers\VideoconsultationController::class, 'checkFinished'])
    ->name('checkFinished');

