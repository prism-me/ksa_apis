<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Order extends Eloquent
{
    use HasFactory;

    protected $guarded = [];
}
