<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * @var string
     */
    protected $table = "authors";

    protected $primaryKey = 'author_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'country', 'created_at', 'updated_at'
    ];
}
