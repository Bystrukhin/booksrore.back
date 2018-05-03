<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Publisher;
use Illuminate\Http\Response;

class PublisherController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.token')->only('update', 'destroy', 'store');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publishers = Publisher::all();

        if (!$publishers) {
            return response()->json(['message' => 'Publishers not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($publishers, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'publisher_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required'
        ]);

        $publisher = new Publisher([
            'publisher_name' => $request->input('publisher_name', ''),
            'address' => $request->input('address', ''),
            'city' => $request->input('city', ''),
            'country' => $request->input('country', ''),
            'created_at' => date("Y-m-d H:i:s")
        ]);
        $publisher->save();

        if (!$publisher) {
            return response()->json(['message' => 'Publisher not added'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json($publisher, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $publisher = Publisher::find($id);

        if (!$publisher) {
            return response()->json(['message' => 'Publisher not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json([$publisher], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'publisher_name' => 'required',
            'address' => 'required',
            'city' => 'required',
            'country' => 'required'
        ]);

        $publisher = Publisher::find($request->input('id', null));
        $publisher->publisher_name = $request->input('publisher_name', '');
        $publisher->address = $request->input('address', '');
        $publisher->city = $request->input('city', '');
        $publisher->country = $request->input('country', '');
        $publisher->updated_at = date("Y-m-d H:i:s");
        $publisher->save();

        if (!$publisher) {
            return response()->json(['message' => 'Publisher not edited'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json($publisher, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $publisher = Publisher::find($id);

        if (!$publisher) {
            return response()->json(['message' => 'Publisher not found though not deleted'], Response::HTTP_NOT_FOUND);
        }

        $publisher->delete();

        return response()->json("Publisher was deleted", Response::HTTP_OK);
    }
}
