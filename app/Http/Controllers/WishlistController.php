<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
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
    public function index()
    {
        
        $user_id = Auth::user()->_id;
        
        if ($user_id)
        {
            $wishlist = Wishlist::with(['user','product'])->where('user_id',$user_id)->whereNull('deleted_at')->get();

            echo json_encode($wishlist);

        }
        else{
            
            echo json_encode(['message'=>'user is not logged in','status'=>403]);
        }

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
            'user_id' => 'required',
            'product_id' =>'required',
        ]);

        if($validator->fails()){
    
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
        
        }else{  
           
        
            $wish = Wishlist::create($request->all());

            if($wish){
                //$user =Auth::user();
                //Notification::send($user, new AddedToWishlist($request->all()));
                //request()->user()->notify(new AddedToWishlist($request->all()));
                echo json_encode(['message'=>'Data has been saved','status'=>200]);
            
            }else{
            
                echo json_encode(['message'=>'Data has not been saved','status'=>404]);
            
            }
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        $wishlist->user =  $wishlist->user;
        $wishlist->product = $wishlist->product;

        return $wishlist;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
        if(Auth::check()){
            
            if($wishlist->delete()){

                echo json_encode(['message'=>'Your wish has been removed successfully','status'=>200]);
            }else{
                echo json_encode(['message'=>'Data is not updated','status'=>404]);
            }
        }else{
            echo json_encode(['message'=>'Unauthorized User','status'=>403]);
        }
    }
}
