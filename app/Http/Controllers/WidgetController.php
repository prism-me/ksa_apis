<?php

namespace App\Http\Controllers;

use App\Models\Widget;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class WidgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $w = Widget::whereNull('deleted_at')->get();
        return $w;
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
            'page_id'  => 'required',
            'widget_name' => 'required',
            'widget_type' => 'required',
            'widget_content' => 'required',
        ]);
        
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
            
            if(!$request->_id){
                
                $upload = Widget::create($request->all());
                
            }else{
            
                $upload = Widget::where('_id',$request->_id)->update($request->except(['_id']));
                
            }

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
     * @param  \App\Models\widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function show(Widget $widget){
       
        return $widget;
    
    }

    public function all_widgets($id)
    {  
    
         $widget = Widget::where('page_id', $id)->whereNull('deleted_at')->get();

         return $widget;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function edit(Widget $widget)
    {
    //    return $widget ;
        //$widget = Widget::where('widget_type',$request->type)->get();

        if($widget->deleted_at != null){

            echo json_encode(['message'=>'No record found.' ,'status'=>200]);
          
        } else{
               
            return $widget;
           
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Widget $widget)
    {
        $validator = Validator::make($request->all(), [
           
            'widget_name' => 'required',
            'widget_type' => 'required',
            'widget_content' => 'required',
        ]);
        
        if($validator->fails()){
        
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);
       
        }else{
        
            $upload = Widget::where('_id',$widget->_id)->update($request->all());

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
     * @param  \App\Models\widget  $widget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Widget $widget)
    {
        if($widget->delete()){

            echo json_encode(['message'=>'Data has been deleted','status'=>200]);
        
        }else{
            echo json_encode(['message'=>'Data has not been deleted' ,'status'=>404]);
        }
    }
}
