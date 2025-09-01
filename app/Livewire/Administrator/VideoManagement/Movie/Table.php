<?php

namespace App\Livewire\Administrator\VideoManagement\Movie;

use App\Models\VideoSystem\Movie;
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

    public string $tableName = 'administrator.video-management.movie.table';

    public function header(): array
    {
        return [
            Button::add('create-movie')
                ->slot(__('quickpanel.create_movie'))
                ->class('text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800')
                ->dispatch('modal-open', ['component' => 'administrator.video-management.movie.create']),
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
        $query = Movie::query();
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
            ->add('title')
            ->add('image', fn (Movie $model) => $model->image)
            ->add('image_html', fn (Movie $model) => sprintf("<img src='%s' alt='img' class='w-[60px] h-[40px] rounded object-cover' />", \Illuminate\Support\Facades\Storage::url($model->image)))
            ->add('duration_formatted', fn (Movie $model) => $this->formatDuration($model->duration))
            ->add('created_at_formatted', fn (Movie $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    private function formatDuration($minutes): string
    {
        $m = (int) $minutes;
        $h = intdiv($m, 60);
        $rem = $m % 60;
        if ($h > 0) {
            return sprintf('%dh %02dm', $h, $rem);
        }
        return sprintf('%dm', $rem);
    }

    public function columns(): array
    {
        return [
            Column::make(__('quickpanel.id'), 'id'),
            Column::make(__('quickpanel.image'), 'image_html'),
            Column::make(__('quickpanel.title'), 'title')
                ->sortable()
                ->searchable(),
            Column::make(__('quickpanel.duration'), 'duration_formatted', 'duration')
                ->sortable(),
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

    #[On('administrator.video-management.movie.table:delete-movie')]
    public function deleteMovie(int $movieId): void
    {
        if ($movie = Movie::find($movieId)) {
            $movie->delete();
            Toaster::success(__('quickpanel.movie_deleted'));
        }
        $this->dispatch('pg:eventRefresh-administrator.video-management.movie.table');
    }

    public function actions(Movie $row): array
    {
        return [

            Button::add('seasons')
                ->slot(__('quickpanel.seasons'))
                ->id()
                ->class('px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-indigo-700 rounded-lg hover:bg-indigo-800 focus:ring-4 focus:outline-none focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800')
                ->route('administrator.video-management.movie.season.index', ['movieId' => $row->id]),

            Button::add('files')
                ->slot(__('quickpanel.files'))
                ->id()
                ->class('px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-pink-700 rounded-lg hover:bg-pink-800 focus:ring-4 focus:outline-none focus:pink-blue-300 dark:bg-pink-600 dark:hover:bg-pink-700 dark:focus:ring-pink-800')
                ->route('administrator.video-management.movie.file.index', ['movieId' => $row->id]),

            Button::add('edit')
                ->slot(__('quickpanel.edit'))
                ->id()
                ->class('px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800')
                ->dispatch('modal-open', ['component' => 'administrator.video-management.movie.edit', 'props' => ['movieId' => $row->id]]),

            Button::add('delete')
                ->slot(__('quickpanel.delete'))
                ->id()
                ->class('px-3 py-2 text-xs font-medium text-center inline-flex items-center text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800')
                ->confirm(__('quickpanel.are_you_sure'))
                ->dispatch('administrator.video-management.movie.table:delete-movie', ['movieId' => $row->id]),
        ];
    }
}
