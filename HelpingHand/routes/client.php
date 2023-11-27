<?php

use App\Http\Controllers\ClientUserController;
use Illuminate\Support\Facades\Route;

Route::group([

    'middleware' => ['LoginCheck'],
    'namespace' => 'Client',

], function () {
    

    Route::group([

        'middleware' => ['role:ClientAdmin'],
        'namespace' => 'Client',
        'prefix' => 'sub/user'

    ], function () {
        Route::get('/', [ClientUserController::class, 'index'])->name('sub_user');
        Route::get('/create', [ClientUserController::class, 'create'])->name('sub_user_add');
        Route::post('/create', [ClientUserController::class, 'store'])->name('sub_user_store');
        Route::post('/update', [ClientUserController::class, 'update'])->name('sub_user_update');
        Route::get('/{id}/edit', [ClientUserController::class, 'edit'])->name('sub_user_edit');
        Route::post('/delete', [ClientUserController::class, 'delete'])->name('sub_user_delete')->middleware('permission:Delete-Client');
       
    });
    
});