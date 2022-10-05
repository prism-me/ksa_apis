<?php

namespace App\Http\Controllers;
use App\Models\Card;
use Illuminate\Http\Request;
use Validator;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       
         $address = Card::where('user_id',$request->user_id)->whereNull('deleted_at')->get();
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
       $input = $request->all();
       $input['user_id'] = $request->user_id;
     
       $create  = Card::create($input);
       if($create){
            echo json_encode(['message'=>'Data has been Saved','status'=>200]);
        }else{
            echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
       return $card;
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all(); 
        $update = Card::where('_id',$id)->update($input);   
        if($update){
            echo json_encode(['message'=>'Data has been Saved','status'=>200]);
        }else{
            echo json_encode(['message'=>'Data has not been Saved' ,'status'=>404]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        if($card->delete()){
            echo json_encode(['status'=>1,'message'=>'Card has been deleted']);
        }else{
           echo json_encode(['status'=>0,'message'=>'Server Error while']);

        }  
    }
}
