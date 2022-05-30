<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const ACTIVE_RADIO = [
        '0' => 'Not',
        '1' => 'Yes',
    ];

    public $table = 'contracts';

    protected $dates = [
        'ended_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'last_earn'
    ];

    protected $fillable = [
        'user_id',
        'hardware_id',
        'period_id',
        'currency_id',
        'ended_at',
        'active',
        'percent',
        'amount',
        'created_at',
        'updated_at',
        'deleted_at',
        'last_earn'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hardware()
    {
        return $this->belongsTo(HardwareItem::class, 'hardware_id');
    }

    public function period()
    {
        return $this->belongsTo(ContractPeriod::class, 'period_id');
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'contract_id', 'id');
    }

    public function getEndedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEndedAtAttribute($value)
    {
        $this->attributes['ended_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
