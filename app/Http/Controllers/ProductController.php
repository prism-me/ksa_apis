<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\Media;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        if(request()->page == 'all'){
            
            $category = Product::with(['reviews','category_order','sub_category_order'])->whereNull('deleted_at')->orderBy('order', 'asc')->get();
        

        }else{
            
            $category = Product::with(['reviews','category_order','sub_category_order' ])->whereNull('deleted_at')->orderBy('order', 'asc')->paginate(12);


        }

        // $pp = new Product(); 
        // $product = $pp->uploads($cat);
         return $category;
       
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
            'name' => 'required',
            'featured_img' => 'required',
            'long_description' => 'required',
            'category' => 'required',
            'images_list' => 'required',
            'banner_images_list' => 'required',
            'meta_details' =>'required'
        ]);
        
        if($validator->fails()){
       
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{

            $creatProduct = Product::create($request->all());

            if($creatProduct){
       
                echo json_encode(['message'=>'Data has been Saved','status'=>200]);
       
            }else{
       
                echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
       
            }
        }
    
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {    
        $product->categories =  $product->categories;
        $product->reviews =  $product->reviews;
            
        $total_reivews = count($product->reviews);

        if($total_reivews > 0){
            
        $count = 0;
        
        foreach($product->reviews as $rev){

            $count += $rev->rating;
            
            $rev->user = $rev->user ;
            
        }
            
        $product->avg_rating =  $count / $total_reivews ;
        } 

        if($product->deleted_at != null){

            echo json_encode(['message'=>'No record found.' ,'status'=>200]);
           } else{
               
               return $product;
           }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {


        if($product->deleted_at != null){

            echo json_encode(['message'=>'No record found.' ,'status'=>200]);
           } else{
               
            $product->categories =  $product->categories;
          
            return $product;
           }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'featured_img' => 'required',
            'long_description' => 'required',
            'category' => 'required',
            'images_list' => 'required',
            'banner_images_list' => 'required',
            'meta_details' =>'required',
        ]);
        
        
        if($validator->fails()){
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
        }else{
            $data = $request->except('_id');
            $creatProduct = Product::where('route',$request->route)->update($request->all());
          
            if($creatProduct){
                echo json_encode(['message'=>'Data has been Saved','status'=>200]);
            }else{
                echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
            }
        }
        

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if($product->delete()){

            echo json_encode(['message'=>'Data has been deleted','status'=>200]);
        
        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }

        public function filteredProduct(Request $request ,$category = null , $sub_category = null ,$filter = null){
            
         $search = [];
         
         $page =$request->input('page');
        
        if($category != null && $category !='null'){
         
            $category = Category::where('route',$category)->select('_id')->get();
         
            $category = $category[0]->_id;    
        
            $search['category'] = $category;
        }
        
        if($sub_category != null && $sub_category !='null'){
            
             $sub_category = Category::where('route',$sub_category)->select('_id')->get();
         
            $sub_category = $sub_category[0]->_id;  
            
            $search['sub_category'] = $sub_category;
        }
        
        if($filter != null && $filter != 'null'){
            
            if($filter == 'all'){

                $cat = Product::where($search)->whereNull('deleted_at')->orderby('order','asc')->paginate(12);
        
            }else{
                
                $search['sortings'] = $filter;
                
                $cat = Product::where($search)->whereNull('deleted_at')->orderby('order','asc')->paginate(12);
            }
            
        }else{
          
            $cat = Product::where($search)->whereNull('deleted_at')->orderby('order','asc')->paginate(12);
        
            
        }
        
              return $cat;
        
    }

    public function import() 
    {   
        
         Excel::import(new ProductImport , request()->file('file'));
             
         return back();
    }


    public function productIndexing(Request $request){
        
        $data = $request->product_data;
        
        
        
        foreach($data as $single){
            
                        
            $product = Product::where('route' , $single['route'])->update(['currentIndex' => $single['currentIndex']]);
            
            
        }
        
        
        return ['data'=>'product order has been updated.','status'=>200];
        
        
    }
    public function productList(Request $request , $category = null , $sub_category = null , $filter = null)
    {
            
        $search = [];
         
        $page = $request->input('page');
        
        if($category != null && $category !='null'){
         
            $category = Category::where('route',$category)->select('_id')->get();
         
            $category = $category[0]->_id;    
        
            $search['category'] = $category;
        }
        
        if($sub_category != null && $sub_category !='null'){
            
             $sub_category = Category::where('route',$sub_category)->select('_id')->get();
         
            $sub_category = $sub_category[0]->_id;  
            
            $search['sub_category'] = $sub_category;
        }
        
        if($filter != null && $filter != 'null'){
            
            if($filter == 'all'){

                $cat = Product::select('_id','name','featured_img','arabic.name','route')->where($search)->whereNull('deleted_at')->orderby('order','asc')->take(12)->get();
        
            }else{
                
                $search['sortings'] = $filter;
                
                $cat = Product::select('_id','name','featured_img','arabic.name','route')->where($search)->whereNull('deleted_at')->orderby('order','asc')->take(12)->get();
            }
            
        }else{
          
            $cat = Product::select('_id','name','featured_img','arabic.name','route')->where($search)->whereNull('deleted_at')->orderby('order','asc')->take(12)->get();
          
            
        }
        
              return response()->json([ 'data' => $cat ] , 200);
        
    }

}
