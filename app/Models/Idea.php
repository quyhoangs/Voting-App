<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Idea extends Model
{
    use HasFactory, Sluggable;

    const PAGINATION_COUNT = 10;

    protected $guarded = [];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        //Tải về gói SLug , Set 1 field là slug
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        //1 idea belongs to 1 user
        return $this->belongsTo(User::class);
    }
}
