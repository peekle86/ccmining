<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QiwiPaymentNote extends Model
{
    use HasFactory;

    protected $table = 'qiwi_payment_notes';

    protected $fillable = [
      'user_id',
      'qiwi_link_id',
      'payment_system_id',
      'payment_note'
    ];
}
