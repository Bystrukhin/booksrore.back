<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    /**
     * @var string
     */
    protected $table = "news";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'text', 'image', 'created_at', 'updated_at'
    ];
}
