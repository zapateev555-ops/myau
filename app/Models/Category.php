<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'image'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function imageUrl(): string
    {
        $candidates = array_filter([
            $this->image,
            $this->slug.'.jpg',
            'cat-'.$this->slug.'.jpg',
        ]);

        foreach ($candidates as $file) {
            $path = public_path('images/categories/'.$file);
            if (is_file($path) && ! str_ends_with(strtolower($file), '.svg')) {
                return asset('images/categories/'.$file);
            }
        }

        return asset('images/parts-placeholder.svg');
    }
}
