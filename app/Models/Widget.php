<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Widget extends Eloquent
{
    use HasFactory ;


    protected $table = 'widgets';

    protected $primaryKey ='_id';
    
    protected $guarded = [];
    


}
