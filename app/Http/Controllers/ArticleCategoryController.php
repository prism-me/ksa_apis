<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ArticleCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articleCategory = ArticleCategory::all();
        return $articleCategory;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'title'  => 'required',
            'featured_img' => 'required',
            'content' => 'required',
            'route' => 'required'
            
        ]);
        
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
        
            $upload = ArticleCategory::create($request->all());

            if($upload){

                echo json_encode(['message'=>'Data has been saved','status'=>200]);
            
            }else{
            
                echo json_encode(['message'=>'Data has not been saved','status'=>404]);
            
            }
        
        }
    }

    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ArticleCategory $articleCategory)
    {   
        if($articleCategory == null){

            echo json_encode(['message'=>'No Record Found','status'=>400]);

        }else{

            $articles = Article::where('category_id',$articleCategory->_id)->get();

            return $articles;


        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ArticleCategory $articleCategory)
    {
        return $articleCategory;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ArticleCategory $articleCategory)
    {
        $validator = Validator::make($request->all(), [
            
            'title'  => 'required',
            'featured_img' => 'required',
            'content' => 'required',
            'route' => 'required'
            
        ]);
        
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
        
            $upload = ArticleCategory::where('route' , $articleCategory->route)->update($request->all());

            if($upload){

                echo json_encode(['message'=>'Data has been saved','status'=>200]);
            
            }else{
            
                echo json_encode(['message'=>'Data has not been saved','status'=>404]);
            
            }
        
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ArticleCategory  $articleCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ArticleCategory $articleCategory)
    {
        if($articleCategory->delete()){

            echo json_encode(['message'=>'Data has been deleted','status'=>200]);
        
        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }

    public function single_article_category($route){

    
        $cat = ArticleCategory::whereNull('deleted_at')->where('route',$route)->first();

        return $cat;

    }


    public function single_article_category_update(Request $request , $route){

        
        $validator = Validator::make($request->all(), [
            
            'title'  => 'required',
            'featured_img' => 'required',
            'content' => 'required',
            'route' => 'required'
            
        ]);
        
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
        
            $upload = ArticleCategory::where('route' , $route)->update($request->all());

            if($upload){

                echo json_encode(['message'=>'Data has been saved','status'=>200]);
            
            }else{
            
                echo json_encode(['message'=>'Data has not been saved','status'=>404]);
            
            }
        
        
    }
    }




}

