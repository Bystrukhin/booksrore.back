<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function getAuthors(Request $request)
    {
        $authors = DB::table('authors')
            ->get();

        return response()->json($authors, 200);
    }

    public function getDeleteAuthor($id)
    {
        DB::table('authors')
            ->where('authors.author_id', $id)
            ->delete();

        return response()->json("Author was deleted", 200);
    }

    public function getAuthor(Request $request, $id)
    {
        $author = DB::table('authors')
            ->where('authors.author_id', '=', $id)
            ->get();

        if (!$author) {
            return response()->json(['message' => 'Author not found'], 404);
        }
        return response()->json($author, 200);
    }

    public function postEditAuthor(Request $request)
    {
        $id = $request->input('id', '');
        $first_name = $request->input('first_name', '');
        $last_name = $request->input('last_name', '');
        $country = $request->input('country', '');
        $date = date("Y-m-d H:i:s");

        $author = DB::table('authors')
            ->where('authors.author_id', $id)
            ->update(['first_name' => $first_name, 'last_name'=>$last_name,
                'country'=>$country,'updated_at'=>$date]);

        return response()->json([$author], 200);
    }

    public function postAddAuthor(Request $request)
    {
        $first_name = $request->input('first_name', '');
        $last_name = $request->input('last_name', '');
        $country = $request->input('country', '');
        $date = date("Y-m-d H:i:s");

        $author = DB::table('authors')
            ->insert(['first_name' => $first_name, 'last_name'=>$last_name,
                'country'=>$country, 'created_at'=>$date]);

        return response()->json([$author], 200);
    }
}
