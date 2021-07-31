<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUser extends Model
{
    use HasFactory;

    protected $table = 'follow_user';

    static function create($user_follow_id, $user_id)
    {
        $get_follow = FollowUser::where('user_id', $user_id)->where('user_follow_id', $user_follow_id);

        if($get_follow->count() == 0){
            $follow_user = new FollowUser();
            $follow_user->user_id = $user_id;
            $follow_user->user_follow_id = $user_follow_id;
            $follow_user->save();

        }else{
            $get_follow = $get_follow->first();
        }


        /**
        * por cada persona que te siga la pagina da 2 corazones
         */
        $get_profile = ProfileUser::find($user_follow_id);
        $get_profile->heart = $get_profile->heart + 2;
        $get_profile->update();

        /**
        * por cada 2 que tu sigas obtienes 1 corazón
         */
        $get_follow_me = ProfileUser::where('user_id',$user_id)->first();

        if($get_follow_me->cont_corazones < 3 ){
            $total =  $get_follow_me->cont_corazones +1;
            $get_follow_me->cont_corazones = $total;

            if( $total == 2){
                $get_follow_me->heart = $get_follow_me->heart + 1;
                $get_follow_me->cont_corazones = 0;
            }

            $get_follow_me->update();
        }


    }

    static function unfollow($user_follow_id, $user_id)
    {
        $profile_user = ProfileUser::where('user_id', $user_id)->first();
        if($profile_user->cont_corazones < 3 && $profile_user->cont_corazones > 0){
            $total =  $profile_user->cont_corazones -1;
            $profile_user->cont_corazones = $total;
            if( $total == 2){
                $profile_user->heart = $profile_user->heart + 1;
                $profile_user->cont_corazones = 0;
            }

            $profile_user->update();
        }else{
            if($profile_user->rest_corazones < 3){
                $total =  $profile_user->rest_corazones +1;
                $profile_user->rest_corazones = $total;
                if( $total == 2){
                    $profile_user->heart = $profile_user->heart - 1;
                    $profile_user->rest_corazones = 0;
                }
                $profile_user->update();
            }
        }
        $get_follow = FollowUser::where('user_id', $user_id)->where('user_follow_id', $user_follow_id);
        $get_follow->delete();
    }
    
}
