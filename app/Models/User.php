<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Verot\Upload\Upload;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'last_name', 'username', 'email', 'state_id', 'town_id', 'phone', 'biography', 'photo', 'thumb'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function create($request, $path)
    {
        $data = array();
        /*
         * salvar usuario
         * */
        $user = new User($request->except('_token', 'photo', 'social_id', 'social', 'password_confirmation'));
        $user->username = strtolower($request->username);
        $user->password = Hash::make($request->password);
        $user->save();

        $get_user = User::find($user->id);
        /*
         * redimencionar imagenes uno por 500 * 500 y para el area descubre 75*75
         * */
        $path = $path.'/'.$get_user->id;
        $upload_photo = self::uploadPhoto($_FILES['photo'], $request, $path); //metodo para adjuntar imagen en perfil
        $get_user->photo = $upload_photo['fullNameImage'];
        $get_user->update();


        Discover::setUserLogin($get_user->id); //asignar el id si no existe para que aparezca en descubre

        /*
         * guardar en la tabla profile
         * */
        $profile_user = new ProfileUser();
        $profile_user->user_id = $get_user->id;
        $profile_user->heart = 30;
        $profile_user->cont_profile = 0;
        $profile_user->save();
        /*
         * guardar la red social que eligio
         * */
        $cont_social_id = -1;

        foreach ($request->social as $social) {
            $cont_social_id = $cont_social_id + 1;

            if($social != null){
                $social_id =  $request->social_id[$cont_social_id];
                $social_user = new SocialUser();
                $social_user->user_id = $get_user->id;
                $social_user->social_id = $social_id;
                $social_user->url= $social;
                $social_user->save();
            }
        }

        Auth::login($get_user);
        $data['image_thumb'] = $upload_photo['image_thumb'];
        $data['image'] = $upload_photo['image'];
        $data['status'] = 200;
        return $data;

    }

    public static function edit($request, $path)
    {
        $data     = array();
        $get_user = User::find(Auth::id());

        $get_user->fill($request->except('_token', 'photo', 'social_id', 'social', 'password_confirmation', 'username'));

        $get_user->username = strtolower($request->username);
        $path               = $path . '/' . Auth::id();
        $upload_photo       = self::uploadPhoto($_FILES['photo'], $request, $path); //metodo para adjuntar imagen en perfil

        /**
         * borrar de la tabla solcial para reasignar valores
         */
        $get_social = SocialUser::where('user_id', $get_user->id);
        if($get_social != null){
            $get_social->delete();
        }

        if(is_array($upload_photo)){
            @unlink($path.'/'.$get_user->photo);
            @unlink($path. '/thumb-'.$get_user->photo);

            $get_user->photo     = $upload_photo['fullNameImage'];
            $data['image_thumb'] = $upload_photo['image_thumb'];
            $data['image']       = $upload_photo['image'];
        }
        $get_user->update();
        Discover::setUserLogin($get_user->id); //asignar el id si no existe para que aparezca en descubre

        /*
        * guardar la red social que eligio
        * */
        $cont_social_id = -1;


        foreach ($request->social as $social) {

            $cont_social_id = $cont_social_id + 1;
            if($social != null){

                $social_id =  $request->social_id[$cont_social_id];

                $social_user = new SocialUser();
                $social_user->user_id = $get_user->id;
                $social_user->social_id = $social_id;
                $social_user->url= $social;
                $social_user->save();
            }
        }


        $data['status'] = 200;
       // print_r($data);
        return $data;
    }

    public static function uploadPhoto($photo , $request, $path){

        if($request->hasFile('photo') != false){
            $data       = array();
            $image      = $request->file('photo');
            $fullName   = $image->getClientOriginalName();
            $extension  = $image->getClientOriginalExtension();
            //$onlyName = uniqid('profile-').'.'. $extension;
            $name_image = uniqid('profile-');
            
            

            /*$image->move($path, $name_image);*/
            @File::makeDirectory('./'.$path);
            /* crear el thumb */
            $thumb = new Upload($_FILES['photo']);

            if ($thumb->uploaded) {
                $thumb->file_new_name_body   = $name_image;
                $thumb->image_resize         = true;
                $thumb->image_ratio_crop     = true;
                $thumb->image_x              = 500;
                $thumb->image_y              = 500;
                $thumb->process('./'.$path.'/');
            }

            $thumb = new upload($photo);
            if ($thumb->uploaded) {
                $thumb->file_name_body_pre   = 'thumb-';
                $thumb->file_new_name_body   = $name_image;
                $thumb->image_resize         = true;
                $thumb->image_ratio_crop     = true;
                $thumb->image_x              = 75;
                $thumb->image_y              = 75;
                $thumb->process('./'.$path.'/');
            }


            $data['fullNameImage'] = $name_image. '.' . $extension;
            $data['fullNameThumb'] = 'thumb-'.$name_image. '.' . $extension;
            $data['image_thumb']   = $path . '/'.$name_image. '.' . $extension;
            $data['image']         = $path . '/' . $name_image. '.' . $extension;

            return $data;
        }
    }

    public static function random()
    {
        $user = ProfileUser::select('users.id', 'username', 'photo')
                    ->join('users', 'users.id', '=' , 'profile_user.user_id')
                    ->orderBy('cont_profile', 'desc')
                    ->limit(200)->get();

        return $user;
    }

    public static function searchByUser($search, $limit = 0)
    {
        DB::enableQueryLog();
        if(Auth::id() != null){
            $user = User::select('users.id as id', 'username', 'photo', 'towns.name as name_town', 'states.name as name_state', 'heart',
                DB::raw('(SELECT COUNT(0) as user from follow_user where (follow_user.user_follow_id=users.id)) as follows'),
                DB::raw('(SELECT user_id FROM follow_user WHERE user_id = '.Auth::id().' and user_follow_id=users.id) as btn'))
                ->join('states', 'states.id', '=', 'users.state_id')
                ->join('towns', 'towns.id', '=', 'users.town_id')
                ->join('profile_user', 'profile_user.user_id', '=', 'users.id')
                ->orderBy( 'profile_user.heart' , 'desc');
                
                if(Auth::id() != null){
                    $user->where('users.id', '!=', Auth::id());  
                }
                
                if($search != 'all'){
                    $user->where('username', 'like', "%$search%");
                
                }
                
                if($limit != 0){
                    $user->limit($limit);
                }

                return $user->get();
                
        }else{
            $user = User::select('users.id as id', 'username', 'photo', 'towns.name as name_town', 'states.name as name_state', 'heart',
                DB::raw('(SELECT COUNT(0) as user from follow_user where (follow_user.user_follow_id=users.id)) as follows'))
                ->join('states', 'states.id', '=', 'users.state_id')
                ->join('towns', 'towns.id', '=', 'users.town_id')
                ->join('profile_user', 'profile_user.user_id', '=', 'users.id')
                ->orderBy( 'profile_user.heart', 'desc');
                
                if ($search != 'all') {
                    $user->where('username', 'like', "%$search%");
                }
               
                if ($limit != 0) {
                    $user->limit($limit);
                }

                return $user->get();
        }

        

        /* dd( DB::getQueryLog()); */

    }

    public static function myUser($user_id)
    {
        $my_user = null;
        if(Auth::id() != null){
            $my_user = User::select('users.id', 'biography', 'username','users.name', 'last_name', 'photo', 'users.photo', 'towns.name as name_town', 'states.name as name_state', 'heart',
                DB::raw('(SELECT COUNT(user_id) from follow_user where (follow_user.user_id=users.id)) as follows '),
                DB::raw('(SELECT COUNT(user_id) from follow_user where (follow_user.user_follow_id=users.id)) as follow_me '),
                DB::raw('(SELECT user_id FROM follow_user WHERE user_id = '.$user_id.' and user_follow_id=users.id) as btn'))
                ->where('users.id', $user_id)
                ->join('states', 'states.id', '=', 'users.state_id')
                ->join('towns', 'towns.id', '=', 'users.town_id')
                ->join('profile_user', 'profile_user.user_id', '=', 'users.id')
                ->first();
        }else{

            $my_user = User::select('users.id', 'biography', 'username','users.name', 'last_name', 'photo', 'users.photo', 'towns.name as name_town', 'states.name as name_state', 'heart',
                DB::raw('(SELECT COUNT(user_id) from follow_user where (follow_user.user_id=users.id)) as follows '),
                DB::raw('(SELECT COUNT(user_id) from follow_user where (follow_user.user_follow_id=users.id)) as follow_me '))
                ->where('users.id', $user_id)
                ->join('states', 'states.id', '=', 'users.state_id')
                ->join('towns', 'towns.id', '=', 'users.town_id')
                ->join('profile_user', 'profile_user.user_id', '=', 'users.id')
                ->first();
        }

        return $my_user;
    }

    public static function loadCalendar($date_in, $date_fin, $userId)
    {
        return Calendar::select('user_id as id', 'photo', 'fpublicacion')
                    ->whereBetween('fpublicacion', [$date_in, $date_fin])
                    ->where('user_id', $userId)
                    ->get();
    }

    public static function mySocial($user_id)
    {
        $social = SocialUser::select( 'socials.url as link', 'class', 'name', 'icon' , 'social_user.url as url' )
                    ->where( 'user_id', $user_id)
                    ->join( 'socials', 'socials.id', '=', 'social_user.social_id')
                    ->get();

        return $social;
    }

    public static function editPassword($password)
    {
        $user = User::find(Auth::id());
        $user->password = Hash::make( $password);
        $user->update();
    }

    public static function getFollowed($page, $user_id)
    {
        DB::enableQueryLog();
        $followed = FollowUser::select('users.id', 'biography', 'username','users.name', 'last_name', 'photo', 'users.photo', 'towns.name as name_town', 'states.name as name_state', 'heart',
            DB::raw('(SELECT COUNT(user_id) from follow_user where (follow_user.user_id=users.id)) as follows '),
            DB::raw('(SELECT COUNT(user_id) from follow_user where (follow_user.user_follow_id=users.id)) as follow_me '),
            DB::raw('(SELECT user_id FROM follow_user WHERE user_id = '.$user_id.' and user_follow_id=users.id) as btn'))
                    ->join('users', 'users.id', '=', 'follow_user.user_follow_id')
                    ->join('states', 'states.id', '=', 'users.state_id')
                    ->join('towns', 'towns.id', '=', 'users.town_id')
                    ->join('profile_user', 'profile_user.user_id', '=', 'follow_user.user_follow_id')
                    ->orderBy('profile_user.heart', 'desc')
                    ->where('follow_user.user_id', $user_id);

        if($page != null){
            $followed->offset( $page );
            $followed->limit(5);
        }

        $followed = $followed->get();
        /*dd( DB::getQueryLog());*/
        return $followed;
    }

    public static function getFollower($user_id)
    {
        $follower = FollowUser::select('users.id', 'biography', 'username','users.name', 'last_name', 'photo', 'users.photo', 'towns.name as name_town', 'states.name as name_state', 'heart',
            DB::raw('(SELECT COUNT(user_id) from follow_user where (follow_user.user_id=users.id)) as follows '),
            DB::raw('(SELECT COUNT(user_id) from follow_user where (follow_user.user_follow_id=users.id)) as follow_me '),
            DB::raw('(SELECT user_id FROM follow_user WHERE user_id = '.$user_id.' and user_follow_id=users.id) as btn'))
            ->join('users', 'users.id', '=', 'follow_user.user_id')
            ->join('states', 'states.id', '=', 'users.state_id')
            ->join('towns', 'towns.id', '=', 'users.town_id')
            ->join('profile_user', 'profile_user.user_id', '=', 'follow_user.user_id')
            ->orderBy('profile_user.heart', 'desc')
            ->where('follow_user.user_follow_id', $user_id)
            ->get();
        return $follower;
    }

    public static function btnFollow($user_id, $my_user_id)
    {
        if($my_user_id != null){
            if($user_id != $my_user_id){ // si el usuario no es igual al de sesion
                $follow = FollowUser::where('user_id', $my_user_id)->where('user_follow_id', $user_id)->count();
                return $follow;
            }
        }
        return false;
    }

    public static function heartSession($user_id)
    {
        $fecha = ProfileUser::where('user_id', $user_id)->first();

        if($fecha->date_last_session != date('Y-m-d') ){

            $newHeart = $fecha->heart + 30;
            $fecha->date_last_session =  date('Y-m-d');
            $fecha->heart = $newHeart;
            $fecha->update();
        }
    }
    
}
