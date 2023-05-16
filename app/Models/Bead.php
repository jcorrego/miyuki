<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bead extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The Delica associated with this bead.
     */
    public function delica() {
        return $this->belongsTo(Delica::class);
    }
}
