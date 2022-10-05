<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;
use Validator;

class UserController extends Controller
{

    public function userDetail(Request $request){
        $user = User::select('name','email','is_social','profile')->where('_id',$request->user_id)->first();
        return $user;
    }

    public function updateUser(Request $request){
        $input = $request->all();
        $update = User::where('_id',$request->user_id)->update($input);
        if($update){
            
            echo json_encode(['message','Profile Updated successfully','status'=>200]);
        }

        echo json_encode(['message','Something Went Wrong','status'=>401]);

    }


    public function reset(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:6',
           
            
        ]);
        if($validator->fails()){
            
            echo json_encode(['errors'=>$validator->errors(),'status'=>404]);

        }else{
           
            $user = User::where('_id',$request->user_id)->first();
    
            if (!Hash::check($request->current_password,$user->password)) {
                echo json_encode(['message','Current password does not match!','status'=>200]);
            }
    
            $user->password = Hash::make($request->password);
            $user->save();
            echo json_encode(['message','Password successfully changed!','status'=>200]);
      
        }
    }
}
