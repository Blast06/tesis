<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

    /**
     * @return mixed
     */
    public function index()
    {
        return auth()->user()
            ->orders()
            ->with(['article:id,name,slug', 'website'])
            ->orderByDesc('id')
            ->get();
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
