<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WalletNetwork extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'wallet_networks';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Network
     */
    const BTC = 1;
    const USDT = 4;

    protected $fillable = [
        'name',
        'symbol',
        'in_usd',
        'coingecko',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
