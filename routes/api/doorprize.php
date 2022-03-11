<?php

Route::prefix('doorprizes')
    ->middleware('auth:api', 'role:' . config('app.super_admin_role_name'))
    ->name('doorprizes.')->group(function () {
        Route::post('/', 'Create\DoorprizeCreateAction')->name('create');
        Route::get('/', 'Index\DoorprizeIndexAction')
            ->withoutMiddleware('role:' . config('app.super_admin_role_name'))
            ->middleware('permission:read-doorprize')->name('list');
        Route::delete('/{id}', 'Delete\DoorprizeDeleteAction')->name('delete');
        Route::post('/reset', 'Reset\DoorprizeResetAction')->name('reset');
    });
