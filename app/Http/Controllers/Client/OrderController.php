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

    /**
     * @param \App\Website $website
     * @param \App\Order $order
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Website $website, Order $order)
    {
        abort_unless($order->isRegisteredIn($website), 404);
        return view('client.order.edit', compact('order', 'website'));
    }

    /**
     * @param \App\Http\Requests\UpdateOrderRequest $request
     * @param \App\Website $website
     * @param \App\Order $order
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateOrderRequest $request, Website $website, Order $order)
    {
        abort_unless($order->isRegisteredIn($website), 404);
        return $this->showOne($request->updateOrder($order));
    }
}
