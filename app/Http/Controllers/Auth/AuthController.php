<?php

namespace App\Http\Controllers\Auth;

use App\Representative;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $loginPath = '/';
    /**
     * Create a new authentication controller instance.
     *
     *
     */

    public function __construct()
    {
        $this->middleware('guest', ['except' => ['getLogout','getRegister','postRegister']]);
        $this->middleware('auth',['only'=>['getRegister','postRegister']]);
//        $this->middleware('admin',['only'=>['getRegister','postRegister']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
//            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'phone' => 'required|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
            'type'=>'required',

        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user= User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'type'=>$data['type'],
            'name' => $data['name']!==''?$data['name']:$data['email'],
            'phone' => $data['phone']
        ]);

        return $user;
    }
}
