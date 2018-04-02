<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publisher;
use Illuminate\Http\Response;

class PublisherController extends Controller
{
    public function getPublishers(Request $request)
    {
        $publishers = Publisher::get();

        if (!$publishers) {
            return response()->json(['message' => 'Publishers not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($publishers, Response::HTTP_OK);
    }

    public function getDeletePublisher($id)
    {
        Publisher::where('publishers.publisher_id', $id)
            ->delete();

        return response()->json("Publisher was deleted", Response::HTTP_OK);
    }

    public function getPublisher(Request $request, $id)
    {
        $publisher = Publisher::where('publishers.publisher_id', '=', $id)
            ->get();

        if (!$publisher) {
            return response()->json(['message' => 'Publisher not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($publisher, Response::HTTP_OK);
    }

    public function postEditPublisher(Request $request)
    {
        $id = $request->input('id', '');
        $name = $request->input('publisher_name', '');
        $address = $request->input('address', '');
        $city = $request->input('city', '');
        $country = $request->input('country', '');
        $date = date("Y-m-d H:i:s");

        $publisher = Publisher::where('publishers.publisher_id', $id)
            ->update(['publisher_name' => $name, 'address'=>$address, 'city'=>$city,
                'country'=>$country,'updated_at'=>$date]);

        if (!$publisher) {
            return response()->json(['message' => 'Publisher not edited'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([$publisher], Response::HTTP_OK);
    }

    public function postAddPublisher(Request $request)
    {
        $name = $request->input('publisher_name', '');
        $address = $request->input('address', '');
        $city = $request->input('city', '');
        $country = $request->input('country', '');
        $date = date("Y-m-d H:i:s");

        $publisher = Publisher::insert(['publisher_name' => $name, 'address'=>$address, 'city'=>$city,
                'country'=>$country,'created_at'=>$date]);

        if (!$publisher) {
            return response()->json(['message' => 'Publisher not added'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([$publisher], Response::HTTP_OK);
    }
}
