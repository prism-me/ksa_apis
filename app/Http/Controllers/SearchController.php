<?php

namespace App\Http\Controllers;

use App\Models\ArticleCategory;
use App\Models\Article;
use App\Models\Blog;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function navbar_search(Request $request)
    {

        $product = Product::select('name' , 'route')->where('name', 'like', '%' . $request->get('query') . '%')->whereNull('deleted_at')->get();
       
       $blogs = Blog::select('title' , 'route')->where('title', 'like', '%' . $request->get('query') . '%')->get();
       
       $blogs->map(function ($post) {
            $post['route'] = 'en/blog/'. $post['route'];
            $post['name'] = $post['title'];
            unset($post['title']);
            return $post;
        });
       
       $articles = Article::select('_id','title','route','category_id')->where('title', 'like', '%' . $request->get('query') . '%')->get();
        
       $articles->map(function ($article) {

            $category = ArticleCategory::select('category_id','route')->where('_id' , $article['category_id'])->first();
            // dd($category);
            $article['route'] = 'en/breastfeeding-advisor/' . $category->route . '/' .$article['route'];
            $article['name'] = $article['title'];
            unset($article['category_id']);
            unset($article['title']);
            return $article;
       });
        
       $articles = $articles->merge($blogs);
       
       return response()->json(['products' => $product, 'articles' => $articles]);
    }
    
    
        public function navbar_search_arabic(Request $request)
    {
        $product = Product::select('arabic.name' , 'route')->where('arabic.name', 'like', '%' . $request->get('query') . '%')->whereNull('deleted_at')->get();
       
       $blogs = Blog::select('arabic.title' , 'route')->where('arabic.title', 'like', '%' . $request->get('query') . '%')->get();
       
       $blogs->map(function ($post) {
            $post['route'] = 'ar/blog/'. $post['route'];
            return $post;
        });
       
       $articles = Article::select('_id','arabic.title','route','category_id')->where('arabic.title', 'like', '%' . $request->get('query') . '%')->get();
        
       $articles->map(function ($article) {

            $category = ArticleCategory::select('category_id','route')->where('_id' ,$article['category_id'])->first();
            $article['route'] = 'ar/breastfeeding-advisor/' . $category->route . '/' .$article['route'];
            unset($article['category_id']);
            return $article;
       });
        
       $articles = $articles->merge($blogs);
       
       return response()->json(['products' => $product, 'articles' => $articles]);
    }
}
