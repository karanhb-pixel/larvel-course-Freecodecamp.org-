<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use HasSlug;

    protected $fillable = [
        // 'image',
        'title',
        'slug',
        'content',
        'category_id',
        'user_id',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime', 
    ];

    
    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->width(400)
            ->nonQueued();
        $this
            ->addMediaConversion('large')
            ->width(1200)
            ->nonQueued();
    }
        public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('default')
            ->singleFile();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function claps()
    {
        return $this->hasMany(Clap::class);
    }

    public function imageUrl($conversionName = '')
    { 
        $media = $this->getFirstMedia();
        if($media){

            if($media?->hasGeneratedConversion($conversionName)){
                return $media->getUrl($conversionName);
            }
            return $media?->getUrl();
        }
        return 'https://placehold.co/128x128/png';

    }

    public function getCreatedAtDisplay(){
        
        if($this->published_at){
            return $this->published_at->format('d M, Y');
        }
        return $this->created_at->format('d M, Y');
    }
}
