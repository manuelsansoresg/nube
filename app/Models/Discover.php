<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discover extends Model
{
    use HasFactory;
    static function top($max = 20)
    {
        return Discover::join('users', 'users.id', '=', 'discovers.user_id')->limit($max)->get();
    }

    static function setUserLogin($user_id)
    {
        $discover = Discover::where('user_id', $user_id)->count();
        if($discover == 0){

            $get_discover = Discover::where('status', 0)->orderBy('updated_at', 'desc')->first();

            if ($get_discover != null){
                $find_discover = Discover::find($get_discover->id);
                $find_discover->status = 1;
                $find_discover->user_id = $user_id;
                $find_discover->update();
            }

        }else{
            $find_discover = Discover::where('user_id', $user_id)->first();
            $find_discover->status = 1;
            $find_discover->update();
        }
    }
}
