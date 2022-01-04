<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Eloquent
{
    use HasFactory;
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];
  
    
    protected $table = 'card_details';
   

}
