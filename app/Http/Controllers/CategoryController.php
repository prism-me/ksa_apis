<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $categories = Category::with('children')->whereNull('deleted_at')->get();

        return $categories;
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
            'name' => 'required',
            'featured_img' => 'required',
            'long_description' => 'required'
        ]);

        if($validator->fails()){
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
        }else{

            $creatCat = Category::create($request->all());
        }

        if($creatCat){
            echo json_encode(['message'=>'Data has been Saved','status'=>200]);
        }else{
            echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
       if($category->deleted_at != null){

        echo json_encode(['message'=>'No record found.' ,'status'=>200]);

    } else{
            
            $singleCategory = Category::with('children')->where('_id',$category->_id)->get();
           return $singleCategory;
       }
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        if($category->deleted_at != null){

            echo json_encode(['message'=>'No record found.' ,'status'=>200]);
           } else{
               
               return $category;
           }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'featured_img' => 'required',
            'long_description' => 'required'
        ]);

        if($validator->fails()){
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
        }else{

         $creatCat = Category::where('_id',$category->_id)->update($request->all());
         
         if($creatCat){
            echo json_encode(['message'=>'Data has been Saved','status'=>200]);
        }else{
            echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
        }
        
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->delete()){

            echo json_encode(['message'=>'Data has been deleted','status'=>200]);
        
        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }

    }
    
    
    public function category_sorting(Request $request){


   foreach($request->all() as $data){
       
       $category_data = ['order'=>$data['order'] , 'temp_id'=>$data['temp_id']];
       
       $category = Category::where('_id', $data['_id'])->update($category_data);
       
       if($category){
  
        foreach($data['children'] as $childrens){
           
           
           $sub_category_data = ['order'=>$childrens['order'] , 'temp_id'=>$childrens['temp_id']];
       
           $sub_category_data = Category::where('_id', $childrens['_id'])->update($sub_category_data);
           
           
       
        }
        
        echo json_encode(['status'=>1,'message'=>'Data has been saved']);
     
       }else{
           
             echo json_encode(['status'=>0,'message'=>'Data has not been saved']);
       }
       
   }
    
    

    }

    public function product_sorting(Request $request){


       foreach($request->all() as $data){
       
       $category_data = ['order'=>$data['order'] , 'temp_id'=>$data['temp_id'],'finalOrder'=>$data['finalOrder']];
       
       $category = Product::where('_id', $data['_id'])->update($category_data);
       
       if($category){
           
           echo json_encode(['status'=>1,'message'=>'Data has been saved']);
       
           
       }else{
           
           echo json_encode(['status'=>0,'message'=>'Data has not been saved']);
       
           
       }
       
   }

    }
}
