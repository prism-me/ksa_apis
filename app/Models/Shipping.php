<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class Shipping extends Eloquent
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'shipping_details';

}
