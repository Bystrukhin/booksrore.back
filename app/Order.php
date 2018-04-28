<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * @var string
     */
    protected $table = "orders";

    protected $primaryKey = 'order_id';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_date', 'total_price', 'shipping', 'customer_email', 'customer_first_name',
        'customer_second_name', 'phone_number', 'address', 'city', 'postal_code', 'country'
    ];
}
