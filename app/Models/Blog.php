<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Blog extends Eloquent
{
    use HasFactory;

    protected $guarded = [];
    protected $table  = 'blogs';
    
    public function getRouteKeyName(){

        return 'route';
    }
}
