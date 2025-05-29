<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'color', 'user_id'];

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_tag');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
