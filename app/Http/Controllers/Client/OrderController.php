<?php

namespace App\Http\Controllers\Client;

use App\{
    DataTables\ClientOrderDataTable, Order, Website
};
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\DataTables\ClientOrderDataTable $dataTable
     * @param \App\Website $website
     * @return \Illuminate\Http\Response
     */
    public function index(ClientOrderDataTable $dataTable, Website $website)
    {
        $header = 'Todas las ordenes de '. $website->name;
        $breadcrumb_name = 'order';
        return $dataTable->render('datatables.index', compact('header', 'breadcrumb_name', 'website'));
    }

    public function update(UpdateOrderRequest $request, Website $website, Order $order)
    {
        return $this->showOne($request->updateOrder($order));
    }
}
