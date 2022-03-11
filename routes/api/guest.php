<?php

Route::prefix('guests')->middleware('auth:api', 'role:' . config('app.super_admin_role_name'))
    ->name('guests.')->group(function () {
        Route::post('/', 'Create\GuestCreateAction')->name('create');
        Route::put('/{id}', 'Edit\GuestEditAction')->name('edit');
        Route::delete('/{id}', 'Delete\GuestDeleteAction')->name('delete');
        Route::middleware('permission:read-guests')
            ->withoutMiddleware('role:' . config('app.super_admin_role_name'))->group(function () {
                Route::get('/{id}', 'Fetch\GuestFetchAction')->name('fetch');
                Route::get('/', 'Index\GuestIndexAction')->name('list');
                Route::get('/doorprize', 'IndexDoorprize\GuestIndexDoorprizeAction')->name('list.doorprize');
            });
    });
