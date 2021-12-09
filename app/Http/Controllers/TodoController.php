<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $todo = Todo::all();
        return json_encode($todo);
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
        $todo = Todo::create($request->all());

        if($todo){
            echo json_encode(['status'=>1,'message'=>'your task has been added']);
        }else{
           echo json_encode(['status'=>0,'message'=>'Server Error while']);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        return json_encode($todo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        return json_encode($todo);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $todo->todo_name = $request->todo_name;
        $todo->todo_description = $request->todo_description;
        $todo->is_read = $request->is_read;

        
        if($todo->save()){
            echo json_encode(['status'=>1,'message'=>'your task has been added']);
        }else{
           echo json_encode(['status'=>0,'message'=>'Server Error while']);

        }   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        if($todo->delete()){
            echo json_encode(['status'=>1,'message'=>'your task has been deleted']);
        }else{
           echo json_encode(['status'=>0,'message'=>'Server Error while']);

        }  
    }
}
