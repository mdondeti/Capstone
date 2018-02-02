<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Input;
use App\User;

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
    
    //Overwriting post login method
    protected function redirectTo()
    {
        $email=strtolower(Input::get('email'));
        $user =User::where('email',$email)->first();
        if($user)
        {            
            //Archived user cannot login           
            if(!$user->archived) 
            {

                if ($user->role == 'Student')
                    return '/StudentHome';
                if ($user->role == 'Admin')
                    return '/home';
                if ($user->role == 'Instructor')
                    return '/InstructorHome';
            }
            else
            {
                return '/account_deleted';
            }
        }
//        else
//        {
//            return '/login';
//        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function email()
    {
        return strtolower(Input::get('email'));
    }
    protected function get_login_page()
    {  
        Auth::logout();
        return view('auth/login');
    }
}
