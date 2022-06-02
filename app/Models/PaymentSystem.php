<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSystem extends Model
{
    use HasFactory;

    protected $table = 'payment_systems';

    /**
     * Types
     */
    const BTC = 1;
    const USDT = 2;
    const QIWI = 3;
    const VISA = 4;
    const MASTER_CARD = 5;
    const MIR = 6;

    protected $fillable = [
        'title'
    ];
}
