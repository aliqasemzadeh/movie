<?php

namespace App\Livewire\Administrator\VideoManagement\Genre;

use App\Models\VideoSystem\Genre;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use Masmerise\Toaster\Toaster;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Facades\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridFields;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class Table extends PowerGridComponent
{
    use WithExport;

    public string $tableName = 'administrator.video-management.genre.table';


    public function header(): array
    {
        return [
            Button::add('create-genre')
                ->slot(__('quickpanel.create_genre'))
                ->class('text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800')
                ->dispatch('modal-open', ['component' => 'administrator.video-management.genre.create']),
        ];
    }

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            PowerGrid::header()->showSearchInput(),
            PowerGrid::footer()->showPerPage()->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        $query = Genre::query();
        return $query;
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function fields(): PowerGridFields
    {
        return PowerGrid::fields()
            ->add('id')
            ->add('name')
            ->add('created_at_formatted', fn (Genre $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make(__('quickpanel.id'), 'id'),
            Column::make(__('quickpanel.name'), 'name')
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

    #[On('administrator.video-management.genre.table:delete-genre')]
    public function deleteGenre(int $genreId): void
    {
        if ($genre = Genre::find($genreId)) {
            $genre->delete();
            Toaster::success(__('quickpanel.genre_deleted'));
        }
        $this->dispatch('pg:eventRefresh-administrator.video-management.genre.table');
    }

    public function actions(Genre $row): array
    {
        return [
            Button::add('edit')
                ->slot(__('quickpanel.edit'))
                ->id()
                ->class('px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800')
                ->dispatch('modal-open', ['component' => 'administrator.video-management.genre.edit', 'props' => ['genreId' => $row->id]]),

            Button::add('delete')
                ->slot(__('quickpanel.delete'))
                ->id()
                ->class('px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800')
                ->confirm(__('quickpanel.are_you_sure'))
                ->dispatch('administrator.video-management.genre.table:delete-genre', ['genreId' => $row->id]),
        ];
    }
}
