<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        if (!$categories) {
            return response()->json(['message' => 'Categories not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($categories, Response::HTTP_OK);
    }
}
