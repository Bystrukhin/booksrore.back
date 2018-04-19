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

    public function getBooks()
    {
        $books = Book::all();
        return response()->json($books, Response::HTTP_OK);
    }

    public function getBooksByGenre(Request $request, $genre)
    {
        $books = Book::leftJoin('genre', 'books.genre_id', '=', 'genre.genre_id')
            ->where('genre.genre_name', '=', $genre)
            ->leftJoin('categories','genre.category_id', '=', 'categories.category_id')
            ->get();

        if (!$books) {
            return response()->json(['message' => 'Books not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($books, Response::HTTP_OK);
    }

    public function getBooksByCategory(Request $request, $category)
    {
        $books = Book::leftJoin('genre', 'books.genre_id', '=', 'genre.genre_id')
            ->leftJoin('categories','genre.category_id', '=', 'categories.category_id')
            ->where('categories.category_name', '=', $category)
            ->get();

        if (!$books) {
            return response()->json(['message' => 'News not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($books, Response::HTTP_OK);
    }

    public function getBookById(Request $request, $id)
    {
        $book = Book::where('books.book_id', '=', $id)
            ->get();

        if (!$book) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($book, Response::HTTP_OK);
    }

    public function getGenres(Request $request)
    {
        $genre = Genre::get();

        return response()->json($genre, Response::HTTP_OK);
    }

    public function getBestsellers()
    {
        $books = Book::orderBy('book_id', 'desc')
            ->leftJoin('genre', 'books.genre_id', '=', 'genre.genre_id')
            ->leftJoin('categories', 'genre.category_id', '=', 'categories.category_id')
            ->take(5)
            ->get();

        if (!$books) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($books, Response::HTTP_OK);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAllBooks()
    {
        $books = Book::leftJoin('genre', 'books.genre_id', '=', 'genre.genre_id')
            ->leftJoin('categories', 'genre.category_id', '=', 'categories.category_id')
            ->get();

        if (!$books) {
            return response()->json(['message' => 'Book not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($books, Response::HTTP_OK);
    }

    public function getDeleteBook($id)
    {
        $book = Book::where('books.book_id', $id)
            ->get();

        foreach ($book as $item) {
            File::delete(public_path($item->image));
        }

        Book::where('books.book_id', $id)
            ->delete();

        return response()->json("Book was deleted", Response::HTTP_OK);
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

        $book = Book::where('books.book_id', $id)
            ->update(['title' => $title, 'description'=>$description, 'isbn'=>$isbn, 'publication_year'=>$publication_year,
                'price'=>$price, 'genre_id'=>$genre_id, 'stock_level'=>$stock_level, 'type_id'=>$type_id,
                'publisher_id'=>$publisher_id, 'author_id'=>$author_id, 'image'=>$imagePath, 'updated_at'=>$date]);

        if (!$book) {
            return response()->json(['message' => 'Book not updated'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([$book], Response::HTTP_OK);
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

        $book = Book::insert(['title' => $title, 'description'=>$description, 'isbn'=>$isbn, 'publication_year'=>$publication_year,
                'price'=>$price, 'genre_id'=>$genre_id, 'stock_level'=>$stock_level, 'type_id'=>$type_id,
                'publisher_id'=>$publisher_id, 'author_id'=>$author_id, 'image'=>$imagePath, 'created_at'=>$date]);

        if (!$book) {
            return response()->json(['message' => 'Book not added'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([$book], Response::HTTP_OK);
    }

    public function search(Request $request, $term)
    {
        $books = Book::where('title', 'LIKE', '%' . $term . '%')
            ->leftJoin('genre', 'books.genre_id', '=', 'genre.genre_id')
            ->leftJoin('categories', 'genre.category_id', '=', 'categories.category_id')
            ->get();

        if (!$books) {
            return response()->json(['message' => 'Books not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($books, Response::HTTP_OK);
    }

}
