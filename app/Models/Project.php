<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

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

    /**
     * Refresh all bead counters for this project.
     */
    public function refreshBeadCounters(int $col = 0): void
    {
        $beads = [];
        foreach ($this->beads()->where('col', $col)->get() as $bead) {
            $bead->badge = 1;
            $bead->save();
            $beads[$bead->row] = $bead;
        }
        for ($j = 1; $j <= $this->width; $j++) {
            if (isset($beads[$j])) {
                $bead = $beads[$j];
                if ($j > 1) {
                    if (isset($beads[$j-1])) {
                        $previous_bead = $beads[$j-1];
                        if ($bead->delica->id === $previous_bead->delica->id) {
                            $bead->badge = $previous_bead->badge + 1;
                            $bead->save();
                            $previous_bead->badge = 0;
                            $previous_bead->save();
                            continue;
                        }
                    }
                }
            }
        }

        foreach ($this->beads()->where('col', $col)->get() as $bead) {
            if ($bead->badge == 1) {
                $bead->badge = 0;
                $bead->save();
            }
        }
    }
}
