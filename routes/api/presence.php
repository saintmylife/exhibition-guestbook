<?php

Route::prefix('presences')->name('presences.')->group(function () {
    Route::post('/scan/{code}', 'Create\PresenceCreateAction')
        ->middleware('permission:scan-presences')
        ->name('create');
    Route::middleware('permission:read-presences')->group(function () {
        Route::get('/{id}', 'Fetch\PresenceFetchAction')->name('fetch');
        Route::get('/', 'Index\PresenceIndexAction')->name('list');
    });
    Route::middleware('role:' . config('app.super_admin_role_name'))->group(function () {
        Route::put('/{id}', 'Edit\PresenceEditAction')->name('edit');
        Route::delete('/{id}', 'Delete\PresenceDeleteAction')->name('delete');
        Route::post('/reset', 'Reset\PresenceResetAction')->name('reset');
    });
});
