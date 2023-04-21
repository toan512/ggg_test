<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feeconfig extends Model{
    protected $table = 'tbl_fee_config';

    protected $primaryKey = 'fee_id';

    protected $fillable = [
        'fee_id',
        'fee_name',
        'fee_config',
        'fee_config_condition',
        'created_at',
        'updated_at'
    ];
}
