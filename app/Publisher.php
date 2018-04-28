<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Publisher extends Model
{
    /**
     * @var string
     */
    protected $table = "publishers";

    protected $primaryKey = 'publisher_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'publisher_name', 'address', 'city', 'country', 'created_at', 'updated_at'
    ];
}
