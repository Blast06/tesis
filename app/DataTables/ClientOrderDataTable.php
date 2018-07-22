<?php

namespace App\DataTables;

use App\Order;
use Yajra\DataTables\Services\DataTable;

class ClientOrderDataTable extends DataTable
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
            ->addColumn('action', function(Order $order){
                return view('datatables.action_orders', compact('order'));
            })
            ->editColumn('price', function (Order $order){
                if (is_null($order->price)) {
                    return 'Sin especificar';
                }
                return number_format($order->price,2,'.',',');
            })
            ->addColumn('Iva', function (Order $order) {
                if (is_null($order->price)) {
                    return 'Sin especificar';
                }
                return number_format($order->price * 0.18,2,'.',',');
            })
            ->addColumn('Total', function (Order $order) {
                if (is_null($order->price)) {
                    return 'Sin especificar';
                }
                return number_format($order->price * ($order->price * 0.18),2,'.',',');
            })
            ->editColumn('status', function (Order $order) {
                return $this->articleBadgeStatus($order);
            })
            ->editColumn('created_at', function(Order $order) {
                return $order->created_at->format('l j F Y');
            })
            ->editColumn('updated_at', function(Order $order) {
                return $order->updated_at->format('l j F Y');
            })
            ->rawColumns(['status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return request()->website->orders()
            ->with(['user', 'article'])
            ->orderByDesc('id')
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
                    ->addAction(['width' => '80px', 'title' => 'Acciones', 'printable' => false, 'exportable' => false])
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
            'id' => ['title' => 'Identificador', 'visible' => false, 'exportable' => false, 'printable' => false,],
            'article.name' => ['title' => 'Articulo'],
            'user.name' => ['title' => 'Cliente'],
            'price' => ['title' => 'Precio'],
            'quantity' => ['title' => 'Cantidad'],
            'Iva',
            'Total',
            'status' => ['title' => 'Estatus'],
            'created_at' => ['title' => 'Fecha de creacion'],
            'updated_at'=> ['title' => 'Fecha actualización']
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'ClientOrder_' . date('YmdHis');
    }

    private function articleBadgeStatus(Order $order)
    {
        $array = [
            Order::STATUS_WAIT => 'badge-warning',
            Order::STATUS_CURRENT => 'badge-primary',
            Order::STATUS_COMPLETE => 'badge-success',
            Order::STATUS_CANCEL => 'badge-danger',
        ];

        return "<span class=\"badge {$array[$order->status]}\">{$order->status}</span>";
    }
}
