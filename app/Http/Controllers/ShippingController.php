<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Shipping;
use Validator;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Shipping::all();
        return $data;
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
            'email' => "required",
            'phone' => "required",
            'street' => "required",
            'city' => "required",
            'state' => "required",
            'country' => "required",
            'zip' => "required"
        ]);
        $shipping = $request->all();
        $shipping['user_id'] = Auth::id();
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // if($request->payement_type == 'cod'){
        //     $data['amount'] = $request->amount + 10 ;
            
        // }
        $create = Shipping::create($shipping);
        if($create){
    
            echo json_encode(['message'=>'Data has been Saved','status'=>200]);

        }else{

            echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Shipping::where('_id',$id)->get();
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => "required",
            'phone' => "required",
            'street' => "required",
            'city' => "required",
            'state' => "required",
            'country' => "required",
            'zip' => "required"
        ]);
        $shipping = $request->all();
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        // if($request->payement_type == 'cod'){
        //     $data['amount'] = $request->amount + 10 ;
            
        // }
        
        $update = Shipping::where('_id',$id)->update($request->all());
        if($update){
    
            echo json_encode(['message'=>'Data has been Saved','status'=>200]);

        }else{

            echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $shipping->destroy();

       if($delete){
    
            echo json_encode(['message'=>'Data has been Saved','status'=>200]);

        }else{

            echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);

        }
    }
}
