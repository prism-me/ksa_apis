<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class ArticleCategory extends Eloquent
{
    use HasFactory;

    protected $table = 'article_categories';

    protected $guarded = [];
    
    public function articles(){

        return $this->hasMany(Article::class);
    
    }
    public function getRouteKeyName(){

        return 'route';
    }
}
