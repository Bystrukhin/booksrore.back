<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Book
 * @package App
 * @property string title
 */
class Book extends Model
{
    /**
     * @var string
     */
    protected $table = "books";

    protected $primaryKey = 'book_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'image', 'ISBN', 'publication_year', 'price', 'stock_level',
        'created_at', 'updated_at', 'author_id', 'publisher_id', 'genre_id', 'category_id',
        'type_id'
    ];

    /**
     * Get the genre record associated with the book.
     */
    public function genre()
    {
        return $this->belongsTo('App\Genre', 'genre_id', 'genre_id');
    }

    /**
     * Get the genre record associated with the book.
     */
    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'category_id');

    }

    public function comment()
    {
        return $this->hasMany('App\Comment');
    }

}
