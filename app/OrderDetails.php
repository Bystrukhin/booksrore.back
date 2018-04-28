<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    /**
     * @var string
     */
    protected $table = "order_details";

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity', 'price', 'order_id', 'book_id', 'date'
    ];

    /**
     * Get the genre record associated with the book.
     */
    public function book()
    {
        return $this->belongsTo('App\Book', 'book_id', 'book_id');
    }
}
