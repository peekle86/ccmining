<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderContract extends Model
{
    use HasFactory;

    protected $table = 'orders_contracts';

    protected $fillable = [
        'order_id',
        'contract_id'
    ];
}
