<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    /**
     * Get the route key for the model.
     *
     * @return string
     */


    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'image',
        'user_id',
        'category_id',
        'is_published',
        'published_at',
        'views'
    ];

    protected $with = ['author', 'category'];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $attributes = [
        'is_published' => false,
        'views' => 0
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            $baseSlug = $news->slug ? Str::slug($news->slug) : Str::slug($news->title);
            $news->slug = static::generateUniqueSlug($baseSlug);

            // Set published_at if being published and not already set
            if ($news->is_published && !$news->published_at) {
                $news->published_at = now();
            }
        });

        static::updating(function ($news) {
            if ($news->isDirty('title') || $news->isDirty('slug')) {
                $baseSlug = $news->slug ? Str::slug($news->slug) : Str::slug($news->title);
                $news->slug = static::generateUniqueSlug($baseSlug, $news->id);
            }

            // Update published_at when publish status changes
            if ($news->isDirty('is_published')) {
                $news->published_at = $news->is_published ? now() : null;
            }
        });
    }

    protected static function generateUniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = $baseSlug ?: 'news';
        $original = $slug;
        $i = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, function ($query) use ($ignoreId) {
                return $query->where('id', '<>', $ignoreId);
            })
            ->exists()
        ) {
            $i++;
            $slug = "{$original}-{$i}";
        }

        return $slug;
    }

    /**
     * Scope a query to only include published news.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Get the route key name for Laravel's route model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get the user that owns the news.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the author that owns the news.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the category that owns the news.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
