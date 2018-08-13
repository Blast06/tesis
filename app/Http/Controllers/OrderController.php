<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * OrderController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $orders = auth()->user()
            ->orders()
            ->with(['article:id,name,slug', 'website'])
            ->orderByDesc('id')
            ->paginate();

        return view('pages.order', compact('orders'));
    }

    /**
     * @param \App\Http\Requests\CreateOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateOrderRequest $request)
    {
        return $this->successResponse(['data' => $request->createOrders()], Response::HTTP_CREATED);
    }
}
