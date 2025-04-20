<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function places(){
        return $this->hasMany(Place::class);
    }
}
