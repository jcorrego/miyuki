<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bead extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['project'];

    /**
     * The project that this bead belongs to.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    /**
     * The Delica associated with this bead.
     */
    public function delica()
    {
        return $this->belongsTo(Delica::class);
    }
}
