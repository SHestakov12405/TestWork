<?php

namespace App\Models;

use App\Models\TagPoint;
use App\Models\UserList;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PointList extends Model
{
    use HasFactory;


    /**
     * Get the user that owns the PointList
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userList(): BelongsTo
    {
        return $this->belongsTo(UserList::class, 'user_list_id');
    }

    /**
     * Get all of the comments for the PointList
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags(): HasMany
    {
        return $this->hasMany(TagPoint::class, 'point_id', 'id');
    }
}
