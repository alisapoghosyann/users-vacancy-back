<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserLikes;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserLikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function like(Request $request)
    {
        $user = JWTAuth::user();

        UserLikes::create([
            'user_id' => $user->id,
            'liked_user_id' => $request->id,
        ]);

        $liked = UserLikes::where('user_id', $user->id)->get()->toArray();
        User::where('id', $request->id)->increment('likes');

        return response()->json([
            'likes' => $liked
        ]);
    }

    public function disLikePerson(Request $request)
    {
        $user = JWTAuth::user();

        $item = UserLikes::where('liked_user_id','=', $request->id)->where('user_id','=', $user->id)->delete();
        $liked = UserLikes::where('user_id', $user->id)->get()->toArray();
        User::where('id',$request->id)->decrement('likes');


        return response()->json([
            'likes' => $liked
        ]);
    }
}
