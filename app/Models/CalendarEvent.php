<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalendarEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity_id',
        'user_id',
        'start_date',
        'end_date',
        'all_day'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'all_day' => 'boolean'
    ];

    protected $appends = ['title', 'description', 'color', 'tag_ids'];

    protected $hidden = ['activity'];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTitleAttribute()
    {
        return $this->activity->title;
    }

    public function getDescriptionAttribute()
    {
        return $this->activity->description;
    }

    public function getColorAttribute()
    {
        return $this->activity->color;
    }

    public function getTagIdsAttribute()
    {
        return $this->activity->tag_ids;
    }
}
