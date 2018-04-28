<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @var string
     */
    protected $table = "categories";

    protected $primaryKey = 'category_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_name', 'created_at', 'updated_at'
    ];

    public function genre()
    {
        return $this->hasMany(
            'App\Genre',
            'category_id',
            'category_id'
        );
    }

    public function book()
    {
        return $this->hasMany(
            'App\Book',
            'category_id',
            'category_id'
        );
    }

}
