<?php

namespace App\Http\Controllers;

use App\Genre;
use App\Book;
use Illuminate\Http\Response;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $genres = Genre::all();

        if (!$genres) {
            return response()->json(['message' => 'Genres not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($genres, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $genre = Genre::where('genre_name', $id)->first();
        $books = Book::with('genre', 'category')->where('genre_id', $genre->genre_id)->get();

        if (!$books) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($books, Response::HTTP_OK);
    }
}
