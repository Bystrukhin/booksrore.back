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

Route::resource('books', 'BookController', ['except' => [
    'create', 'edit'
]]);


Route::resource('category', 'CategoryController', ['only' => [
    'index'
]]);


Route::resource('genre', 'GenreController', ['only' => [
    'index', 'show'
]]);


Route::get('/comments/user/{id}', 'CommentController@getCommentsByUserId');

Route::resource('comments', 'CommentController', ['only' => [
    'index', 'show', 'store', 'update'
]]);


Route::resource('publishers', 'PublisherController', ['except' => [
    'create', 'edit',
]]);


Route::resource('authors', 'AuthorController', ['except' => [
    'create', 'edit'
]]);


Route::get('/news/last', 'NewsController@getLastNews');

Route::resource('news', 'NewsController', ['except' => [
    'create', 'edit'
]]);


Route::get('/orders/user/{id}', 'OrdersController@getOrdersByUser')->middleware('user.token');

Route::resource('orders', 'OrdersController', ['only' => [
    'show', 'index', 'store'
]]);


Route::post('/user/signin', ['uses' => 'UserController@signin']);

Route::resource('user', 'UserController', ['only' => [
    'show', 'store', 'update'
]]);


Route::post('password/reset', 'Auth\ForgotPasswordController@emailPasswordCode');

