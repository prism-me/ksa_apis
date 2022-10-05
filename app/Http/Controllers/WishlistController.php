<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Notifications\AddedToWishlist;
use Illuminate\Support\Facades\Notification;
class WishlistController extends Controller
{   
    public function __construct() {
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $wishlist = Wishlist::where('user_id',$request->user_id)->get();
        return $wishlist;

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
            'user_id' => 'required',
            'product' =>'required',
        ]);

        if($validator->fails()){
    
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
        
        }else{  
        
            $data = $request->product;
            $product_id = $data['product_id'];
            $data['user_id'] = $request->user_id;
            
   
           if( Wishlist::where('product_id',$product_id)->where('user_id',$request->user_id)->count() < 1){
                $wish = Wishlist::create($data);
                if($wish){
                    
                    echo json_encode(['message'=>'Data has been saved','status'=>200]);
                
                }else{
                
                    echo json_encode(['message'=>'Data has not been saved','status'=>404]);
                
                }
            }else{
             echo json_encode(['message'=>'Already Exist','status'=>400]);
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      
        $wishlist = Wishlist::where('_id',$id)->first();
        return $wishlist;
    }

   


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
      
        

        
    }
    
    public function delete_wishlist(Request $request){
        
        if(Wishlist::where('user_id',$request->user_id)->where('_id',$request->wishlist_id)->delete()){
            
            
            $data = Wishlist::where('user_id',$request->user_id)->get();
            
            return $data;
            
            //echo json_encode(['data'=> $data ,'status'=>200]);
        }else{
            echo json_encode(['message'=>'Data is not updated','status'=>404]);
        } 
    }
}
