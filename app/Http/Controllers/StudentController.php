<?php

namespace App\Http\Controllers;
use App\module;
use App\User;
use App\users_patient;
use App\module_navigation;
use App\navigation;
use Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\patient;

class StudentController extends Controller
{
    public function index()
    {
        //Only Student can access Student Dashboard
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {

            $saved_patients_modules = array();
            $submitted_patients_modules = array();
            $saved_message = '';
            $submitted_message = '';

            $saved_patients = patient::where('created_by', Auth::user()->id)
                ->where('completed_flag',false)
                ->where('archived',false)
                ->get();

            $submitted_patients = patient::where('created_by', Auth::user()->id)
                ->where('completed_flag',true)
                ->where('archived',false)
                ->get();

            if(count($saved_patients)>0) {
                foreach ($saved_patients as $patient) {
                    if ($patient->module) {
                        array_push($saved_patients_modules, $patient->module->module_name);
                    } else {
                        $saved_message = 'There are no saved patients associated with this student.';
                    }
                }
            }
            else {
                $saved_message = 'There are no saved patients associated with this student.';
            }

            if(count($submitted_patients)>0) {
                foreach ($submitted_patients as $patient) {
                    if ($patient->module) {
                        array_push($submitted_patients_modules, $patient->module->module_name);
                    } else {
                        $submitted_message = 'There are no submitted patients associated with this student.';
                    }
                }
            }
            else {
                $submitted_message = 'There are no submitted patients associated with this student.';
            }

            $saved_patients_modules = array_unique($saved_patients_modules);
            $submitted_patients_modules = array_unique($submitted_patients_modules);

            return view('student/studentHome', compact('saved_patients','saved_patients_modules', 'submitted_patients_modules', 'saved_message','submitted_patients','submitted_message'));
        }
        else
        {
            $error_message= "You are not authorized to view this page";
            return view('errors/error',compact('error_message'));
        }
    }

    public function view_patient($id){
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {
            //Student cannot view submitted patients
            $patient_status = patient::where('patient_id',$id)->pluck('completed_flag');
            if($patient_status[0])
            {
                $error_message= "You cannot view submitted patient.";
                return view('errors/error',compact('error_message'));
            }
            else {
                return redirect()->route('Demographics', $id);
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page";
            return view('errors/error',compact('error_message'));
        }
    }
   public function destroy($id)
   {
       $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student')
        {
            patient::where('patient_id', $id)
                ->update(['archived' => 1]);
            return redirect()->route('student.home');
        }
        else {
                $error_message = "You are not authorized to view this page";
                return view('errors/error', compact('error_message'));
            }
    }

    public function get_add_patient()
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {
            try {
                    $modules = module::where('archived', 0)->get();
                    return view('patient/add_patient', compact('modules'));

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page";
            return view('errors/error',compact('error_message'));
        }
    }
    public function post_add_patient(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {

               //Validating input data
                $this->validate($request, [
                    'gender' => 'required',
                    'age' => 'required|numeric',
                    'room_number' => 'required',
                    'visit_date' => 'required|date|before:today',
                ]);

                $patient = new patient($request->all());

                //Fetching last inserted patient_id to generate Patient name
                $last_patient = patient::max('patient_id');
                if ($last_patient == null)
                    $append_number = 1;
                else
                    $append_number = $last_patient + 1;

                //if sex is male then first name is John else Jane
                $patient['first_name'] = $request['gender'] === 'Male' ? 'John' : 'Jane';
                $patient['last_name'] = 'Doe' . $append_number;
                $patient['archived'] = false;
                $patient['completed_flag'] = false;
                $patient['module_id'] = $request['module_id'];
                $patient['room_number'] = $request['room_number'];
                $patient['created_by'] = $request['user_id'];
                $patient['updated_by'] = $request['user_id'];

                $patient->save();

                //Inserting record for admin
                DB::table('users_patient')->insert(
                    array(
                        'patient_record_status_id' => 1,
                        'patient_id' => $patient->patient_id,
                        'user_id' => $request['user_id'],
                        'created_by' => $request['user_id'],
                        'updated_by' => $request['user_id']
                    )
                );

                //Now redirecting student to active record page.
                return redirect()->route('Demographics',[$patient->patient_id]);
        }
        else
        {
            $error_message= "You are not authorized to view this page";
            return view('errors/error',compact('error_message'));
        }

    }

}
