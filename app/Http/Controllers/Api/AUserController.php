<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use App\Models\FollowUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AUserController extends Controller
{
    public function show($search, Request $request)
    {
        
        $get_user   = User::searchByUser($search, $request->top);
        $data       = array('users' => $get_user, 'total_users' => count($get_user),  'user_id' => Auth::id());
        return response()->json( $data );
    }

    public function userCalendar(Request $request)
    {
        $date_in  = $request->date_in;
        $date_fin = $request->date_fin;
        $userId   = Auth::id();
        $calendar = User::loadCalendar($date_in, $date_fin, $request->userId);
        $data     = array($calendar, $userId);
        return response()->json($data);
    }

    public function update_pass(PasswordRequest $request)
    {
        $edit_pass = User::editPassword($request->password);
    }

    public function follow(Request $request)
    {
        FollowUser::create($request->user_follow_id, Auth::id());
        return response()->json(array('status' => 200));
    }

    public function unfollow(Request $request)
    {
        FollowUser::unfollow($request->user_follow_id, Auth::id());
        return response()->json(array('status' => 200));
    }

    public function followed(Request $request)
    {

        $getFollowed = User::getFollowed(null, $request->user_id);
        $data        = array('users' => $getFollowed, 'total_users' => count($getFollowed), 'user_id' => Auth::id());
        return response()->json($data);
    }

    public function follower(Request $request)
    {
        $getFollower = User::getFollower($request->user_id);
        $data        = array('users' => $getFollower, 'total_users' => count($getFollower), 'user_id' => Auth::id());
        return response()->json($data);
    }

    public function getFollowed(Request $request)
    {
        $my_user     = User::myUser($request->user_id);
        return response()->json($my_user);
    }
}
