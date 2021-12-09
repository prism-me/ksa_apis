<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::with('categories')->get();
         return $articles;
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
            'banner_img' => 'required',
            'category_id' => 'required',
            'content' => 'required',
            
        ]);
        
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
        
            $upload = Article::create($request->all());

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
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {   
        
       $article->categories = $article->categories;
        return $article;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
       $article->categories = $article->categories;
        return $article;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {   
        
        $validator = Validator::make($request->all(), [
            'title'  => 'required',
            'featured_img' => 'required',
            'banner_img' => 'required',
            'category_id' => 'required',
            'content' => 'required',
            
        ]);
        
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
        
            $upload = Article::where('route' , $article->route)->update($request->all());

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
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        if($article->delete()){

            echo json_encode(['message'=>'Data has been deleted','status'=>200]);
        
        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }
}
