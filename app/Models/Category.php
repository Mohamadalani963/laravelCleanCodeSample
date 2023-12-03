<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id',
        'name',
        'url'
    ];
    static protected function boot()
    {
        parent::boot();
        static::deleting(function ($model) {
            Storage::delete($model->url);
        });
        static::updating(function ($model) {
            $url = $model->getOriginal('url');
            if ($model->isDirty('url')) {
                Storage::delete($url);
            }
        });
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function parent()
    {
        return $this->belongsTo(Category::class);
    }
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
