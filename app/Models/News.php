<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Sadegh19b\LaravelIranCities\Models\City;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class News extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, SoftDeletes;

    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'content',
        'published_at',
        'featured',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected $appends = ['main_image'];

    protected static function booted(): void
    {
        static::saving(function (self $news): void {
            if (! empty($news->title) && empty($news->slug)) {
                $news->slug = self::generateUniqueSlug($news->title);
            }

            if (! empty($news->title) && ! empty($news->slug)) {
                $news->slug = self::generateUniqueSlug($news->title, $news->id);
            }
        });
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'city_news');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('main_image')->singleFile();
        $this->addMediaCollection('gallery');
    }

    public function getMainImageAttribute(): ?string
    {
        return $this->getFirstMediaUrl('main_image') ?: null;
    }

    public function getGalleryUrlsAttribute(): array
    {
        return $this->getMedia('gallery')
            ->map(fn ($media) => $media->getUrl())
            ->all();
    }

    protected static function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $base = static::generateSlug($title);
        $slug = $base ?: 'news';

        $query = static::query()->where('slug', $slug);

        if ($excludeId) {
            $query->whereKeyNot($excludeId);
        }

        $suffix = 1;
        while ($query->exists()) {
            $candidate = $slug.'-'.$suffix;
            $query = static::query()->where('slug', $candidate);

            if ($excludeId) {
                $query->whereKeyNot($excludeId);
            }

            if (! $query->exists()) {
                return $candidate;
            }

            $suffix++;
        }

        return $slug;
    }

    protected static function generateSlug(string $title): string
    {
        // حذف کاراکترهایی که حرف، عدد یا فاصله/خط تیره نیستند (با پشتیبانی از یونیکد)
        $title = preg_replace('/[^\p{L}\p{N}\s-]+/u', '', $title);
        // تبدیل یک یا چند فاصله یا خط تیره به یک خط تیره
        $title = preg_replace('/[\s-]+/u', '-', $title);
        // حذف خط تیره‌های ابتدا و انتها
        $title = trim($title, '-');

        // اگر خالی شد، مقدار پیش‌فرض
        return $title ?: 'news';
    }
}
