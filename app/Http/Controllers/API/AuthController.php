<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\{RegisterApiRequest,LoginApiRequest};
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(RegisterApiRequest $request){
        try{

            User::create(["name"=>$request->name,"email"=>$request->email,
            "password"=>bcrypt($request->password),"email_verified_at"=>Carbon::now()]);
            return response()->json([
                'message' => trans("messages.register_success"),
            ],Response::HTTP_CREATED);
        }catch(Exception $e){
            return response()->json([
                'message' => $e->getMessage(),
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function login(LoginApiRequest $request){
        try {

           if (!Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'message' => trans("messages.incorrect_credentials"),
            ],Response::HTTP_BAD_REQUEST);
        }
            $user = Auth::user();
            $token = $user->createToken("auth_token")->plainTextToken;
            return response()->json([
                'message' => trans("messages.login_success"),
                'token'=>$token
            ],Response::HTTP_OK);

        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function logout(){
        try {
            Auth::user()->currentAccessToken()->delete();
            return response()->json([
                'message' => trans("messages.logout_success"),
            ],Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ],Response::HTTP_BAD_REQUEST);
        }

    }
}
