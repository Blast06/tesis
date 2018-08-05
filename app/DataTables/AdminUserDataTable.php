<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;

class AdminUserDataTable extends DataTable
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
            ->editColumn('verified_at', function(User $user) {
                if ($user->verified_at) {
                    return date("l j F Y", strtotime($user->verified_at));
                }
                return "Cuenta no verificada";
            })
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
     * @return \App\User[]|\Illuminate\Database\Eloquent\Collection
     */
    public function query()
    {
        return User::withCount('websites')
            ->get();
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
            'id' => ['title' => 'Identificador'],
            'name' => ['title' => 'Nombre'],
            'email' => ['title' => 'Correo electrónico'],
            'websites_count' => ['title' => 'Sitios webs'],
            'verified_at' => ['title' => 'Fecha de verificacion'],
            'created_at' => ['title' => 'Fecha de creacion'],
            'updated_at' => ['title' => 'Fecha de actualizacion']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'AdminUser_' . date('YmdHis');
    }
}
