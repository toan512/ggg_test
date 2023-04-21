<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productattribute extends Model{
    protected $table = 'tbl_product_attributes';

    protected $primaryKey = 'pa_id';

    protected $fillable = [
        'pa_id',
        'pa_text_show',
        'pa_name',
        'pa_status',
        'pa_lock',
        'regular_exp',
        'regular_exp_index',
        'pa_type',
        'created_at',
        'updated_at'
    ];
}
