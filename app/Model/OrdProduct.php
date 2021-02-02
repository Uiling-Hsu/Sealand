<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class OrdProduct extends Model
{
    protected $table='ord_product';

    protected $fillable=[
        'ord_id',
        'product_id',
        'is_addition',
        'product_name',
        'stock_id',
        'ordPrice',
        'quantity',
        'sum',
        'memo',
    ];


}
