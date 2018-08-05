<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class ClientSubscriberDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->editColumn('created_at', function(User $user) {
                return $user->created_at->format('l j F Y');
            })
            ->editColumn('updated_at', function(User $user) {
                return $user->updated_at->format('l j F Y');
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return request()->website->subscribedUsers()->withCount('orders')->get();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->parameters($this->getBuilderParameters());
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['title' => 'Identificador', 'visible' => false, 'exportable' => false, 'printable' => false],
            'name' => ['title' => 'Suscriptor'],
            'email' => ['title' => 'correo electrónico'],
            'orders_count' => ['title' => 'Ordenes realizadas'],
            'created_at' => ['title' => 'Fecha de creacion'],
            'updated_at'=> ['title' => 'Fecha de actualización']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ClientSubscribers_' . date('YmdHis');
    }
}
