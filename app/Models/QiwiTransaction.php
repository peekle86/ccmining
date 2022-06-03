<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QiwiTransaction extends Model
{
    use HasFactory;

    protected $table = 'qiwi_transactions';

    /**
     * Status
     * 'confirmed', 'unconfirmed'
     */
    const CONFIRMED = 'confirmed';
    const UNCONFIRMED = 'unconfirmed';

    protected $fillable = [
        'user_id',
        'order_id',
        'transaction_id',
        'amount',
        'status',
        'payment_system_id',
        'created_date'
    ];
}
