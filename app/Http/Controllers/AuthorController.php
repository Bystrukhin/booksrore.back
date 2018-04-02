<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use Illuminate\Http\Response;

class AuthorController extends Controller
{
    public function getAuthors(Request $request)
    {
        $authors = Author::all();

        if (!$authors) {
            return response()->json(['message' => 'Authors not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($authors, Response::HTTP_OK);
    }

    public function getDeleteAuthor($id)
    {
        Author::where('authors.author_id', $id)
            ->delete();

        return response()->json("Author was deleted", Response::HTTP_OK);
    }

    public function getAuthor(Request $request, $id)
    {
        $author = Author::where('authors.author_id', '=', $id)
            ->get();

        if (!$author) {
            return response()->json(['message' => 'Author not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($author, Response::HTTP_OK);
    }

    public function postEditAuthor(Request $request)
    {
        $id = $request->input('id', '');
        $first_name = $request->input('first_name', '');
        $last_name = $request->input('last_name', '');
        $country = $request->input('country', '');
        $date = date("Y-m-d H:i:s");

        $author = Author::where('authors.author_id', $id)
            ->update(['first_name' => $first_name, 'last_name'=>$last_name,
                'country'=>$country,'updated_at'=>$date]);

        if (!$author) {
            return response()->json(['message' => 'Authors not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json([$author], Response::HTTP_OK);
    }

    public function postAddAuthor(Request $request)
    {
        $first_name = $request->input('first_name', '');
        $last_name = $request->input('last_name', '');
        $country = $request->input('country', '');
        $date = date("Y-m-d H:i:s");

        $author = Author::insert(['first_name' => $first_name, 'last_name'=>$last_name,
                'country'=>$country, 'created_at'=>$date]);

        if (!$author) {
            return response()->json(['message' => 'Author not added'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([$author], Response::HTTP_OK);
    }
}
