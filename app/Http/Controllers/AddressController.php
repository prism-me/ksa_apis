<?php

namespace App\Http\Controllers;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $address = Address::where('user_id',Auth::id())->get();
        return json_encode($address);
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
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'apartment' => 'required'
        ]);
        $address = $request->all();
      
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        $create = Address::create($address);
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
        $address = Address::where('user_id',Auth::id())->where('_id',$id)->get();
        return $address;
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

            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'apartment' => 'required',
            
        ]);
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
        
            $address = Address::where('user_id',Auth::id())->where('_id',$id)->update($request->all());

            if($address){

                echo json_encode(['message'=>'Data has been saved','status'=>200]);
            
            }else{
            
                echo json_encode(['message'=>'Data has not been saved','status'=>404]);
            
            }
        
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        if($address->delete()){
            echo json_encode(['status'=>1,'message'=>'your task has been deleted']);
        }else{
           echo json_encode(['status'=>0,'message'=>'Server Error while']);

        }  
    }
}
