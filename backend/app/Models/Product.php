<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->sharpen(10);

        $this->addMediaConversion('responsive')
            ->withResponsiveImages();
    }

    protected $fillable = [
        'name', 
        'slug', 
        'description', 
        'category', 
        'collection', 
        'images', 
        'is_active', 
        'is_featured', 
        'vat_percentage',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'images' => 'array',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
