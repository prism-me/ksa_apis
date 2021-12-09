<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class GoodToKnow extends Eloquent
{
    use HasFactory;
    protected $table = 'good_to_knows';
    protected $guarded = [];
    
}
