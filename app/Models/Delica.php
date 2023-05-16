<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Delica extends Model
{
    use HasFactory;

    protected $fillable = ['code'];

    /**
     * The projects that this delica is used in.
     */
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }

    /**
     * the beads that have this delica associated.
     */
    public function beads()
    {
        return $this->hasMany(Bead::class);
    }
}
