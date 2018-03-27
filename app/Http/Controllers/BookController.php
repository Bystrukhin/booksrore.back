<?php

namespace App\Http\Controllers;

use App\Book;
use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{

    public function getBooks()
    {
        $books = Book::all();
        return response()->json($books, 200);
    }

    public function getBooksByGenre(Request $request, $genre)
    {
        $books = DB::table('books')
            ->leftJoin('genre', 'books.genre_id', '=', 'genre.genre_id')
            ->where('genre.genre_name', '=', $genre)
            ->leftJoin('categories','genre.category_id', '=', 'categories.category_id')
            ->get();

        if (!$books) {
            return response()->json(['message' => 'News not found'], 404);
        }
        return response()->json($books, 200);
    }

    public function getBooksByCategory(Request $request, $category)
    {
        $books = DB::table('books')
            ->leftJoin('genre', 'books.genre_id', '=', 'genre.genre_id')
            ->leftJoin('categories','genre.category_id', '=', 'categories.category_id')
            ->where('categories.category_name', '=', $category)
            ->get();

        if (!$books) {
            return response()->json(['message' => 'News not found'], 404);
        }
        return response()->json($books, 200);
    }

    public function getBookById(Request $request, $id)
    {
        $book = DB::table('books')
            ->where('books.book_id', '=', $id)
            ->get();

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($book, 200);
    }

    public function getGenres(Request $request)
    {
        $genre = DB::table('genre')
            ->get();

        return response()->json($genre, 200);
    }

    public function getBestsellers()
    {
        $books = DB::table('books') //TODO use Model class ex. Book::select()->where()->orderBy()->get()
            ->orderBy('book_id', 'desc')
            ->take(5)
            ->get();

        if (!$books) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($books, 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllBooks()
    {
        $books = DB::table('books')
            ->get();

        if (!$books) {
            return response()->json(['message' => 'Book not found'], 404);
        }
        return response()->json($books, 200);
    }

    public function getDeleteBook($id)
    {
        $book = DB::table('books')
            ->where('books.book_id', $id)
            ->get();

        foreach ($book as $item) {
            File::delete(public_path($item->image));
        }

        DB::table('books')
            ->where('books.book_id', $id)
            ->delete();

        return response()->json("Book was deleted", 200);
    }

    public function postEditBook(Request $request)
    {
        $id = $request->input('id', '');
        $title = $request->input('title', '');
        $description = $request->input('description', '');
        $isbn = $request->input('isbn', '');
        $publication_year = $request->input('publication_year', '');
        $price = $request->input('price', '');
        $genre_id = $request->input('genre_id', '');
        $stock_level = $request->input('stock_level', '');
        $type_id = $request->input('type_id', '');
        $publisher_id = $request->input('publisher_id', '');
        $author_id = $request->input('author_id', '');
        $date = date("Y-m-d H:i:s");
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

        $book = DB::table('books')
            ->where('books.book_id', $id)
            ->update(['title' => $title, 'description'=>$description, 'isbn'=>$isbn, 'publication_year'=>$publication_year,
                'price'=>$price, 'genre_id'=>$genre_id, 'stock_level'=>$stock_level, 'type_id'=>$type_id,
                'publisher_id'=>$publisher_id, 'author_id'=>$author_id, 'image'=>$imagePath, 'updated_at'=>$date]);

        return response()->json([$book], 200);
    }

    public function postAddBook(Request $request)
    {
        $id = $request->input('id', '');
        $title = $request->input('title', '');
        $description = $request->input('description', '');
        $isbn = $request->input('isbn', '');
        $publication_year = $request->input('publication_year', '');
        $price = $request->input('price', '');
        $genre_id = $request->input('genre_id', '');
        $stock_level = $request->input('stock_level', '');
        $type_id = $request->input('type_id', '');
        $publisher_id = $request->input('publisher_id', '');
        $author_id = $request->input('author_id', '');
        $date = date("Y-m-d H:i:s");

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $input['imagename'] = $image->getClientOriginalName();
            $destinationPath = public_path('images/books');
            $image->move($destinationPath, $input['imagename']);
            $imagePath = 'images/books/' . $input['imagename'];
        } else {
            $imagePath = null;
        }

        $book = DB::table('books')
            ->insert(['title' => $title, 'description'=>$description, 'isbn'=>$isbn, 'publication_year'=>$publication_year,
                'price'=>$price, 'genre_id'=>$genre_id, 'stock_level'=>$stock_level, 'type_id'=>$type_id,
                'publisher_id'=>$publisher_id, 'author_id'=>$author_id, 'image'=>$imagePath, 'created_at'=>$date]);

        return response()->json([$book], 200);
    }

}
