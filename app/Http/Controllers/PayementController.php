<?php

namespace App\Http\Controllers;
use App\Models\Payement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class PayementController extends Controller
{
    
    public function  index() {

        $data = Payement::where('user_id',Auth::id())->get();
        return $data;

    }

    public function store(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'payement_type' => 'required',
            'amount' => "required"
        ]);
        $order = $request->all();
        $order['order_number'] = $id;
        $order['status'] = 'pending';
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // if($request->payement_type == 'cod'){
        //     $data['amount'] = $request->amount + 10 ;
            
        // }
        $create = Payement::create($order);
        if($create){
       
            echo json_encode(['message'=>'Data has been Saved','status'=>200]);
   
        }else{
   
            echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
   
        }
    }

    public function show(Payement $payement,$id)
    {
        $data = Payement::where('order_number',$id)->get();
        return $data;

    }


   


    

   

   
}
