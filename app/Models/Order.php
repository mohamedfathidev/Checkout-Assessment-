<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = ['description', 'total_amount', 'currency', 'customer_details', 'status'];


    // one roder can hve many payments 
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
