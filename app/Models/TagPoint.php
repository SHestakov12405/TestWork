<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TagPoint extends Model
{
    use HasFactory;



    /**
     * Get the user that owns the TagPoint
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pointList(): BelongsTo
    {
        return $this->belongsTo(Pointlist::class, 'point_id');
    }
}
