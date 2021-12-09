<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use App\Models\Category;
use App\Models\Media;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
class Product extends Eloquent
{
    use HasFactory;
    use SoftDeletes;
    
    public $uploads;

    protected $collection = 'products';
    protected $primaryKey ='_id';
    protected $guarded = [];

    public function getRouteKeyName(){
        return 'route';
    }

    public function categories(){
        return $this->belongsTo(Category::class,'category','_id');
    }
    
    public function category_order(){
        return $this->belongsTo(Category::class,'category','_id')->select('order','temp_id');
    }
    public function sub_category_order(){
        return $this->belongsTo(Category::class,'sub_category','_id')->select('order','temp_id');
    }

    public function categories_spc(){
        return $this->belongsTo(Category::class,'category','_id')->select('name');
    }

    public function reviews(){
    
        return $this->hasMany(Review::class ,'product_id','_id');
    
    }
    public function reviews_spc(){
    
        return $this->hasOne(Review::class ,'product_id','_id')->select('rating');
    
    }

    public function uploads ($cat){
    
        $this->uploads = $cat;
        
        foreach($cat as $up_ex){
        
        if($list = $up_ex->images_list){
                    
        $uploads['images_list'] = Upload::whereIn('_id' ,explode(',' , $list))->get();
        
        }
        
        
        if(@$banner =$up_ex->banner_images_list){
            
         @$uploads['banner_images_list'] = Upload::whereIn('_id' ,explode(',' , $banner))->get();
         
        }

      

        $up_ex['uploads'] = $uploads;
        
            
        }

        return $cat;
    }

}


