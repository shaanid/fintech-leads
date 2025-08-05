<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\BankStatement\BankStatementController;
use App\Http\Controllers\Api\Dashboard\DashboardController;
use App\Http\Controllers\Api\Leads\LeadsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('import-leads', [LeadsController::class, 'importLeads']);
    Route::get('dashboard/summary', [DashboardController::class, 'summary']);
    Route::post('merchant/{id}/upload-bank-statement', [BankStatementController::class, 'uploadStatement']);
    Route::post('logout', [AuthController::class, 'logout']);
});
