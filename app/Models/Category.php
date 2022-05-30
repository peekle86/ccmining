<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public const TEMPLATE_SELECT = [
        '0' => 'Full Width',
        '1' => 'With Menu',
    ];

    public $table = 'categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'desc',
        'active',
        'slug',
        'show_menu',
        'parent_id',
        'template',
        'language_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function parentCategories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function categoryArticles()
    {
        return $this->hasMany(Article::class, 'category_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
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
