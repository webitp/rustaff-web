<?php

namespace App\Http\Controllers\Auth;

use Invisnik\LaravelSteamAuth\SteamAuth;
use App\User;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $steam;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SteamAuth $steam)
    {
        $this->steam = $steam;
    }

    public function index(Request $request) 
    {
        $token = $request->header('Authorization');
        $user = $this->getUser($token);
        if (!$user) 
            return $this->register();
        else
            return $this->sendAuthData($user, true);
    }

    public function handle(Request $request) 
    {
        $handle = $this->steamLogin();
        if ($handle)
            return redirect('https://rustaff.net/?token=' . $handle->remember_token);
        return redirect('https://rustaff.net/');
    }

    public function redirectToSteam() 
    {
        return $this->steam->redirect();
    }

    protected function register()
    {
        $steamLogin = $this->steamLogin();
        if ($steamLogin)
            return $this->sendAuthData($steamLogin, true);
        return $this->sendAuthData($this->steam->getAuthUrl(), false);
    }

    protected function steamLogin()
    {
        if ($this->steam->validate()) 
        {
            $user_info = $this->steam->getUserInfo();

            if (!is_null($user_info))
            {
                $user = $this->findOrCreate($user_info);
                Auth::login($user, true);
                return $user;
            }
        }
        return false;
    }    

    protected function getUser($token)
    {
        if ($token)
        {
            $user = User::where('remember_token', $token)->first();
            if ($user)
                return $user;
        }
        return false;
    }

    protected function findOrCreate($data)
    {
        $user = User::where('steamid', $data->steamID64)->first();
        if (!$user) {
            return User::create([
                'name' => $data->personaname,
                'steamid' => $data->steamID64,
                'avatar' => $data->avatarfull,
                'money' => 0
            ]);
        } else {
            if ($user->remember_token == null) {
                $user->remember_token = Hash::make(time());
                $user->avatar = $data->avatarfull;
                $user->save();
            }
        }
        return $user;
    }

    private function sendAuthData($content, $isAuth) {
        return response()->json([
            'auth' => $isAuth,
            'content' => $content
        ], 200);
    }
}
