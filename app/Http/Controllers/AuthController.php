<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ResponseHelper;

class AuthController extends Controller
{

    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function register(RegisterUser $request)
    {
        $data = $request->validated();
        unset($data['confirm_password']);

        $created = $this->user->create($data);

        if ($created == null)
            return response()->json(['status' => 'ERROR', 'msg' => 'Operation Fail'], 510);
        return response()->json(['status' => 'OK', 'data' => $created], 220);

    }

    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = null;
        if (Auth::attempt($data)) {

            $user = Auth::user();
            $user->token = $user->createToken('around-you-app')->accessToken;
        }
        if ($user == null) return response()->json(['status' => 'ERROR', 'msg' => "Not Authorized"], 440);

        return response()->json(['status' => 'OK', 'data' => $user], 220);
    }

    public function logOut(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['status' => 'OK', 'data' => 'Logout Success'], 200);
    }


}
