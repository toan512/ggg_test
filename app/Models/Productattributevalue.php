<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productattributevalue extends Model{
    protected $table = 'tbl_product_attribute_value';

    protected $primaryKey = 'pav_id';

    protected $fillable = [
        'pav_id',
        'pa_id',
        'product_id',
        'value',
        'pav_type_value',
        'pav_status',
        'created_at',
        'updated_at'
    ];
}
