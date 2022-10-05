<?php

namespace App\Http\Controllers;

use App\Models\General;
use App\Models\Product;
use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\contactQueryEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
class GeneralController extends Controller
{
    public function insertContact(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' =>'required',
            'message' =>'required',
        ]);

        if(!$validator->fails()){
            
            $general = General::create($request->all());

            if($general){

                try {
                    $email = ['marketing@pigeonarabia.com'];
   
                    // $maildata = [
                    //     'title' => 'Laravel 8|7 Mail Sending Example with Markdown',
                    //     'url' => 'https://www.positronx.io'
                    // ];
              
                    Mail::to($email)->send(new contactQueryEmail($request->all()));

                } catch (\Throwable $th) {
                    echo 'Error - '.$th;
                }

                echo json_encode(['message'=>'Your request has been submitted, you will be contacted soon.','status'=>200]);
            }else{
                echo json_encode(['message'=>'server error','status'=>404]);
            }

        }else{  
            
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);

        }

    }

    public function fetchContact(){

        $data = General::all();

        return $data;

    }

        public function search(Request $request)
    {
     
        $pro = Product::whereNull('deleted_at')->select('_id','name','route')->get();
        $cat = Category::with('parent_route')->whereNull('deleted_at')->select('_id','name','route','parent_id')->get();
        
        
        $data['data'] =[
            
            'products' =>$pro ,
            'categories' =>$cat
        ];

        return $data;
    }

    public function update_route(){
    
        
        $products = Product::all();

        foreach($products as $product){

            $id = $product->_id;
            
            unset($product->_id);

            //unset($product->categories);

            $product->categories = null; 
            
            //DB::enableQueryLog();
           

            Product::where('_id',$id)->update($product->toArray());

            //dd(DB::getQueryLog());
        }

        print_r($products);
    }
    
        
    public function test(){
        
        // Video::where('_id','60c997b87b4eeb2e51295e02')->update(['category'=>'Bottle Feeding','category_slug'=>'bottle-feeding']);
        
        
        Video::where('_id','60c9977ddab6a501500f2632')->update(['category'=>'Breast Feeding','category_slug'=>'breast-feeding']);
        
            
    }
}
