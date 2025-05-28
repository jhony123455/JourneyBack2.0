<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = ['title', 'description', 'color', 'user_id'];

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'activity_tag');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
