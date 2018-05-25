<?php

namespace App\Http\Controllers\Client;

use App\Website;
use App\Http\Controllers\Controller;
use App\DataTables\ClientArticleDataTable;
use App\Http\Requests\CreateArticleRequest;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\ClientArticleDataTable $dataTable
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function index(ClientArticleDataTable $dataTable, Website $website)
    {
        $header = $dataTable->getTableName($website);
        $breadcrumb_name = 'article';
        return $dataTable->render('datatables.index', compact('header', 'breadcrumb_name', 'website'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function create(Website $website)
    {
        return view('client.article.create', compact('website'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\CreateArticleRequest $request
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function store(CreateArticleRequest $request, Website $website)
    {
        return $this->responseOne($request->createProduct($website), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
