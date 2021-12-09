<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sec = Section::all();

        return json_encode($sec);
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
            'page_id' => 'required',
            'name' => 'required',
            'content' => 'required',
        ]);
        
        if($validator->fails()){
       
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{

            $sections = Section::create($request->all());

            if($sections){
       
                echo json_encode(['message'=>'Data has been Saved','status'=>200]);
       
            }else{
       
                echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
       
            }
    }
    
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return json_encode($section);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        return json_encode($section);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        $validator = Validator::make($request->all(), [
            'page_id' => 'required',
            'name' => 'required',
            'content' => 'required',
        ]);
        
        if($validator->fails()){
       
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{

            $sections = Section::where('_id',$section->_id)->update($request->all());

            if($sections){
       
                echo json_encode(['message'=>'Data has been Saved','status'=>200]);
       
            }else{
       
                echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
       
            }
    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        if($section->delete()){

            echo json_encode(['message'=>'Data has been deleted','status'=>200]);
        
        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }
    public function all_sections($id)
    {  
        
         $section = Section::where('page_id',$id)->get();

         return $section;
    }

}
