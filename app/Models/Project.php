<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    /**
     * Get the beads for the project.
     */
    public function beads(): HasMany
    {
        return $this->hasMany(Bead::class);
    }

    /**
     * The delicas that are used in this project.
     */
    public function delicas(): BelongsToMany
    {
        return $this->belongsToMany(Delica::class);
    }
}
