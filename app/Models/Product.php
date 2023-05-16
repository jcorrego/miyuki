<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * Get the beads for the product.
     */
    public function beads(): HasMany
    {
        return $this->hasMany(Bead::class);
    }

    /**
     * The delicas that are used in this product.
     */
    public function delicas(): BelongsToMany
    {
        return $this->belongsToMany(Delica::class);
    }
}
