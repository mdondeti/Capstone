<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Monolog\Logger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    protected $erroredForm = '';
    protected $PasswordChanged = '';

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    protected function resetUserPassword(Request $request)
    {
        try {
            $security_answer = '';
            $security_answer_fetched = '';
            
            $email = $request->email;

            //Reading random security question generated on last page
            $randomQuestionNumber = $_POST['randomQuestionNumber'];

            $user = DB::table('users')->where('email', $email)->first();
                  
            if($randomQuestionNumber == '1')
            {
                $security_answer = strtolower($request->security_answer1);
                $security_answer_fetched = $user->security_answer1;           
            }
            if($randomQuestionNumber == '2')
            {
                $security_answer = strtolower($request->security_answer2);
                $security_answer_fetched = $user->security_answer2;
            }
            if($randomQuestionNumber == '3')
            {
                $security_answer = strtolower($request->security_answer3);
                $security_answer_fetched = $user->security_answer3;
            }

            if ($security_answer == $security_answer_fetched)
            {
                $PasswordChanged='';
                $erroredForm='';
                return view('auth/passwords/reset', compact('user','randomQuestionNumber','PasswordChanged','erroredForm'));
            }
            else
            {
                $wrongSecurityAnswers = 'Yes';
                return view('auth/passwords/email', compact('wrongSecurityAnswers'));
            }
        }
        catch (\Exception $e)
        {
            return view ('errors/503');
        }
    }

    protected function changePassword(Request $request)
    {
        try {
                $email = $request->email;

                if(strlen($_POST['password']) < 6)
                {
                    $erroredForm= 'Password short';
                    $PasswordChanged='';
                }
                else
                {
                    if($_POST['password'] == $_POST['password_confirmation'])
                    {            
                        $password = Hash::make($request->password);
                        DB::table('users')->where('email', $email)->update(['password' => $password]);
                        $PasswordChanged = 'Yes';
                        $erroredForm= '';                      
                    }
                    else
                    {
                        $erroredForm= 'Passwords do not match';
                        $PasswordChanged='';
                           
                    }   
                }
                
                $user = DB::table('users')->where('email', $email)->first();
                return view('auth/passwords/reset', compact('user','PasswordChanged','erroredForm'));      
        }
        catch (\Exception $e)
        {
            return view ('errors/503');
        }
    }
}
