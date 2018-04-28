<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * @var string
     */
    protected $table = "comments";

    protected $primaryKey = 'comment_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text', 'visible', 'created_at', 'updated_at', 'user_id', 'book_id', 'vote'
    ];

    /**
     * Get the book record associated with the comment.
     */
    public function book()
    {
        return $this->belongsTo('App\Book', 'book_id', 'book_id');
    }
}
