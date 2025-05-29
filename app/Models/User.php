<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'password',
        'fecha_registro',
        'avatar',
        'bio',
        'location',
        'birth_date',
        'phone',
        'website',
        'social_links',
        'theme_preference',
        'language_preference'
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'birth_date' => 'date',
            'social_links' => 'array',
            'fecha_registro' => 'datetime'
        ];
    }

    /**
     * Get the user's age.
     */
    public function getAge()
    {
        return $this->birth_date ? $this->birth_date->age : null;
    }

    /**
     * Get the user's profile completion percentage.
     */
    public function getProfileCompletionPercentage()
    {
        $fields = [
            'name',
            'avatar',
            'bio',
            'location',
            'birth_date',
            'phone',
            'website',
            'social_links'
        ];

        $filled = collect($fields)->filter(function ($field) {
            return !empty($this->$field);
        })->count();

        return round(($filled / count($fields)) * 100);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function tags()
    {
        return $this->hasMany(Tag::class);
    }

    public function diaryEntries()
    {
        return $this->hasMany(DiaryEntry::class);
    }

    public function calendarEvents()
    {
        return $this->hasMany(CalendarEvent::class);
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
