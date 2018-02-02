<?php
/*
 Developer - Varun Parihar
 Date - 09/23/2017
 Description - Controller Code for Edit Profile functionality.
*/
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Log;
class UsersController extends Controller
{
    public function getEditProfile()
    {
        try {
            $email=Auth::user()->email;
            $user = User::where('email', $email)->first();
            return view('user/editprofile',compact('Profilesubmitted','user', 'erroredForm'));
        }
        catch (Exception $e)
        {
            return view ('errors/503');
        }
    }
    public function postEditProfile(Request $request)
    {
        $email = Auth::user()->email;
        $user = User::where('email', $email)->first();
        $oldHashedPassword = $user->password;
        //To check if contact number is of valid format
        if (empty($request['firstname']))
        {
            $request->session()->flash('empty_firstname', 'First Name cannot be blank.');
        }
        elseif (empty($request['lastname']))
        {
            $request->session()->flash('empty_lastname', 'Last Name cannot be blank.');
        }
        elseif (!empty($request['contactno']) and strlen($request['contactno']) !== 10)
        {
            $request->session()->flash('invalid_contact', 'Please provide a valid 10 digit Contact No.');
        }
        else
        {
            // To check if old password provided by user is empty or not.
            if (!empty($request['old']))
            {
                // To check if old password is equal to the current password.
                if (Hash::check($request->old, $oldHashedPassword))
                {
                    $user['departmentName'] = $request['departmentName'];
                    $user['firstname'] = $request['firstname'];
                    $user['lastname'] = $request['lastname'];
                    $user['contactno'] = $request['contactno'];
                    //To check if new password is empty or not.
                    if (!empty($request['password']))
                    {
                        //To check if new password meets length requirements.
                        if(strlen($request['password']) < 6)
                        {
                            $request->session()->flash('password_short', 'Password length should be more than 6 characters.');
                        }
                        else
                        {
                            // To check if new password matches with confirm password.
                            if($request['password'] == $request['password_confirmation'])
                            {
                                $user['password'] = Hash::make($request->password);
                                $user->save();
                                $request->session()->flash('success', 'Profile updated successfully.');
                            }
                            else
                            {
                                $request->session()->flash('new_and_confirm_mismatch', 'Confirm Password should match with new Password.');
                            }
                        }
                    }
                    else
                    {
                        $request->session()->flash('new_password_empty', 'New password cannot be blank.');
                    }
                }
                else
                {
                    $request->session()->flash('old_current_mismatch', 'Old Password entered does not match with your current password.');
                }
            }
            // To check if new password is not empty
            elseif (empty($request['old']) and !empty($request['password']) and !empty($request['password_confirmation']))
            {
                $request->session()->flash('old_blank', 'Old Password cannot be left blank.');
            }
            else
            {
                log:info('Dhakkan'.$request['password']);
                $user['departmentName'] = $request['departmentName'];
                $user['firstname'] = $request['firstname'];
                $user['lastname'] = $request['lastname'];
                $user['contactno'] = $request['contactno'];
                $user->save();
                $request->session()->flash('success', 'Profile updated successfully.');
            }
        }
        return redirect()->route('EditProfile',$user->id);
    }
}
