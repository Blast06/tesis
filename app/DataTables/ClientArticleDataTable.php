<?php

namespace App\DataTables;

use App\Article;
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
            ->addColumn('action', function(Article $article){
                return view('datatables.action_articles', compact('article'));
            })
            ->addColumn('image_path', function (Article $article) {
                return '<img src='.$article->image_path.' class="rounded" width="100" height="100" />';
            })
            ->addColumn('status', function (Article $article) {
                return $this->articleBadgeStatus($article);
            })
            ->editColumn('price', function (Article $article){
                return number_format($article->price,2,'.',',');
            })
            ->editColumn('stock', function (Article $article){
                if (is_null($article->stock)){
                    return 'Sin especificar';
                }
                return $article->stock;
            })
            ->editColumn('created_at', function(Article $product) {
                return $product->created_at->format('l j F Y');
            })
            ->editColumn('updated_at', function(Article $product) {
                return $product->updated_at->format('l j F Y');
            })
            ->rawColumns(['image_path', 'status', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return Article::with(['subCategory'])->where('website_id', request()->website->id)->get();
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
            'image_path' => ['title' => 'Imagen','exportable' => false, 'printable' => false,],
            'name' => ['title' => 'Titulo'],
            'price' => ['title' => 'Precio'],
            'stock' => ['title' => 'Cantidad'],
            'sub_category.name' => ['title' => 'Categoria'],
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
        return 'ClientArticle_' . date('YmdHis');
    }

    private function articleBadgeStatus(Article $article)
    {
        $array = [
            Article::STATUS_AVAILABLE => 'badge-success',
            Article::STATUS_NOT_AVAILABLE => 'badge-danger',
            Article::STATUS_PRIVATE => 'badge-primary',
        ];

        return "<span class=\"badge {$array[$article->status]}\">{$article->status}</span>";
    }
}
