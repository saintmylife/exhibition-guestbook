<?php

Route::prefix('events')
    ->middleware('auth:api', 'role:' . config('app.super_admin_role_name'))
    ->name('events.')->group(function () {
        Route::post('/', 'Create\EventCreateAction')->name('create');
        Route::put('/{id}', 'Edit\EventEditAction')->name('edit');
        Route::put('/active/{id}', 'Active\EventActiveAction')->name('active');
        Route::delete('/{id}', 'Delete\EventDeleteAction')->name('delete');
        Route::middleware('permission:read-events')
            ->withoutMiddleware('role:' . config('app.super_admin_role_name'))
            ->group(function () {
                Route::get('/{id}', 'Fetch\EventFetchAction')->name('fetch');
                Route::get('/', 'Index\EventIndexAction')->name('list');
                Route::get('/dashboard', 'Dashboard\EventDashboardAction')->name('dashboard');
            });
    });
