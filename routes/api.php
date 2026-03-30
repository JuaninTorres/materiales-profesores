<?php

use App\Http\Controllers\Api\MaterialApiController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:5,1'])->group(function () {
    Route::get('/materiales', [MaterialApiController::class, 'index'])->name('api.materiales.index');
    Route::post('/materiales', [MaterialApiController::class, 'store'])->name('api.materiales.store');
    Route::put('/materiales/{material}', [MaterialApiController::class, 'update'])->name('api.materiales.update');
});
