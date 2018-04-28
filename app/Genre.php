<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /**
     * @var string
     */
    protected $table = "genre";

    protected $primaryKey = 'genre_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'genre_name', 'created_at', 'updated_at'
    ];

    public function book()
    {
        return $this->hasMany('App\Book');
    }

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id', 'category_id');
    }

}
