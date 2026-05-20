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
        if (! $this->image) {
            return false;
        }

        return in_array(
            strtolower(pathinfo($this->image, PATHINFO_EXTENSION)),
            ['jpg', 'jpeg'],
            true
        );
    }

    public function hasImageFile(): bool
    {
        if (! $this->image) {
            return false;
        }

        return is_file(public_path('images/products/'.$this->image))
            || is_file(public_path('storage/'.$this->image));
    }

    public function imageUrl(): string
    {
        if ($this->image) {
            $productsPath = public_path('images/products/'.$this->image);
            if (file_exists($productsPath)) {
                return asset('images/products/'.$this->image);
            }

            $storagePath = public_path('storage/'.$this->image);
            if (file_exists($storagePath)) {
                return asset('storage/'.$this->image);
            }
        }

        return asset('images/tire-placeholder.svg');
    }
}
