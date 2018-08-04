<?php

namespace App\Http\Controllers\Client;

use App\{Order, Website};
use App\Http\Controllers\Controller;
use App\DataTables\ClientOrderDataTable;
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
        $header = "Todas las ordenes de {$website->name}". $this->buttonsFilter();
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

    /**
     * @return string
     */
    public function buttonsFilter()
    {
        return "<form class='form-inline float-right' method=\"get\">
                  <div class=\"form-group\">
                    <select class=\"form-control\" name=\"status\">
                      <option value='TODOS'>Todos</option>
                      <option value='COMPLETADA'>Completado</option>
                      <option value='EN PROCESO'>En proceso</option>
                      <option value='EN ESPERA'>En espera</option>
                      <option value='CANCELADA'>Cancelado</option>
                    </select>
                  </div>
                  <button type=\"submit\" class=\"btn btn-primary ml-2\">Filtrar</button>
                </form>";
    }
}
