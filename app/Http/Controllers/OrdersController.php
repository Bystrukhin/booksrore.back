<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetails;
use Illuminate\Http\Response;

class OrdersController extends Controller
{
    public function getOrders()
    {
        $orders = Order::all();

        if (!$orders) {
            return response()->json(['message' => 'Orders not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($orders, Response::HTTP_OK);
    }

    public function getOrderDetails($id)
    {
        $order = OrderDetails::where('order_id', $id)
                                ->join('books', 'order_details.book_id', '=', 'books.book_id')
                                ->select('order_details.*', 'books.title')
                                ->get();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($order, Response::HTTP_OK);
    }

    public function getOrdersByUser($id)
    {
        $orders = Order::where('user_id', $id)
            ->get();

        if (!$orders) {
            return response()->json(['message' => 'Orders not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($orders, Response::HTTP_OK);
    }
}
