<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Wishlist extends Eloquent
{   
    use HasFactory;
    use SoftDeletes;

    protected $table = 'wishlists';

    protected $primaryKey = '_id';

    protected $guarded = [];

    public function user(){

        return $this->belongsTo(User::class,'user_id','_id');
    }

    public function product(){
        return $this->belongsTo(Product::class ,'product_id','_id');
    }
}
