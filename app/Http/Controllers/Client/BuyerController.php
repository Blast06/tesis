<?php

namespace App\Http\Controllers\Client;

use App\Website;
use App\Http\Controllers\Controller;
use App\DataTables\ClientBuyerDataTable;

class BuyerController extends Controller
{
    /**
     * BuyerController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\ClientBuyerDataTable $dataTable
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function index(ClientBuyerDataTable $dataTable, Website $website)
    {
        $header = 'Todos los compradores de '. $website->name;
        $breadcrumb_name = 'buyer';
        return $dataTable->render('datatables.index', compact('header', 'breadcrumb_name', 'website'));
    }
}
