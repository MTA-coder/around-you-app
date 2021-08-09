<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEditRequest;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    private $user;

    /**
     * UserController constructor.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function edit(UserEditRequest $request)
    {
        $data = $request->validated();

        $updated = $this->user->where('id',Auth::id())->update( $data);

        if($updated==null){
            return response()->json(['status' => 'ERROR', 'msg' => 'Operation Fail'], 510);
        }
        return response()->json(['status' => 'OK', 'data' => $updated], 230);
    }
}
