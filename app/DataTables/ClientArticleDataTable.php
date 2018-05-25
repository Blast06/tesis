<?php

namespace App\DataTables;

use App\{Article, Website};
use Yajra\DataTables\Services\DataTable;

class ClientArticleDataTable extends DataTable
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
            ->addColumn('action', 'datatables.action')
            ->addColumn('image_path', function (Article $product) {
                return '<img src='.$product->image_path.' class="img-thumbnail" />';
            })
            ->editColumn('price', function (Article $product){
                return number_format($product->price,2,'.',',');
            })
            ->editColumn('created_at', function(Article $product) {
                return $product->created_at->format('l j F Y');
            })
            ->editColumn('updated_at', function(Article $product) {
                return $product->updated_at->format('l j F Y');
            })
            ->rawColumns(['image_path','action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Article::category()->ownsWebsite(request()->website)->get();
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
            'id' => ['title' => 'Identificador', 'visible' => false, 'exportable' => false],
            'image_path' => ['title' => 'Imagen','exportable' => false],
            'name' => ['title' => 'Titulo'],
            'price' => ['title' => 'Precio'],
            'stock' => ['title' => 'Cantidad'],
            'sub_category.name' => ['title' => 'Categoria'],
            'status' => ['title' => 'Estatus'],
            'created_at' => ['title' => 'Fecha de creacion'],
            'updated_at'=> ['title' => 'Fecha actualización']
        ];
    }

    public function getTableName(Website $website)
    {
        return 'Todos los articulos de '. $website->name;
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Articles' . date('YmdHis');
    }
}
