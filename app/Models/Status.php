<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ideas()
    {
        //1 status has many ideas
        return $this->hasMany(Idea::class);
    }
}
