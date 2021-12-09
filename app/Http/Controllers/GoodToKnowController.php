<?php

namespace App\Http\Controllers;

use App\Models\GoodToKnow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class GoodToKnowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gtk = GoodToKnow::all();

        return $gtk ;
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

            'title'  => 'required',
            'featured_img' => 'required',
            'content' => 'required',
            
        ]);
        
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
        
            $upload = GoodToKnow::create($request->all());

            if($upload){

                echo json_encode(['message'=>'Data has been saved','status'=>200]);
            
            }else{
            
                echo json_encode(['message'=>'Data has not been saved','status'=>404]);
            
            }
        
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GoodToKnow  $goodToKnow
     * @return \Illuminate\Http\Response
     */
    public function show(GoodToKnow $goodToKnow)
    {
        return $goodToKnow;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GoodToKnow  $goodToKnow
     * @return \Illuminate\Http\Response
     */
    public function edit(GoodToKnow $goodToKnow)
    {
        return $goodToKnow;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GoodToKnow  $goodToKnow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoodToKnow $goodToKnow)
    {
        $validator = Validator::make($request->all(), [
            'title'  => 'required',
            'featured_img' => 'required',
            'content' => 'required',
            
        ]);
        
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
        
            $upload = GoodToKnow::where('_id' , $goodToKnow->_id)->update($request->all());

            if($upload){

                echo json_encode(['message'=>'Data has been saved','status'=>200]);
            
            }else{
            
                echo json_encode(['message'=>'Data has not been saved','status'=>404]);
            
            }
        
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GoodToKnow  $goodToKnow
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoodToKnow $goodToKnow)
    {
        if($goodToKnow->delete()){

            echo json_encode(['message'=>'Data has been deleted','status'=>200]);
        
        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }
}
