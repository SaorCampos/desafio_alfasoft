<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('api.jwt')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login'])->withoutMiddleware(['api.jwt'])->name('auth.login');
        Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
    });
    Route::prefix('contact')->group( function () {
        Route::get('/', [ContactController::class, 'getAllContacts'])->withoutMiddleware(['api.jwt'])->name('contact.listing');
        Route::get('/{id}', [ContactController::class, 'getContactById'])->withoutMiddleware(['api.jwt'])->name('contact.byId');
        Route::post('/create', [ContactController::class, 'createContact'])->name('contact.create');
        Route::put('/update/{id}', [ContactController::class, 'updateContact'])->name('contact.update');
        Route::delete('/delete/{id}', [ContactController::class, 'deleteContact'])->name('contact.delete');
    });
});
