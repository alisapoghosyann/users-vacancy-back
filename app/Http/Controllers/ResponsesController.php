<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResponsesRequest;
use App\Mail\ResponseMail;
use App\Models\Responses;
use App\Models\User;
use Carbon\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Mail;


class ResponsesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function message(ResponsesRequest $request)
    {
        $user = JWTAuth::user();

        if ($user->coins > 0) {
            $msg = $request->message;
            $message_user = User::where('id', $request->id);

            $some = Responses::where('creator_id', $user->id)->where('vacancy_id', $request->vacancy_id)->get()->toArray();
            if (sizeof($some) < 2) {
                Responses::create([
                    'creator_id' => $user->id,
                    'vacancy_id' => $request->vacancy_id,
                    'message' => $request->message,
                ]);
                $user::decrement('coins');

                foreach ($message_user as $item) {
//                    $emailJob = (new ResponseMail($item->email))->delay(Carbon::now()->addMinutes(60));
                Mail::to($item->email)->send(new ResponseMail($msg, $user));
                return new JsonResponse([
                    'message' => 'true',
                ], 201);
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Message successfully sent',
                ]);
            } else if (sizeof($some) >= 2) {
                return response()->json([
                    'status' => ["id"=>$request->vacancy_id,"res"=>"You have exceeded your  commenting limit to same post(2 comment)"],
                ]);
            }
        } else {
            return response()->json([
                'status' => "You are haven't any coins",
            ]);
        }
    }
}
