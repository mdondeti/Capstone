<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\EmailidRole;
use App\navigation;
use App\module;
use App\module_navigation;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {  
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Only Admin can access Admin Dashboard
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Admin') {
        //Fetching all students and instructors for display on admin landing page

         $students = User::where('role','Student')
             ->where('archived','=','0')
             ->get();

         $instructors = User::where('role','Instructor')
             ->where('archived','=','0')
             ->get();

         return view('admin/home', compact('students','instructors'));
        }
        else
        {
            return view('auth/not_authorized');
        }
    }
    public function getStudentEmails()
    {
        $counter = 1;
        session()->put('counter', 1);
        $Error = '';
        return view('admin/addStudentEmails', compact('Error','counter'));
    }
    public function postStudentEmails(Request $request)
    {
        try {
                $counter = session()->get('counter');

                //Removing Duplicates
                $request['email'] = array_unique($request['email']);

            for ($i = 0; $i < count($request['email']) ; ++$i)
                 {
                    $EmailIdRole = new EmailidRole;
                    $EmailIdRole['email'] = strtolower($request['email'][$i]);
                    $EmailIdRole['role'] = 'Student';
                    $EmailIdRole->save();
                 }
                $Error = 'No';
                return view('admin/addStudentEmails',compact('Error','counter'));
            }
        catch (\Exception $e)
        {
            //Checking if its UNIQUE constraint violation. This is one of the worst code I have ever written
            // in my life

            if(in_array('23505',$e->errorInfo)) {
                $Error = 'Email Present';
                return view('admin/addStudentEmails',compact('Error','counter'));
            }
            return view ('errors/503');
        }
    }
    public function addStudentEmails()
    {
        $counter = session()->get('counter');
        $counter = $counter + 1;
        session()->put('counter', $counter);
        $Error = '';
        return view('admin/addStudentEmails',compact('Error','counter'));

    }
    public function removeStudentEmails()
    {
        $counter = session()->get('counter');
        $counter = $counter - 1;
        session()->put('counter', $counter);
        $Error = '';
        return view('admin/addStudentEmails',compact('Error','counter'));

    }
    public function getInstructorEmails()
    {
        $counter = 1;
        session()->put('counter', 1);
        $Error = '';
        return view('admin/addInstructorEmails', compact('Error','counter'));
    }
    public function postInstructorEmails(Request $request)
    {
        try {
                $counter = session()->get('counter');

                //Removing Duplicates
                $request['email'] = array_unique($request['email']);

                 for ($i = 0; $i < $counter; $i++)
                 {
                     $EmailIdRole = new EmailidRole;
                     $EmailIdRole['email'] = strtolower($request['email'][$i]);
                     $EmailIdRole['role'] = 'Instructor';
                     $EmailIdRole->save();
                 }
                $counter = session()->get('counter');
                $Error = 'No';
                return view('admin/addInstructorEmails',compact('Error','counter'));
            }
        catch (\Exception $e)
        {
            //Checking if its UNIQUE constraint violation. This is one of the worst code I have ever written
            // in my life

            if(in_array('23505',$e->errorInfo)) {
                $Error = 'Email Present';
                return view('admin/addInstructorEmails',compact('Error','counter'));
            }
            return view ('errors/503');
        }
    }
    public function addInstructorEmails()
    {
        $counter = session()->get('counter');
        $counter = $counter + 1;
        session()->put('counter', $counter);
        $Error = '';
        return view('admin/addInstructorEmails',compact('Error','counter'));
    }
    public function removeInstructorEmails()
    {
        $counter = session()->get('counter');
        $counter = $counter - 1;
        session()->put('counter', $counter);
        $Error = '';
        return view('admin/addInstructorEmails',compact('Error','counter'));
    }
    public function get_remove_emails()
        {
          $studentEmails = EmailidRole::where('role','Student')->pluck('email');
          $studentEmails = str_replace(['['], '', $studentEmails);
          $studentEmails = str_replace(['"'], '', $studentEmails);
          $studentEmails = str_replace(['"'], '', $studentEmails);
          $studentEmails = str_replace([']'], '', $studentEmails);
          $studentEmails = explode(",", $studentEmails);

          $registered_student_emails = User::where('role','Student')->pluck('email');
          $registered_student_emails = str_replace(['['], '', $registered_student_emails);
          $registered_student_emails = str_replace(['"'], '', $registered_student_emails);
          $registered_student_emails = str_replace(['"'], '', $registered_student_emails);
          $registered_student_emails = str_replace([']'], '', $registered_student_emails);
          $registered_student_emails = explode(",", $registered_student_emails);

          $studentEmails = array_diff($studentEmails,$registered_student_emails);
          $studentDetails = array();
          foreach($studentEmails as $studentEmail)
          {
              $studentDetail = EmailidRole::where('email',$studentEmail)->get();
              array_push($studentDetails,$studentDetail);
          }

          $instructorEmails = EmailidRole::where('role','Instructor')->pluck('email');
          $instructorEmails = str_replace(['['], '', $instructorEmails);
          $instructorEmails = str_replace(['"'], '', $instructorEmails);
          $instructorEmails = str_replace(['"'], '', $instructorEmails);
          $instructorEmails = str_replace([']'], '', $instructorEmails);
          $instructorEmails = explode(",", $instructorEmails);

          $registered_instructor_emails = User::where('role','Instructor')->pluck('email');
          $registered_instructor_emails = str_replace(['['], '', $registered_instructor_emails);
          $registered_instructor_emails = str_replace(['"'], '', $registered_instructor_emails);
          $registered_instructor_emails = str_replace(['"'], '', $registered_instructor_emails);
          $registered_instructor_emails = str_replace([']'], '', $registered_instructor_emails);
          $registered_instructor_emails = explode(",", $registered_instructor_emails);

          $instructorEmails = array_diff($instructorEmails,$registered_instructor_emails);
          $instructorDetails = array();
          foreach($instructorEmails as $instructorEmail)
          {
              $instructorDetail = EmailidRole::where('email',$instructorEmail)->get();
              array_push($instructorDetails,$instructorDetail);
          }
          return view('admin/remove_emails', compact('studentDetails','instructorDetails'));
        }
    public function getConfigureModules()
    {
        $navs = navigation::all();
        $mods = module::where('archived', false)->get();
        $navs_mods = module_navigation::where('visible', true)->get();
        return view('admin/configureModules', compact ('navs', 'mods', 'navs_mods'));
    }
    public function submitmodule(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Admin') {
            $messages = ['required' => 'Module name is mandatory.'];

            //Validating input data
            $this->validate($request, [
                'modulename' => 'required',
            ], $messages);

            $module = new module;
            $module->module_name = $request->input('modulename');
            $module->archived = false;
            $module->save();
            $var = $module->module_id;

            $navs = $request->input('navs');

            //if any child selected, parent shoul get auto selected.

            for ($i = 3; $i < 7; $i++) {
                if (in_array("$i", $navs)) {
                    array_push($navs, '2');
                    break;
                }
            }
            for ($i = 10; $i < 19; $i++) {
                if (in_array("$i", $navs)) {
                    array_push($navs, '9');
                    break;
                }
            }
            for ($i = 20; $i < 29; $i++) {
                if (in_array("$i", $navs)) {
                    array_push($navs, '19');
                    break;
                }
            }

            $navs = array_unique($navs);

            foreach ($navs as $navid) {
                DB::table('modules_navigations')->insert(
                    ['module_id' => $var, 'navigation_id' => $navid, 'visible' => true]);
            }

            $navs = navigation::all();
            $mods = module::where('archived', false)->get();
            $navs_mods = module_navigation::where('visible', true)->get();
            return view('admin/configureModules', compact('navs', 'mods', 'navs_mods'));
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }

    public function deletemodule($modid)
    {
        module::where('module_id',$modid)->update(['archived' => true]);
        $navs = navigation::all();
        $mods = module::where('archived', false)->get();
        $navs_mods = module_navigation::where('visible', true)->get();
        return view('admin/configureModules', compact ('navs', 'mods', 'navs_mods'));
    }
    public function delete_email($id)
    {
        $email = EmailidRole::find($id);
        $email->delete();
         return redirect('RemoveEmails')->with('success','Email has been deleted');
    }
    public function archive_user($id)
    {
        User::where('id',$id)
            ->update(['archived'=> 1]);
        $email = User::where('id',$id)->pluck('email');

        return redirect('/home')->with('success','Email has been  deleted');

    }

}
