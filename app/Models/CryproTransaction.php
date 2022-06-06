<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryproTransaction extends Model
{
    use HasFactory;

    protected $table = 'crypto_transactions';

    /**
     * Transaction Status
     */
    const CONFIRMED = 'confirmed';
    const UNCONFIRMED = 'unconfirmed';

    /**
     * Transaction crypto type
     */
    const USDT = 'usdt';
    const BTC = 'btc';

    protected $fillable = [
        'user_id',
        'order_id',
        'wallet_id',
        'transaction_hash',
        'amount',
        'status',
        'crypto_type',
        'created_date'
    ];
}
