<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function avgRating()
    {
        return ($this->service_rating + $this->cleanliness_rating + $this->quality_rating + $this->pricing_rating) / 4;
    }

    public function likes()
    {
        return $this->belongsToMany('App\Models\User','likes');
    }
}
