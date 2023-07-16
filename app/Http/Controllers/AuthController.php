<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $input = $request->validated();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $success['name'] = $user->name;
        $success['email'] = $user->email;
        $success['token'] = $user->createToken('MyApp')->plainTextToken;

        return response()->json(['success' => true, 'message' => 'User register successfully.', 'data' => $success], 201);
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            $success['token'] = $user->createToken('MyApp')->plainTextToken;

            return response()->json(['success' => true, 'message' => 'User login successfully.', 'data' => $success], 200);
        } else {
            return response()->json(['success' => false, 'error' => 'Unauthorised', 'data' => []], 403);
        }
    }
}
