<?php

Route::prefix('participants')
    ->middleware('auth:api', 'role:' . config('app.super_admin_role_name'))
    ->name('participants.')->group(function () {
        Route::post('/', 'Create\EventParticipantCreateAction')->name('create');
        Route::put('/{id}', 'Edit\EventParticipantEditAction')->name('edit');
        Route::delete('/{id}', 'Delete\EventParticipantDeleteAction')->name('delete');
        Route::middleware('permission:read-events')
            ->withoutMiddleware('role:' . config('app.super_admin_role_name'))->group(function () {
                Route::get('/{id}', 'Fetch\EventParticipantFetchAction')->name('fetch');
                Route::get('/', 'Index\EventParticipantIndexAction')->name('list');
            });
    });
