<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const TYPE_RADIO = [
        '1' => 'Deposit',
        '2' => 'Buy',
        '3' => 'Earn',
        '4' => 'Withdraw',
        '5' => 'Ref',
        '6' => 'Electricity',
        '7' => 'Return'
    ];

    public const STATUS_RADIO = [
        '0' => 'Confirm email',
        '1' => 'Being processed',
        '2' => 'Cancelled',
        '4' => 'Completed',
    ];

    public $table = 'transactions';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'in_usd',
        'status',
        'contract_id',
        'currency_id',
        'source',
        'target',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
