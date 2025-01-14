<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MealImage extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Mass assignable attributes.
     */
    protected $fillable = [
        'meal_id',
        'image_path',
        // 'alt_text',         // Example for alternative text
        // 'image_order',      // Example for ordering images
    ];

    /**
     * Relationships
     */

    // A MealImage belongs to a Meal
    public function meal()
    {
        return $this->belongsTo(Meal::class);
    }

    /**
     * Accessor for full image URL.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return url('storage/' . $this->image_path); // Adjust path based on your storage setup
    }
}
