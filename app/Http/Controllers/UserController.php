<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json([$user], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'id' => 'required',
            'email' => 'required|email',
        ]);

        $user = User::find($request->input('id', null));
        $user->name = $request->input('name', '');
        $user->email = $request->input('email', '');
        $user->updated_at = date("Y-m-d H:i:s");
        $user->save();

        $user = User::find($request->input('id', null));

        if (!$user) {
            return response()->json(['message' => 'User not updated'], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([$user], Response::HTTP_CREATED);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);
        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);
        $user = new User([
            'name' => $request->input('name'),
            'remember_token' => $token,
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password'))
        ]);
        $user->save();
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
        $user = User::where('email', $request->input('email'))->first();
        $user->remember_token = $token;
        $user->save();

        return response()->json([
            'token' => $token, 'user' => $user
        ], Response::HTTP_OK);
    }
}
