<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
       
        $pages = Cache::remember('category_list', 60*60*24 , function () {

            return  Page::whereNull('deleted_at')->get();
       
        });    
           
        return $pages;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


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
            'title' => 'required',
            'description' => 'required',
            'slug' => 'required',
        ]);
        
        if($validator->fails()){
       
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
            
           // return $request->all();
            
            $creatPage = Page::create($request->all());

            if($creatPage){
       
                echo json_encode(['message'=>'Data has been Saved','status'=>200]);
       
            }else{
       
                echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
       
            }

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return $page;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return $page;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'slug' => 'required',
        ]);
        
        if($validator->fails()){
       
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{

            $creatPage = Page::where('route',$page->route)->update($request->all());

            if($creatPage){
       
                echo json_encode(['message'=>'Data has been Saved','status'=>200]);
       
            }else{
       
                echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
       
            }

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        if($page->delete()){

            echo json_encode(['message'=>'Data has been deleted','status'=>200]);
        
        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }

    public function get_pages(){

        $page = Cache::remember('blog' , 60*60*24 ,function(){
         return Page::select('_id','title','cms_route','slug','arabic.details','meta_details')->whereNull('deleted_at')->get();
        });
        return $page;
    }
}
