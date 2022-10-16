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
        //Requied gói slug ,tạo 1 filed slug trong bảng
        //và set tên filed làm slug trong bảng
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

    public function category()
    {
        //1 idea belongs to 1 category
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        //1 idea belongs to 1 status
        return $this->belongsTo(Status::class);
    }

    public function getStatusClasses ()
    {
        $allStatus = [
            'Open' => 'bg-gray-200 ',
            'Considering' => 'bg-purple text-white',
            'In Progress' => 'bg-yellow text-white',
            'Implemented' => 'bg-green text-white',
            'Closed' => 'bg-red text-white',
        ];
        return $allStatus[$this->status->name];
    }
}
