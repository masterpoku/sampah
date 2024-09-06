<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   public function register(Request $request)
   {
    $validator = Validator::make($request->all(),[
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'confirm_password' => 'required|same:password'
    ]);
    if ($validator->fails()) {
        return response()->json([
            'sussess' => false,
            'massage'   => 'ada kesalahan',
            'data'      => $validator->errors()
        ]);
        }
        $input = ([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => 2,
            'password' => Hash::make($request->password),
        ]);
        $user = User::create($input);
        $success['token'] = $user->createToken('auth_token')->plainTextToken;
        $success['name'] = $user->name;

        return response()->json([
            'sussess' => true,
            'massage'   => 'success',
            'data'      => $success
        ]);
   }
   public function login (Request $request)
   {
     if (auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $auth = Auth::user();
        $success = $auth->createToken('auth_token')->plainTextToken;

        $data = Auth::user()->id_device;
        return response($success);
     } else {
        return response()->json([
            'sussess'   => true,
            'massage'   => 'success',
            'data'      => 'data null'
        ]);
     }

   }
}
