<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request, OrderService $orderService)
    {
        $order = $orderService->createOrder($request->validated());

        return response()->json(['message' => 'Order created successfully!'], 201);
    }
}
