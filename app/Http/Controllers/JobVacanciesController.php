<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobVacancyRequest;
use App\Models\JobVacancies;
use App\Models\User;
use App\Models\UserLikes;
use App\Models\UserVacancies;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maize\Markable\Models\Like;
use Tymon\JWTAuth\Facades\JWTAuth;

class JobVacanciesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index()
    {
        $job_vacancies = JobVacancies::get()->toArray();

        return response()->json([
            'status' => 'success',
            'jobs' => $job_vacancies,
        ]);
    }

    public function info()
    {
        $user = JWTAuth::user();
        $job_vacancies = JobVacancies::with('responses')->get()->toArray();
        $liked = JobVacancies::whereHasLike(
            $user
        )->get()->toArray();
        $likedPerson = UserLikes::where('user_id', $user->id)->get()->toArray();

        return response()->json([
            'status' => 'success',
            'jobs' => $job_vacancies,
            'liked' => $liked,
            'likedPerson' => $likedPerson
        ]);
    }

    public function store(JobVacancyRequest $request)
    {
        $user = JWTAuth::user();

        if ($user->coins >= 2) {
            $lastPost = JobVacancies::where('user_id',$user->id)->whereDate('created_at','>',Carbon::now()->subDay()->toDateTimeString())->get()->toArray();

            if(sizeof($lastPost)< 2){
                $data = [
                    'user_id' => $user->id,
                    'title' => $request->title,
                    'description' => $request->description,
                ];

                $job_vacancy = JobVacancies::create($data);
                $user::decrement('coins', 2);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Job created successfully',
                    'job_vacancy' => $job_vacancy,
                ]);
            }else if ( sizeof($lastPost) >=2){
                return response()->json([
                    'status' => "You have exceeded your daily posting limit(2 posts)",
                ]);
            }

        } else {
            return response()->json([
                'status' => "You are haven't any coins",
            ]);
        }
    }

    public function likesJob(Request $request)
    {

        $user = JWTAuth::user();
        $job = JobVacancies::findOrFail($request->id);

        Like::add($job, $user);

        JobVacancies::where('id',$request->id)->increment('likes');

        $liked = JobVacancies::whereHasLike(
            auth()->user()
        )->get();

        return response()->json([
            'liked' => $liked
        ]);
    }

    public function removeLike(Request $request)
    {
        $user = JWTAuth::user();

        $job = JobVacancies::findOrFail($request->id);

        Like::remove($job, $user);

        JobVacancies::where('id',$request->id)->decrement('likes');

        $liked = JobVacancies::whereHasLike(
            auth()->user()
        )->get();

        return response()->json([
            'liked' => $liked
        ]);
    }

    public function show()
    {
        $user = JWTAuth::user();

        $id = $user->id;

        $my_vacancies = User::with('job_vacancies')->where('id', $id)->get()->toArray();
        $responses  =  JobVacancies::with('responses')->where('user_id',$id)->get()->toArray();
        return response()->json([
            'status' => 'success',
            'my_vacancies' => $my_vacancies,
            'responses' => $responses
        ]);
    }


    public function update(JobVacancyRequest $request)
    {
        $user = JWTAuth::user();

        $job = JobVacancies::find($request->id);
        $job->title = $request->title;
        $job->description = $request->description;
        $job->save();

        $my_vacancies = User::with('job_vacancies', 'responses')->where('id', $user->id)->get()->toArray();

        return response()->json([
            'status' => 'success',
            'message' => 'Job updated successfully',
            'my_vacancies' => $my_vacancies,
        ]);
    }

    public function destroy(Request $request)
    {
        $job = JobVacancies::find($request->id);
        $job->delete();

        $user = JWTAuth::user();

        $id = $user->id;

        $my_vacancies = User::with('job_vacancies', 'responses', 'user_likes')->where('id', $id)->get()->toArray();

        return response()->json([
            'status' => 'success',
            'my_vacancies' => $my_vacancies,
        ]);
    }

}























