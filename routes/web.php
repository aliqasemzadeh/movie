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

    Route::get('/administrator/video-management/movie/index',  App\Livewire\Administrator\VideoManagement\Movie\Index::class)->name('administrator.video-management.movie.index');
    Route::get('/administrator/video-management/artist/index',  App\Livewire\Administrator\VideoManagement\Artist\Index::class)->name('administrator.video-management.artist.index');
    Route::get('/administrator/video-management/genre/index',  App\Livewire\Administrator\VideoManagement\Genre\Index::class)->name('administrator.video-management.genre.index');
    Route::get('/administrator/video-management/country/index',  App\Livewire\Administrator\VideoManagement\Country\Index::class)->name('administrator.video-management.country.index');
});

require_once __DIR__.'/auth.php';
