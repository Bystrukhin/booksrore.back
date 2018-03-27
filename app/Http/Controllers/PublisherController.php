<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publisher;
use Illuminate\Support\Facades\DB;

class PublisherController extends Controller
{
    public function getPublishers(Request $request)
    {
        $publishers = DB::table('publishers')
            ->get();

        return response()->json($publishers, 200);
    }

    public function getDeletePublisher($id)
    {
        DB::table('publishers')
            ->where('publishers.publisher_id', $id)
            ->delete();

        return response()->json("Publisher was deleted", 200);
    }

    public function getPublisher(Request $request, $id)
    {
        $publisher = DB::table('publishers')
            ->where('publishers.publisher_id', '=', $id)
            ->get();

        if (!$publisher) {
            return response()->json(['message' => 'Publisher not found'], 404);
        }
        return response()->json($publisher, 200);
    }

    public function postEditPublisher(Request $request)
    {
        $id = $request->input('id', '');
        $name = $request->input('publisher_name', '');
        $address = $request->input('address', '');
        $city = $request->input('city', '');
        $country = $request->input('country', '');
        $date = date("Y-m-d H:i:s");

        $publisher = DB::table('publishers')
            ->where('publishers.publisher_id', $id)
            ->update(['publisher_name' => $name, 'address'=>$address, 'city'=>$city,
                'country'=>$country,'updated_at'=>$date]);

        return response()->json([$publisher], 200);
    }

    public function postAddPublisher(Request $request)
    {
        $name = $request->input('publisher_name', '');
        $address = $request->input('address', '');
        $city = $request->input('city', '');
        $country = $request->input('country', '');
        $date = date("Y-m-d H:i:s");

        $publisher = DB::table('publishers')
            ->insert(['publisher_name' => $name, 'address'=>$address, 'city'=>$city,
                'country'=>$country,'created_at'=>$date]);

        return response()->json([$publisher], 200);
    }
}
