<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AgentController;
use App\Http\Controllers\Api\IssueController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\CourtController;
use App\Http\Controllers\Api\GovernorateController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\OfficeAccountsController;
use App\Http\Controllers\Api\IssueAccountsController;
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
    Route::post('employee-delete-case',[EmployeeController::class, 'deleteCase']);
    Route::get('employee-profile/{id}',[EmployeeController::class, 'profile']);

    // Court
    Route::get('court-list',[CourtController::class, 'list']);
    Route::get('court-filter/{id}',[CourtController::class, 'filterByGovernorate']);


    // Governorate
    Route::get('governorate-list',[GovernorateController::class, 'list']);


    // User
    Route::post('user-edit-profile',[UserController::class, 'editProfile']);


    // Office Accounts 
    Route::post('office-accounts-add',[OfficeAccountsController::class, 'add']);
    Route::get('office-accounts-list',[OfficeAccountsController::class, 'list']);

    // Issue Accounts 
    Route::post('case-accounts-add',[IssueAccountsController::class, 'add']);
    Route::get('cases-accounts-list',[IssueAccountsController::class, 'list']);
    Route::get('case-accounts-list/{id}',[IssueAccountsController::class, 'singleIssueList']);
    Route::get('agent-case-accounts-list/{id}',[IssueAccountsController::class, 'agentList']);

});