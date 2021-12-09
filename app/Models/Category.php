<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Models\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Eloquent
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';
    protected $guarded = [];


    public function getRouteKeyName(){

        return 'route';
    }

    public function products(){
        return $this->hasMany(Product::class,'category','_id');
    }

    public function children() {
        return $this->hasMany(Category::class ,'parent_id' , '_id')->whereNull('deleted_at');
    }
    public function parent() {
        return $this->belongsTo(Category::class , 'parent_id','_id');
    }
        public function parent_route() {
        return $this->belongsTo(Category::class , 'parent_id','_id')->select('route');
    }
}
