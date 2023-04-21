<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model{
    protected $table = 'tbl_products';

    protected $primaryKey = 'p_id';

    protected $fillable = [
        'p_id',
        'product_url',
        'product_name',
        'product_image',
        'product_content',
        'product_price',
        'product_status',
        'created_at',
        'updated_at'
    ];
}
