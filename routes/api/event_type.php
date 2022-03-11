<?php

Route::prefix('event-types')->middleware(
    'auth:api',
    'role:' . config('app.super_admin_role_name')
)->name('event-types.')->group(function () {
    Route::get('/{id}', 'Fetch\EventTypeFetchAction')->name('fetch');
    Route::get('/', 'Index\EventTypeIndexAction')->name('list');
    Route::post('/', 'Create\EventTypeCreateAction')->name('create');
    Route::put('/{id}', 'Edit\EventTypeEditAction')->name('edit');
    Route::delete('/{id}', 'Delete\EventTypeDeleteAction')->name('delete');
});
