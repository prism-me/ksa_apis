<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Eloquent
{
    use HasFactory, SoftDeletes;

    protected $table = 'pages';
    
    protected $guarded = [];
    
    public function getRouteKeyName(){

        return 'route';
    }
    
}
