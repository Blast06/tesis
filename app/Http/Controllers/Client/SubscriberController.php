<?php

namespace App\Http\Controllers\Client;

use App\Website;
use App\Http\Controllers\Controller;
use App\DataTables\ClientSubscriberDataTable;

class SubscriberController extends Controller
{
    /**
     * SubscribersController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\ClientSubscriberDataTable $dataTable
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function index(ClientSubscriberDataTable $dataTable, Website $website)
    {
        $header = 'Todos los suscriptores de '. $website->name;
        $breadcrumb_name = 'subscriber';
        return $dataTable->render('datatables.index', compact('header', 'breadcrumb_name', 'website'));
    }
}
