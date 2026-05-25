<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'price', 'description', 'image', 'available',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'available' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function hasWhiteMatteBackground(): bool
    {
        return false;
    }

    public function hasImageFile(): bool
    {
        return is_file(public_path('images/products/'.$this->image))
            || is_file(public_path('storage/'.$this->image));
    }

    public function imageUrl(): string
    {
        if ($this->image) {
            $base = pathinfo($this->image, PATHINFO_FILENAME);
            foreach (['jpg', 'jpeg', 'webp', 'png'] as $ext) {
                $path = public_path('images/products/'.$base.'.'.$ext);
                if (is_file($path)) {
                    return asset('images/products/'.$base.'.'.$ext);
                }
            }
            $productsPath = public_path('images/products/'.$this->image);
            if (is_file($productsPath)) {
                return asset('images/products/'.$this->image);
            }
        }

        $category = $this->relationLoaded('category') ? $this->category : $this->category()->first();
        if ($category) {
            $categoryPhoto = public_path('images/categories/'.$category->slug.'.jpg');
            if (is_file($categoryPhoto)) {
                return asset('images/categories/'.$category->slug.'.jpg');
            }
        }

        return asset('images/parts-placeholder.svg');
    }
}
