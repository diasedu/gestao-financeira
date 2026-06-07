<?php

use App\Http\Controllers\FinanceController;
use Illuminate\Support\Facades\Route;

Route::post('/finance/save', [FinanceController::class, 'save']);
Route::get('/finance/get/{id}', [FinanceController::class, 'get'])->where('id', '[1-9]+');
Route::get('/finance/list', [FinanceController::class, 'list']);
Route::delete('/finance/delete/{id}', [FinanceController::class, 'delete'])->where('id', '[1-9]+');