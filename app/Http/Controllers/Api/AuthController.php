<?php

namespace App\Http\Controllers\Api;

use App\Events\SendLocation;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    protected $apiToken;

    public function __construct()
    {
        $this->middleware('auth:api')->except('login');
        // Unique Token
        $this->apiToken = uniqid(base64_encode(Str::random(60)));
    }

    public function login(Request $request)
    {
        // Validations
        $rules = [
            'email' => 'required',
            'password' => 'required|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            // Validation failed
            return response()->json([
                'message' => $validator->messages(),
            ]);
        } else {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $apiToken = ['api_token' => $this->apiToken];
                $user = User::where('email', $request->email)->first();

                        User::where('email', $request->email)->update($apiToken);

                        return response()->json([
                            'success' => 1,
                            'user' => [
                                'id' => $user->id,
                                'name' => $user->name,
                                'email' => $user->email != null ? $user->email : '',
                                'phone' => $user->phone,
                                'api_token' => $this->apiToken,
                            ],
                        ]);
                 
                
            } else {
                return response()->json([
                    'success' => 0,

                    'message' => __('api_massage.faild_auth'),
                ]);
            }

        }
    }

    public function logout(Request $request)
    {
        $apiToken = ['api_token' => null];
        $logout = User::where('id', $request->user()->id)->update($apiToken);

        return response()->json([
            'success' => 1,
            'message' => __('api_massage.logout'),

        ]);

    }

   
}
