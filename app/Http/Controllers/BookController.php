<?php

namespace App\Http\Controllers;

use App\Book;
use App\Genre;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;

class BookController extends Controller
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
        $books = Book::with('genre', 'category')->get();
        return response()->json($books, Response::HTTP_OK);
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
            'title' => 'required',
            'description'=>'required',
            'isbn'=>'required',
            'publication_year'=>'required',
            'price'=>'required',
            'genre_id'=>'required',
            'category_id'=>'required',
            'stock_level'=>'required',
            'type_id'=>'required',
            'publisher_id'=>'required',
            'author_id'=>'required',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $input['imagename'] = $image->getClientOriginalName();
            $destinationPath = public_path('images/books');
            $image->move($destinationPath, $input['imagename']);
            $imagePath = 'images/books/' . $input['imagename'];
        } else {
            $imagePath = null;
        }

        $book = new Book([
            'title' => $request->input('title', ''),
            'description'=>$request->input('description', ''),
            'ISBN'=>$request->input('isbn', '11111'),
            'publication_year'=>$request->input('publication_year', null),
            'price'=>$request->input('price', null),
            'genre_id'=>$request->input('genre_id', null),
            'category_id'=>$request->input('category_id', null),
            'stock_level'=>$request->input('stock_level', null),
            'type_id'=>$request->input('type_id', null),
            'publisher_id'=>$request->input('publisher_id', null),
            'author_id'=>$request->input('author_id', null),
            'image'=>$imagePath,
            'created_at'=>date("Y-m-d H:i:s")
        ]);
        $book->save();

        if (!$book) {
            return response()->json(['message' => 'Book not added'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json($book, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (is_numeric($id)) {
            $books = Book::where('book_id', $id)->get();
        } else {
            $book = Book::with('genre', 'category')->get();
            $books = $book->where('category.category_name', $id)->all();
        }
        if (!$books) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($books, Response::HTTP_OK);
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
            'title' => 'required',
            'description'=>'required',
            'isbn'=>'required',
            'publication_year'=>'required',
            'price'=>'required',
            'genre_id'=>'required',
            'category_id'=>'required',
            'stock_level'=>'required',
            'type_id'=>'required',
            'publisher_id'=>'required',
            'author_id'=>'required',
        ]);

        $book_old_image = $request->input('book_old_image', '');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $input['imagename'] = $image->getClientOriginalName();
            $destinationPath = public_path('images/books');
            $image->move($destinationPath, $input['imagename']);
            File::delete(public_path($book_old_image));
            $imagePath = 'images/books/' . $input['imagename'];
        } else {
            $imagePath = $book_old_image;
        }

        $book = Book::find($request->input('id', null));
        $book->title = $request->input('title', '');
        $book->description = $request->input('description', '');
        $book->isbn = $request->input('isbn', '');
        $book->publication_year = $request->input('publication_year', null);
        $book->price = $request->input('price', null);
        $book->genre_id = $request->input('genre_id', null);
        $book->category_id = $request->input('category_id', null);
        $book->stock_level = $request->input('stock_level', null);
        $book->type_id = $request->input('type_id', null);
        $book->publisher_id = $request->input('publisher_id', null);
        $book->author_id = $request->input('author_id', null);
        $book->image = $imagePath;
        $book->created_at = date("Y-m-d H:i:s");
        $book->save();

        if (!$book) {
            return response()->json(['message' => 'Book not updated'], Response::HTTP_BAD_REQUEST);
        }
        return response()->json($book, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }

        File::delete(public_path($book->image));

        $book->delete();

        return response()->json("Book was deleted", Response::HTTP_OK);
    }

    public function bestsellers()
    {
        $books = Book::with('genre', 'category')
            ->orderBy('book_id', 'desc')
            ->take(5)
            ->get();

        if (!$books) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($books, Response::HTTP_OK);
    }

    public function search(Request $request, $term)
    {
        $books = Book::with('genre', 'category')
            ->where('title', 'LIKE', '%' . $term . '%')
            ->get();

        if (!$books) {
            return response()->json(['message' => 'Books not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($books, Response::HTTP_OK);
    }

}
