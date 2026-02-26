<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class CVForm extends Model
{
    use HasSlug;

    protected $table = 'cv_forms';

    protected $fillable = [
        'user_id',
        'title',
        'template',
        'personal_info',
        'experience',
        'education',
        'skills',
        'languages',
        'projects',
        'profile_picture',
        'last_edited_at',
    ];

    protected $casts = [
        'personal_info' => 'array',
        'experience' => 'array',
        'education' => 'array',
        'skills' => 'array',
        'languages' => 'array',
        'projects' => 'array',
        'last_edited_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
                ->generateSlugsFrom('title')
                ->saveSlugsTo('slug');
    }

    public function getAllData()
    {
        return [
            'personal_info' => $this->personal_info,
            'experience' => $this->experience ?? [],
            'education' => $this->education ?? [],
            'skills' => $this->skills ?? [],
            'languages' => $this->languages ?? [],
            'projects' => $this->projects ?? [],
            'profile_picture' => $this->profile_picture
        ];
    }

    protected static function booted()
    {
        static::creating(function ($cv) {
            $cv->user_id = auth()->id();
        });
    }
}
