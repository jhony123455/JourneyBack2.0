<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['title', 'description', 'color', 'start_time', 'end_time', 'user_id'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'activity_tag');
    }
}
