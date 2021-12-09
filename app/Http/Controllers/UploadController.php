<?php

namespace App\Http\Controllers;

use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UploadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $m = Upload::whereNull('deleted_at')->get();
        return $m;
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
            'avatar' => 'required',
            'type' => 'required',
            'alt_tag' => 'required',
        ]);
        
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
        
            $upload = Upload::create($request->all());

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
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function show(Upload $upload)
    {
        if($upload->deleted_at != null){

            echo json_encode(['message'=>'No record found.' ,'status'=>200]);
          
        } else{
               
            return $upload;
           
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function edit(Upload $upload)
    {
        if($upload->deleted_at != null){

            echo json_encode(['message'=>'No record found.' ,'status'=>200]);
          
        } else{
               
            return $upload;
           
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upload $upload)
    {
        $validator = Validator::make($request->all(), [
            'avatar' => 'required',
            'type' => 'required',
            'alt_tag' => 'required',
        ]);
        
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
        
            $upload = Upload::where('_id',$upload->_id)->update($request->all());

            if($upload){

                echo json_encode(['message'=>'Data has been saved','status'=>200]);
            
            }else{
            
                echo json_encode(['message'=>'Data has not been saved','status'=>404]);
            
            }
        
        }
    }

    public function multipleUpload(Request $request){

        foreach($request->all() as $sigleRequest){

        
            $validator = Validator::make($sigleRequest, [
                'avatar' => 'required',
                'type' => 'required',
                'alt_tag' => 'required',
            ]);
            
            if($validator->fails()){
            
                echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
           
            }else{
            
                $upload = Upload::create($sigleRequest);
    
                if($upload){
    
                    echo json_encode(['message'=>'Data has been saved','status'=>200]);
                
                }else{
                
                    echo json_encode(['message'=>'Data has not been saved','status'=>404]);
                
                }
            
            }
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy(Upload $upload)
    {
        if($upload->delete()){

            echo json_encode(['message'=>'Data has been deleted','status'=>200]);
        
        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }
}
