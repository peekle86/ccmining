<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Mail extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;

    public const TYPE_SELECT = [
        '1' => 'Registration',
        '2' => 'Mail confirm',
        '3' => 'Withdraw',
        '4' => 'Status change',
        '5' => 'Cart Reminder',
    ];

    public $table = 'mails';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'language_id',
        'content',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
