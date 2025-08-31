<?php

use Illuminate\Support\Facades\Route;

Route::get('/', App\Livewire\Front\Home\Index::class)->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/user/dashboard/index', App\Livewire\User\Dashboard\Index::class)->name('user.dashboard.index');
    Route::get('/user/setting/profile/index', App\Livewire\User\Setting\Profile\Index::class)->name('user.setting.profile.index');
    Route::get('/user/setting/password/index', App\Livewire\User\Setting\Password\Index::class)->name('user.setting.password.index');


    Route::get('/administrator/dashboard/index', App\Livewire\Administrator\Dashboard\Index::class)->name('administrator.dashboard.index');
    Route::get('/administrator/user-management/user/index', App\Livewire\Administrator\UserManagement\User\Index::class)->name('administrator.user-management.user.index');
    Route::get('/administrator/user-management/role/index', App\Livewire\Administrator\UserManagement\Role\Index::class)->name('administrator.user-management.role.index');
    Route::get('/administrator/user-management/permission/index', App\Livewire\Administrator\UserManagement\Permission\Index::class)->name('administrator.user-management.permission.index');

    Route::get('/administrator/setting-management/option/index', App\Livewire\Administrator\SettingManagement\Option\Index::class)->name('administrator.setting-management.option.index');
    Route::get('/administrator/setting-management/function/index', App\Livewire\Administrator\SettingManagement\Function\Index::class)->name('administrator.setting-management.function.index');
});

require_once __DIR__.'/auth.php';
