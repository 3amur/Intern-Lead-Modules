<?php

namespace Modules\PotentialCustomer\app\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\PotentialCustomer\app\Models\FamilyMember;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;

class FamilyMembersDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        $potentialAccounts = LeadAccount::where('condition','potential')->where('created_by',auth()->id())->pluck('id')->toArray();
            $userId = auth()->id();
            return (new EloquentDataTable($query

            /* ->whereIn('potential_account_id',$potentialAccounts) */
            ->whereRaw("potential_account_id in(select id from lead_accounts where deleted_at is null and created_by = ? )",[$userId])

            ))
            ->addColumn('actions', function ($model) {
                $html = '<div class="font-sans-serif btn-reveal-trigger position-static">
            <button class="btn btn-sm dropdown-toggle dropdown-caret-none transition-none btn-reveal fs--2"
            type="button" data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false" data-bs-reference="parent">
                <i class="fa-solid fa-ellipsis-vertical fa-xl"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end py-2">';
                if (Helpers::perUser('family_members.edit')) {
                    $html .= '<a href="' . route('family_members.edit', ['family_member' => $model]) . '" class="dropdown-item">Edit</a>';
                }
                if (Helpers::perUser('family_members.destroy')) {
                    $html .= '<div class="dropdown-divider"></div><a href="#" class="dropdown-item text-danger delete-this-family_member" data-id="' . $model->id . '" data-url="' . route('family_members.destroy', ['family_member' => $model]) . '">Delete</a></div></div>';
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

                ->editColumn('name', function ($model) {
                    return $model->name;
                })

                ->editColumn('phone', function ($model) {
                    return $model->phone;
                })
                ->addColumn('potential_account', function ($model) {
                    return $model->potentialAccount->account_name;
                })
                ->addColumn('relationship', function ($model) {
                    return $model->relationshipType->name;
                })
                ->addColumn('date_of_birth', function ($model) {
                    return $model->birth_date;
                })

                ->editColumn('national_id', function ($model) {
                    return $model->national_id;
                })

                ->addColumn('national_id_card', function ($model) {
                    return '<img width="100px" height:"100px" src="' . asset('storage/' . $model->national_id_card) . '" >';
                })

                ->addColumn('image', function ($model) {
                    return '<img width="100px" height:"100px" src="' . asset('storage/' . $model->personal_image) . '" >';
                })

                ->editColumn('created_at', function ($model) {
                    return $model->created_at->format('Y-m-d H:i:s');
                })

                ->editColumn('updated_at', function ($model) {
                    return $model->updated_at->format('Y-m-d H:i:s');
                })
                ->rawColumns(['image', 'national_id_card','actions','status'])
                ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(FamilyMember $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('familymembers-table')
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
            Column::make('name')->addClass('text-center'),
            Column::make('relationship')->addClass('text-center'),
            Column::make('potential_account')->addClass('text-center'),
            Column::make('phone')->addClass('text-center'),
            Column::make('national_id')->addClass('text-center'),
            Column::make('birth_date')->addClass('text-center'),
            Column::make('image')->addClass('text-center'),
            Column::make('national_id_card')->addClass('text-center'),
            Column::make('status')->addClass('text-center'),
            Column::make('created_at')->addClass('text-center'),
            Column::make('updated_at')->addClass('text-center'),
            Column::computed('actions')
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
        return 'FamilyMembers_' . date('YmdHis');
    }
}
