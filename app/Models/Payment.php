<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'customer_name',
        'order_id',
        'tran_ref',
        'tran_type',
        'amount',
        'currency',
        'payment_method',
        'status',
    ];
}
