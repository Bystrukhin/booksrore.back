<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetails;

class OrdersController extends Controller
{
    public function getOrders()
    {
        $orders = Order::all();
        return response()->json($orders, 200);
    }

    public function getOrderDetails($id)
    {
        $order = OrderDetails::where('order_id', $id)
                                ->join('books', 'order_details.book_id', '=', 'books.book_id')
                                ->select('order_details.*', 'books.title')
                                ->get();
        return response()->json($order, 200);
    }
}
