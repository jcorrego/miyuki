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

    /**
     * Refresh all bead counters for this project.
     */
    public function refreshBeadCounters(): void
    {
        $beads = [];
        foreach ($this->beads as $bead) {
            $bead->badge = 1;
            $bead->save();
            $beads[$bead->row][$bead->col] = $bead;
        }
        for ($i = 1; $i <= $this->long; $i++) {
            for ($j = 1; $j <= $this->width; $j++) {
                if (isset($beads[$j][$i])) {
                    $bead = $beads[$j][$i];
                    if ($j > 1) {
                        if (isset($beads[$j-1][$i])) {
                            $previous_bead = $beads[$j-1][$i];
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
        }
        foreach ($this->beads as $bead) {
            if ($bead->badge === 1) {
                $bead->badge = 0;
                $bead->save();
            }
        }
    }
}
