<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderUpdateRequest;
use App\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $orders = Order::query()
            ->orderByDesc('created_at')
            ->paginate();

        return view('orders.list', ['list' => $orders]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order): View
    {
        $order->load('user');
        $order->load('items');
        $order->load('items.product');

        return view('orders.show', ['order' => $order]);
    }

    public function edit(Order $order): View
    {
        $order->load('items');
        $order->load('items.product');

        return view('orders.form', ['item' => $order]);
    }

    public function update(OrderUpdateRequest $request, Order $order): RedirectResponse
    {
        $order->update($request->getData());

        return redirect()->route('orders.index')
            ->with('status', 'Order updated successfully!');
    }


}
