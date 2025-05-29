<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Activity extends Model
{
    protected $fillable = ['title', 'description', 'color', 'user_id'];

    protected $appends = ['tag_ids'];

    protected $hidden = ['tags'];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'activity_tag');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTagIdsAttribute(): array
    {
        return $this->tags->pluck('id')->toArray();
    }
}
