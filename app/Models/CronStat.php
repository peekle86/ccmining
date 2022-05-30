<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CronStat extends Model
{
    use HasFactory;

    public $table = 'cron_stat';
}
