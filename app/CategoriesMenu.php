<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoriesMenu extends Model
{
    protected $table = 'categories_menu';

    public function parent()
    {
        return $this->belongsTo('App\CategoriesMenu', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\CategoriesMenu', 'parent_id');
    }
}
