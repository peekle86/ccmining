<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public $table = 'settings';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'price_kwt',
        'price_th',
        'profit_th',
        'max_th',
        'ref',
        'active',
        'proxy',
        'created_at',
        'updated_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
