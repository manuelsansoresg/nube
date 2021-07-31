<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Discover;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/perfil';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        $login = $request->input($this->username());

        // Comprobar si el input coincide con el formato de E-mail
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $field => $login,
            'password' => $request->input('password')
        ];
    }

    protected function authenticated(Request $request, $user)
    {

        $path_real = 'img/profile/'.$user->id;
        $data = array('image_thumb' => $path_real. '/thumb-'.$user->photo, 'image' => $path_real.'/'. $user->photo);
        //dd($data);
        $request->session()->push('user_images', $data);
        User::heartSession($user->id);
        Discover::setUserLogin($user->id); //asignar el id si no existe para que aparezca en descubre

    }

    public function username()
    {
        return 'login';
    }
}
