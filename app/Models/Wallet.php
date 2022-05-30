<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    public $table = 'wallets';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'address',
        'user_id',
        'amount',
        'network_id',
        'created_at',
        'updated_at',
    ];

    public function walletUsers()
    {
        return $this->hasMany(User::class, 'wallet_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function network()
    {
        return $this->belongsTo(WalletNetwork::class, 'network_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
