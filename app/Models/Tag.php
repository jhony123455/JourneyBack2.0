<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'color'];

    public function activities()
    {
        return $this->belongsToMany(Activity::class, 'activity_tag');
    }
}
