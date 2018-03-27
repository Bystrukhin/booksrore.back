<?php

use Illuminate\Http\Request;
use App\Http\Resources\CategoriesMenu as Menu;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/categories_menu',function(){
    $categories = \App\CategoriesMenu::with('children')->where('parent_id','=',0)->get();
    return $categories;
});


Route::get('/books', 'BookController@getAllBooks');

Route::get('/books/bestsellers', 'BookController@getBestsellers');

Route::get('/books/genres', 'BookController@getGenres');

Route::get('/books/category/{category}', 'BookController@getBooksByCategory');

Route::get('/books/genre/{genre}', 'BookController@getBooksByGenre');

Route::get('/books/{id}', 'BookController@getBookById');

Route::get('/books/{id}/delete', 'BookController@getDeleteBook');

Route::post('/books/{id}/edit', 'BookController@postEditBook');

Route::post('/books/add', 'BookController@postAddBook');


Route::get('/publishers', 'PublisherController@getPublishers');

Route::get('/publishers/{id}', 'PublisherController@getPublisher');

Route::get('/publishers/{id}/delete', 'PublisherController@getDeletePublisher');

Route::post('/publishers/{id}/edit', 'PublisherController@postEditPublisher');

Route::post('/publishers/add', 'PublisherController@postAddPublisher');


Route::get('/authors', 'AuthorController@getAuthors');

Route::get('/authors/{id}', 'AuthorController@getAuthor');

Route::get('/authors/{id}/delete', 'AuthorController@getDeleteAuthor');

Route::post('/authors/{id}/edit', 'AuthorController@postEditAuthor');

Route::post('/authors/add', 'AuthorController@postAddAuthor');


Route::get('/news', 'NewsController@getNews');

Route::get('/news/last', 'NewsController@getLastNews');

Route::get('/news/{id}', 'NewsController@getArticle');

Route::post('/news/{id}/edit', 'NewsController@postEditArticle');

Route::post('/news/add', 'NewsController@postAddArticle');

Route::get('/news/{id}/delete', 'NewsController@getDeleteArticle');


Route::post('/checkout', 'CheckoutController@makePayment');


Route::get('/orders', 'OrdersController@getOrders');

Route::get('/orders/{id}', 'OrdersController@getOrderDetails');


Route::post('/user/signup', [
    'uses' => 'UserController@signup'
]);

Route::post('/user/signin', [
    'uses' => 'UserController@signin'
]);

