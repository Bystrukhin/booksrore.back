<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Order;
use App\OrderDetails;
use Psy\Util\Json;
use Stripe\Charge;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function makePayment(Request $request)
    {
        Stripe::setApiKey("sk_test_LBeCYVixMsSJbw9E1vp54VXi");

        $token = $request->input('token');
        $email = $request->input('email');
        $date = date("Y-m-d H:i:s");

        $products = json_decode($request->input('products'));
        $orderDetails = json_decode($request->input('form'));
        $price = 0;

        foreach ($products as $item) {
            $price += $item->product->price * $item->quantity;
        }

        Order::insert(['order_date' => $date, 'total_price' => $price,
                'customer_email' => $email, 'customer_first_name' => $orderDetails->firstName,
                'customer_second_name' => $orderDetails->secondName, 'phone_number' => $orderDetails->phoneNumber,
                'address' => $orderDetails->address, 'city' => $orderDetails->city, 'postal_code' => $orderDetails->postalCode,
                'country' => $orderDetails->country]);

        $order_id = Order::where('orders.customer_email', '=', $email)
            ->orderBy('orders.order_id', 'desc')
            ->take(1)
            ->get();

        foreach ($products as $item) {
            foreach ($order_id as $order) {

                OrderDetails::insert(['quantity' => $item->quantity, 'price' => $item->product->price * $item->quantity,
                        'order_id' => $order->order_id, 'book_id' => $item->product->book_id, 'date' => $date]);
            }
        }

        $charge = Charge::create(array(
            "amount" => $price * 100,
            "currency" => "usd",
            "description" => "Example charge",
            "source" => $token,
        ));
        return response()->json('Charge successful, you get the course!', Response::HTTP_OK);
    }
}
