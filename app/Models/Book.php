<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'publisher',
        'published_date',
        'category_id',  // 👈 correct field
        'language',
        'pages',
        'status',
        'front_cover',
        'back_cover',
        'description',
        'price'
    ];


    protected $casts = [
        'published_date' => 'datetime',
    ];



    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Accessor for formatted published date (dd/mm/yyyy).
     */
    public function getPublishedDateFormattedAttribute()
    {
        return $this->published_date ? $this->published_date->format('d/m/Y') : null;
    }

    /**
     * Accessor for front cover URL.
     */
    public function getFrontCoverUrlAttribute()
    {
        return $this->front_cover
            ? asset('storage/books/' . $this->front_cover)
            : asset('images/default-book.png');
    }

    /**
     * Accessor for back cover URL.
     */
    public function getBackCoverUrlAttribute()
    {
        return $this->back_cover
            ? asset('storage/books/' . $this->back_cover)
            : asset('images/default-book.png');
    }

    /**
     * Scope for global search across multiple columns.
     */
    public function scopeSearch($query, $term)
    {
        if (!$term) return $query;

        $term = "%{$term}%";

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', $term)
                ->orWhere('author', 'like', $term)
                ->orWhere('isbn', 'like', $term)
                ->orWhere('publisher', 'like', $term)
                ->orWhere('language', 'like', $term)
                ->orWhereHas('category', function ($q) use ($term) {
                    $q->where('name', 'like', $term);
                });
        });
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeStatus($query, $status)
    {
        if ($status && in_array($status, ['available', 'issued', 'damaged', 'lost'])) {
            return $query->where('status', $status);
        }

        return $query;
    }

    /**
     * Scope for filtering by published date range (dd/mm/yyyy).
     */
    public function scopePublishedBetween($query, $from, $to)
    {
        if ($from && $to) {
            try {
                $from = Carbon::createFromFormat('d/m/Y', $from)->startOfDay();
                $to = Carbon::createFromFormat('d/m/Y', $to)->endOfDay();
                return $query->whereBetween('published_date', [$from, $to]);
            } catch (\Exception $e) {
                // Invalid date format, ignore filter
            }
        }
        return $query;
    }

    /**
     * Combined filter scope for controller convenience.
     * Pass an array of filters with keys: search, status, published_from, published_to.
     */
    public function scopeFilter($query, array $filters = [])
    {
        return $query
            ->search($filters['search'] ?? null)
            ->status($filters['status'] ?? null)
            ->publishedBetween($filters['published_from'] ?? null, $filters['published_to'] ?? null);
    }
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id');
    }
}
