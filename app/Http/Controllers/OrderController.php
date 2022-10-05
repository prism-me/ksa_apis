<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class OrderController extends Controller
{


    public function  index(Request $request) {

        $data = Order::where('user_id',$request->user_id)->get();
        return $data;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_detail' => 'required',
            'tax' => 'required',
            'total_amount' => 'required',
        ]);
        $order = $request->all();
        $order['user_id'] = Auth::id();
        $order['order_number'] = uniqid();
        $order['status'] = 'processing';
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $create = Order::create($order);
        if($create){
       
            echo json_encode(['message'=>'Data has been Saved','status'=>200]);
   
        }else{
   
            echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
   
        }


        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return $order;
        
    }
    
    public function allOrder(){
        $orders = Order::all();
        return $orders;
    }

  
   
}
