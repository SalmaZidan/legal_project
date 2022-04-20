<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\IssueController;
use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Support\Facades\Auth;

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
Route::post('/login',[AuthController::class, 'login']);
Route::post('reset-password-email',[AuthController::class, 'resetPassword']);
Route::post('reset-code-email',[AuthController::class, 'resetCode']);
Route::post('code-check',[AuthController::class, 'checkCode']);
Route::post('change-code',[AuthController::class, 'changeCode']);
Route::post('change-password',[AuthController::class, 'changePassword']);

Route::middleware(["auth:api"])->group(function () {
    // Auth
    Route::post('confirm-code',[AuthController::class, 'confirmCode']);


    // Agent
    Route::post('agent-add',[AgentController::class, 'add']);
    Route::get('agent-list',[AgentController::class, 'list']);
    Route::get('agent-info/{id}',[AgentController::class, 'info']); 


    // Issue
    Route::post('case-add',[IssueController::class, 'add']);

    // Employee
    Route::post('employee-add',[EmployeeController::class, 'add']);
    Route::get('employee-list',[EmployeeController::class, 'list']);
    Route::post('employee-add-case',[EmployeeController::class, 'addCase']);


});