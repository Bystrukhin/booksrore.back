<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetails;
use Illuminate\Http\Response;
use Stripe\Stripe;
use Stripe\Charge;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();

        if (!$orders) {
            return response()->json(['message' => 'Orders not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($orders, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $orders = OrderDetails::with('book')->get();

        $order = $orders->where('order_id', $id)->all();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($order, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Stripe::setApiKey("sk_test_password");

        $token = $request->input('token');
        $email = $request->input('email');
        $date = date("Y-m-d H:i:s");

        $products = json_decode($request->input('products'));
        $orderDetails = json_decode($request->input('form'));
        $price = 0;

        if (!empty($products && $orderDetails)) {

            foreach ($products as $item) {
                $price += $item->product->price * $item->quantity;
            }

            $order = new Order([
                'order_date' => $date,
                'total_price' => $price,
                'customer_email' => $email,
                'customer_first_name' => $orderDetails->firstName,
                'customer_second_name' => $orderDetails->secondName,
                'customer_id' => $orderDetails->user_id,
                'phone_number' => $orderDetails->phoneNumber,
                'address' => $orderDetails->address,
                'city' => $orderDetails->city,
                'postal_code' => $orderDetails->postalCode,
                'country' => $orderDetails->country,
            ]);
            $order->save();

            $order_id = Order::where('orders.customer_email', '=', $email)
                ->orderBy('orders.order_id', 'desc')
                ->first();

            foreach ($products as $product) {
                $order_details = new OrderDetails([
                    'quantity' => $product->quantity,
                    'price' => $product->product->price * $product->quantity,
                    'order_id' => $order_id->order_id,
                    'book_id' => $product->product->book_id,
                    'date' => $date,
                ]);
                $order_details->save();
            }

            $charge = Charge::create(array(
                "amount" => $price * 100,
                "currency" => "usd",
                "description" => "Example charge",
                "source" => $token,
            ));
        }

        if (!$charge) {
            return response()->json(['message' => 'Charge failed'], Response::HTTP_NOT_FOUND);
        }

        return response()->json('Charge successful, you get the course!', Response::HTTP_OK);

    }

    public function getOrdersByUser($id)
    {
        $orders = Order::where('customer_id', $id)
            ->get();

        if (!$orders) {
            return response()->json(['message' => 'Orders not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($orders, Response::HTTP_OK);
    }
}
