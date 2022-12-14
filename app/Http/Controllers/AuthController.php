<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register','all_users','reset']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) 
    {

        $check = User::where('email','=',$request->email)->count();
        $user = User::where('email','=',$request->email)->get();
        
        if($check > 0 && $request->is_social){
            
            $dd = ['name'=> $request->name , 'email'=>$request->email ,'password'=>$request->password];
            $check = ['email' =>$request->email ,'password'=>$request->password];
            if (! $token = auth()->attempt($dd)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            return $this->createNewToken($token);
            
            

        }else{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|between:2,100',
                'email' => 'required|string|email|max:100|unique:users',
                'password' => 'required|string|confirmed|min:6',
            ]);
            
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            
            $request['password'] = bcrypt($request->password);
    
             $user = User::create($request->all());
      
             $check = ['email' =>$request->email ,'password'=>$request->password];
            if (! $token = auth()->attempt($validator->validated())) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
    
            return $this->createNewToken($token);
        }
        
        
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
    
    public function all_users(){
        
        $users =  User::where('type','!=','admin')->get();
        
        return $users;
        
    }
    
    public function reset(Request $request){


        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'changed_password' =>'required'
        ]);

        if(!$validator->fails()){
            $check = ['email' =>$request->email ,'password'=>$request->password];

            if( $token = auth()->attempt($check)){

                
                $data = ['password'=> bcrypt($request->changed_password)];

                $isUserUpdated = User::where($request->email)->update($data);

                if($isUserUpdated){

                    echo json_encode(['message' => 'Password has been changed successfully.']);

                }else{
                echo json_encode(['message' => 'Password is not changed , server error']);
                }


            }else{

                echo json_encode(['message'=>'Current Password is wrong.']);
            }





        }else{
            
            return response()->json($validator->errors()->toJson(), 400);
        }

    }
}