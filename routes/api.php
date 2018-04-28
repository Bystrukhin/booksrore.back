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


Route::get('/books/bestsellers', 'BookController@bestsellers');

Route::get('/books/search/{term}', 'BookController@search');

Route::post('/books/update', 'BookController@update');

Route::get('/books/destroy/{id}', 'BookController@destroy');

Route::resource('books', 'BookController', ['except' => [
    'create', 'edit', 'update', 'destroy'
]]);

Route::resource('category', 'CategoryController', ['only' => [
    'index'
]]);


Route::resource('genre', 'GenreController', ['only' => [
    'index', 'show'
]]);


Route::get('/comments/user/{id}', 'CommentController@getCommentsByUserId');

Route::post('/comments/update', 'CommentController@update');

Route::resource('comments', 'CommentController', ['only' => [
    'index', 'show', 'store'
]]);


Route::post('/publishers/update', 'PublisherController@update');

Route::get('/publishers/destroy/{id}', 'PublisherController@destroy');

Route::resource('publishers', 'PublisherController', ['except' => [
    'create', 'edit', 'update', 'destroy'
]]);


Route::post('/authors/update', 'AuthorController@update');

Route::get('/authors/destroy/{id}', 'AuthorController@destroy');

Route::resource('authors', 'AuthorController', ['except' => [
    'create', 'edit', 'update', 'destroy'
]]);


Route::get('/news/last', 'NewsController@getLastNews');

Route::post('/news/update', 'NewsController@update');

Route::get('/news/destroy/{id}', 'NewsController@destroy');

Route::resource('news', 'NewsController', ['except' => [
    'create', 'edit', 'update', 'destroy'
]]);


Route::get('/orders/user/{id}', 'OrdersController@getOrdersByUser');

Route::resource('orders', 'OrdersController', ['only' => [
    'show', 'index', 'store'
]]);


Route::post('/user/signin', ['uses' => 'UserController@signin']);

Route::post('/user/update', 'UserController@update');

Route::resource('user', 'UserController', ['only' => [
    'show', 'store'
]]);


Route::post('password/reset', 'Auth\ForgotPasswordController@emailPasswordCode');

