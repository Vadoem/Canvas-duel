<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DirectionController;
use App\Http\Controllers\PracticeTypeController;
use App\Http\Controllers\EnterpriseInfoController;
use App\Http\Controllers\ЦехController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\EmployerPracticeController;
use App\Http\Controllers\Practice2Controller;
use App\Http\Controllers\HeroController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/practices', [PracticeController::class, 'store']);
Route::get('/practices', [PracticeController::class, 'index']);
Route::get('/students', [StudentController::class, 'index']);
Route::get('/students/export/xml', [StudentController::class, 'exportToXml']);
Route::get('/students/{id}', [StudentController::class, 'show']);
Route::post('/students', [StudentController::class, 'store']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'destroy']);
Route::get('/практики', [PracticeController::class, 'index']);
Route::post('/практики/{id}', [PracticeController::class, 'store']);
Route::put('/практики/{id}', [PracticeController::class, 'show']);
Route::delete('/практики/{id}', [PracticeController::class, 'update']);
Route::get('/groups', [GroupController::class, 'index']);
Route::get('/courses', [CourseController::class, 'index']);
Route::get('/directions', [DirectionController::class, 'index']);
Route::resource('practice-types', PracticeTypeController::class);
Route::get('enterprise', [EnterpriseInfoController::class, 'index']);
Route::post('enterprise', [EnterpriseInfoController::class, 'store']);
Route::post('/generate-excel-report/{studentId}', [StudentController::class, 'generateExcelReport']);
Route::post('/generate-excel-report2', [StudentController::class, 'generateExcelReport2']);
Route::post('/generate-document', [StudentController::class, 'generateDocument']);
Route::post('/generate-document2/{studentId}', [StudentController::class, 'generateDocument2']);
Route::post('/generate-document3/{studentId}', [StudentController::class, 'generateDocument3']);
Route::get('/цехи', [ЦехController::class, 'index']);
Route::get('/departments', [DepartmentController::class, 'index']);
Route::put('/departments/{id}', [DepartmentController::class, 'update']);
Route::post('/departments', [DepartmentController::class, 'store']);
Route::get('contracts', [ContractController::class, 'index']);
Route::post('contracts', [ContractController::class, 'store']);
Route::put('contracts/{id}', [ContractController::class, 'update']);
Route::get('employerpractice', [EmployerPracticeController::class, 'index']);
Route::post('employerpractice', [EmployerPracticeController::class, 'store']);
Route::put('employerpractice/{id}', [EmployerPracticeController::class, 'update']);
Route::get('/practices2/search', [Practice2Controller::class, 'search']);
Route::get('/export', 'ExportController@export');
Route::get('/heroes', [HeroController::class, 'index']);
Route::put('/heroes/{hero}', [HeroController::class, 'update']);


