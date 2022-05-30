<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class HardwareItem extends Model implements HasMedia
{
    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    public const AVAILABLE_RADIO = [
        '0' => 'Not',
        '1' => 'Yes',
    ];

    public $table = 'hardware_items';

    protected $appends = [
        'photo',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'price',
        'model',
        'hashrate',
        'power',
        'algoritm_id',
        'profitability',
        'available',
        'description',
        'specification',
        'coins',
        'script',
        'url',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function algoritm()
    {
        return $this->belongsTo(HardwareType::class, 'algoritm_id');
    }

    public function period($id)
    {
        return ContractPeriod::find($id);
    }

    public function getPhotoAttribute()
    {
        $file = $this->getMedia('photo')->last();
        if ($file) {
            $file->url       = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview   = $file->getUrl('preview');
        }

        return $file;
    }

    public function getCurrenciesAttribute()
    {
        $symbol = $this->algoritm->symbol == 'CLOUD' ? 'btc' : $this->algoritm->symbol;
        $currencies = Currency::whereIn('symbol', [$symbol, 'usdt'])->get();
        return $currencies;
    }

    public function getProfitAttribute()
    {
        $electricity = $this->power * 24 / 1000 * Setting::first()->price_kwt;
        return $this->profitability - $electricity;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
