<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Http\Requests\RegistreUserRequest;
use App\Models\Calendar;
use App\Models\Social;
use App\Models\SocialUser;
use App\Models\State;
use App\Models\TagTitle;
use App\Models\TitleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $path_image;

    public function __construct()
    {
        $this->path_image = 'img/profile';
       /*  $this->middleware('auth'); */
        /*$this->path_real = 'img/profile';*/
    }

    public function perfil()
    {
        $id         = Auth::id();
        $title_id   = '';
        $my_user    = User::myUser($id);
        $path       = $this->path_image;
        $userId     = $id;
        $my_user_id = Auth::id();
        $my_socials = User::mySocial($id);
        $btn_follow = User::btnFollow($id, $my_user_id);
        $keywords   = TitleUser::keywords($title_id);
        $titles     = TitleUser::list($id);

        return view('user.show', compact('my_user', 'path', 'userId', 'my_user_id', 'my_socials', 'btn_follow', 'keywords', 'titles'));
    }

    public function search(Request $request)
    {
        $get_user   = User::searchByUser($request-> inputSearch);
        $get_titles = TagTitle::listTitleTag($request-> inputSearch);
        
        $data       = array('users' => $get_user, 'total_users' => count( $get_user) , 'total_titles' => count( $get_titles), 'titles' => $get_titles, 'user_id' => Auth::id());
        return response()->json($data);
    }



    public function random()
    {
        $get_user = User::random();
        $data = array('users' => $get_user, 'path' => $this->path_image);
        return response()->json($data);
    }

    public function social_user()
    {
        $social_users = SocialUser::getByUser(Auth::id());
        return response()->json($social_users);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $title_id = '')
    {
        $my_user    = User::myUser($id);
        $path       = $this->path_image;
        $userId     = $id;
        $my_user_id = Auth::id();
        $my_socials = User::mySocial($id);
        $btn_follow = User::btnFollow($id, $my_user_id);
        $keywords   = TitleUser::keywords($title_id);
        $titles     = TitleUser::list($id);


        return view('user.show', compact('my_user', 'path', 'userId', 'my_user_id', 'my_socials', 'btn_follow', 'keywords', 'titles'));
    }





    public function load_photo(Request $request)
    {
        $get_photo = Calendar::getPhoto($request->fecha);
        $data = array ('myUserId' => Auth::id(), 'photo' => $get_photo);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $states  = State::all();
        $socials = Social::all();
        $user    = User::find($id);

        $path = './'.$this->path_image.'/'.$user->id.'/';
        return view('user.edit', compact('states', 'socials', 'user', 'path'));
    }

    public function register(RegistreUserRequest $request)
    {

        $user = User::create($request, $this->path_image);
        $request->session()->push('user_images',$user);
        return response()->json($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditUserRequest $request, $id)
    {
        $user = User::edit($request, $this->path_image);
        if(count($user) > 2){
            $request->session()->forget('user_images');
            $request->session()->push('user_images',$user);
        }


        return response()->json($user);
    }

    public function update_pass()
    {
        # code...
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
