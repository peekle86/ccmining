<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Order Statuses
     */
    const FINALIZED = 'finalized';
    const PENDING = 'pending';
    const NOT_PAID = 'not_paid';

    protected $table = 'orders';

    protected $fillable = [
      'user_id',
      'checkout_id',
      'total',
      'status',
    ];

    public function contracts()
    {
        return $this->belongsToMany(Contract::class, 'orders_contracts',  'order_id', 'contract_id');
    }
}
