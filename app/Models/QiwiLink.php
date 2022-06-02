<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QiwiLink extends Model
{
    use HasFactory;

    protected $table = 'qiwi_links';

    protected $fillable = [
        'nickname',
        'login',
        'api_key'
    ];
}
