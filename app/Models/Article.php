<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Article extends Eloquent
{
    use HasFactory;

    protected $guarded = [];
    protected $table  = 'articles';
    
    public function getRouteKeyName(){

        return 'route';
    }
        public function categories(){

        return $this->hasOne(ArticleCategory::class,'_id','category_id');
    }
}
