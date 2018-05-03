<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use Illuminate\Http\Response;

class AuthorController extends Controller
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
        $authors = Author::all();

        if (!$authors) {
            return response()->json(['message' => 'Authors not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($authors, Response::HTTP_OK);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required'
        ]);

        $author = new Author([
            'first_name' => $request->input('first_name', ''),
            'last_name' => $request->input('last_name', ''),
            'country' => $request->input('country', ''),
            'updated_at' => date("Y-m-d H:i:s")
        ]);
        $author->save();

        if (!$author) {
            return response()->json(['message' => 'Author not added'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([$author], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $author = Author::find($id);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json([$author], Response::HTTP_OK);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'country' => 'required'
        ]);

        $author = Author::find($request->input('id', null));
        $author->first_name = $request->input('first_name', '');
        $author->last_name = $request->input('last_name', '');
        $author->country = $request->input('country', '');
        $author->updated_at = date("Y-m-d H:i:s");
        $author->save();

        if (!$author) {
            return response()->json(['message' => 'Authors not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([$author], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy($author)
    {
        $author = Author::destroy($author);

        if (!$author) {
            return response()->json(['message' => 'Author not found'], Response::HTTP_NOT_FOUND);
        }
//
//        $author->delete();

        return response()->json("Author was deleted", Response::HTTP_OK);
    }
}
