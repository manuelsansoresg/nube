<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialUser extends Model
{
    use HasFactory;
    protected $table = 'social_user';

    static  function getByUser($user_id)
    {
        return SocialUser::select('social_user.url as name', 'socials.id')->where('user_id', $user_id)->join('socials', 'socials.id', '=', 'social_user.social_id')->get();
    }
}
