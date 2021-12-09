<?php

namespace App\Models;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Eloquent
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = '_id';
    protected $table = 'reviews';
    protected $guarded = [];

    public function product(){

        return $this->belongsTo(Product::class,'product_id' ,'_id')->select('name','_id');
    }

    public function user(){
        
        return $this->belongsTo(User::class, 'user_id','_id')->select('name','_id');
    }
}
