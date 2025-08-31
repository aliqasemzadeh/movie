<?php

namespace App\Livewire\Administrator\SettingManagement\Function;

use Illuminate\Support\Facades\Artisan;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class Index extends Component
{
    public function updatePermissions()
    {
        $this->authorize('administrator_setting_function_index');
        Artisan::call('system:administrator:create-permissions-command');
        Toaster::success(__('quickpanel.permissions_updated'));
    }
    #[Layout('layouts.administrator')]
    public function render()
    {
        return view('livewire.administrator.setting-management.function.index');
    }
}
