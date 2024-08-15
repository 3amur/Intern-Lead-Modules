<?php

namespace Modules\PotentialCustomer\app\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Modules\PotentialCustomer\app\Models\Department;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class DepartmentsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query->where('created_by',auth()->id())->orderBy('id', 'asc')))
        ->addColumn('action', function ($model) {
            $html = '<div class="font-sans-serif btn-reveal-trigger position-static">
            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
            type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                <i class="fa-solid fa-ellipsis-vertical fa-xl"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end py-2">';
            if (Helpers::perUser('departments.edit')) {
                $html .= '<a href="' . route('departments.edit', ['department' => $model]) . '" class="dropdown-item">Edit</a>';
            }
            if (Helpers::perUser('departments.destroy')) {
                $html .= '<div class="dropdown-divider"></div><a href="#" class="dropdown-item text-danger delete-this-department" data-id="' . $model->id . '" data-url="' . route('departments.destroy', ['department' => $model]) . '">Delete</a></div></div>';
            }
            return $html;
        })

        ->editColumn('status', function ($model) {
            if ($model->status == 'active') {
                return '<i class="fas fa-circle fa-sm mx-2 text-success"></i>' . ucfirst($model->status);
            } elseif ($model->status == 'inactive') {
                return '<i class="fas fa-circle fa-sm mx-2 text-secondary"></i>' . ucfirst($model->status);
            } else {
                return '<i class="fas fa-circle fa-sm mx-2 text-warning"></i>' . ucfirst($model->status);
            }
        })

        ->editColumn('title', function ($model) {
            return $model->title;
        })
            ->editColumn('description', function ($model) {
                return $model->description;
            })

            ->editColumn('created_at', function ($model) {
                return $model->created_at?$model->created_at->format('Y-m-d H:i:s'):null;
            })

            ->editColumn('updated_at', function ($model) {
                return $model->updated_at?$model->updated_at->format('Y-m-d H:i:s'):null;
            })
            ->rawColumns([ 'action','status'])

            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Department $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('departments-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    /* ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]) */;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->addClass('text-center'),
            Column::make('title')->addClass('text-center'),
            Column::make('description')->addClass('text-center'),
            Column::make('status')->addClass('text-center'),
            Column::make('created_at')->addClass('text-center'),
            Column::make('updated_at')->addClass('text-center'),
            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Departments_' . date('YmdHis');
    }
}
