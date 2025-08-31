<?php

namespace App\Livewire\Administrator\UserManagement\Role;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Carbon;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;

final class Table extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'administrator.user-management.role.index';

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::exportable(fileName: $this->tableName."-".date("Y-m-d-H-i-s"))
                ->striped()
                ->type(\PowerComponents\LivewirePowerGrid\Components\SetUp\Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            PowerGrid::header()
                ->showSearchInput(),
            PowerGrid::footer()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function header(): array
    {
        return [
            Button::add('create-role')
                ->can(auth()->user()->can('administrator_user_role_create'))
                ->slot(__('quickpanel.create_role'))
                ->class('text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800')
                ->dispatch('modal-open', ['component' => 'administrator.user-management.role.create']),
        ];
    }

    public function datasource(): \Illuminate\Database\Eloquent\Builder
    {
        return Role::query();
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('guard_name')
            ->add('created_at_formatted', fn ($model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make(__('quickpanel.id'), 'id'),
            Column::make(__('quickpanel.name'), 'name')
                ->sortable()
                ->searchable(),

            Column::make(__('quickpanel.guard_name'), 'guard_name')
                ->sortable()
                ->searchable(),

            Column::make(__('quickpanel.created_at'), 'created_at_formatted', 'created_at')
                ->sortable(),
            Column::action(__('quickpanel.action'))

        ];
    }

    public function filters(): array
    {
        return [
            Filter::datetimepicker('created_at'),
        ];
    }

    #[\Livewire\Attributes\On('delete')]
    public function delete($id): void
    {
        if ($role = Role::findById($id)) {
            $role->delete();
            \Masmerise\Toaster\Toaster::success(__('quickpanel.role_deleted'));
        }
        $this->dispatch('pg:eventRefresh-administrator.user-management.role.index');
    }

    public function actions($row): array
    {
        return [
            Button::add('edit')
                ->slot(__('quickpanel.edit'))
                ->id()
                ->can(auth()->user()->can('administrator_user_role_edit'))
                ->class('px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800')
                ->dispatch('modal-open', ['component' => 'administrator.user-management.role.edit', 'props' => ['roleId' => $row->id]]),
            Button::add('users')
                ->slot(__('quickpanel.users'))
                ->id()
                ->can(auth()->user()->can('administrator_user_role_users'))
                ->class('px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-purple-700 rounded-lg hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800')
                ->dispatch('modal-open', ['component' => 'administrator.user-management.role.users', 'props' => ['id' => $row->id]]),
            Button::add('permissions')
                ->slot(__('quickpanel.permissions'))
                ->id()
                ->can(auth()->user()->can('administrator_user_role_permissions'))
                ->class('px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-teal-700 rounded-lg hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-teal-300 dark:bg-teal-600 dark:hover:bg-teal-700 dark:focus:ring-teal-800')
                ->dispatch('modal-open', ['component' => 'administrator.user-management.role.permissions', 'props' => ['id' => $row->id]]),
            Button::add('delete')
                ->slot(__('quickpanel.delete'))
                ->id()
                ->can(auth()->user()->can('administrator_user_role_delete'))
                ->class('px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800')
                ->confirm(__('quickpanel.are_you_sure'))
                ->dispatch('delete', ['id' => $row->id])

        ];
    }
}
