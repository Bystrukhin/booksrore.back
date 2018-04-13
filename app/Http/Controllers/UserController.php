<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Illuminate\Http\Response;

class UserController extends Controller
{

    public function signup(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);
        $user->save();
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        $user = User::where('email', $request->input('email'))->get();
        return response()->json(['token' => $token, 'user' => $user,
            'message' => 'Successfully created user!'
        ], Response::HTTP_CREATED);
    }

    public function signin(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $request->input('email'))->get();

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'error' => 'Invalid Credentials!'
                ], Response::HTTP_UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token!'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json([
            'token' => $token, 'user' => $user
        ], Response::HTTP_OK);
    }

    public function getUser(Request $request, $id)
    {
        $user = User::where('user_id', '=', $id)
            ->get();

        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($user, Response::HTTP_OK);
    }

    public function postEditUser(Request $request)
    {
        $id = $request->input('id', '');
        $name = $request->input('name', '');
        $email = $request->input('email', '');
        $date = date("Y-m-d H:i:s");

        $user = User::where('users.user_id', $id)
            ->update(['name' => $name, 'email'=>$email, 'updated_at'=>$date]);

        $user->save();

        $user = User::where('email', $request->input('email'))->get();

        if (!$user) {
            return response()->json(['message' => 'User not updated'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([$user], Response::HTTP_CREATED);
    }
}
