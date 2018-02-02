<?php

namespace App\Http\Controllers;
use App\active_record;
use App\lookup_value;
use App\module_navigation;
use App\navigation;
use App\User;
use App\users_patient;
use Dompdf\Exception;
use Illuminate\Support\Facades\Log;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\patient;
use PhpParser\Node\Expr\Array_;
use PhpParser\Node\Stmt\Switch_;
use PDF;
use App\doc_lookup_value;

class family_member
{
    public $relation;
    public $status;
    public $diagnosis=[];
}

class vital_signs
{
    public $timestamp;
    public $BP_Systolic;
    public $BP_Diastolic;
    public $Heart_Rate;
    public $Respiratory_Rate;
    public $Temperature;
    public $Weight;
    public $Height;
    public $Pain;
    public $Oxygen_Saturation;
    public $Comment;
}

class vital_signs_header
{
    public $age;
    public $BP_systolic;
    public $BP_diastolic;
    public $heart_rate;
    public $respiratory_rate;
    public $temperature;
    public $gender;
    public $room_number;
    public $pain;
    public $visit_date;
    public $oxygen_saturation;
    public $name;
}

class symptom
{
    public $value;
    public $is_saved;
}

class NavigationController extends Controller
{
    public function get_demographics_panel($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {

            //Student cannot view deleted patients
            $patient = patient::where('patient_id', $id)->first();
            if($patient->archived)
            {
                $error_message = "You cannot view deleted patient.";
                return view('errors/error', compact('error_message'));
            }
            //Student cannot edit submitted patients
            elseif ($patient->completed_flag) {
                $error_message = "You cannot edit submitted patient. ";
                return view('errors/error', compact('error_message'));
            }
            else {
                //Fetching all navs associated with this patient's module
                $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');

                $navs = array();
                //Now get nav names
                foreach ($navIds as $nav_id) {
                    $nav = navigation::where('navigation_id', $nav_id)->get();
                    array_push($navs, $nav);
                }

                //Extracting vital signs for header
                $vital_signs_header = $this->get_vital_signs_header($id);

                //Extracting disposition to enable or disable the submit button
                $disposition = active_record::where('patient_id', $id)
                    ->where('navigation_id', '34')->get();

                $user_id = Auth::user()->id;
                $status = users_patient::where('patient_id', $id)->where('user_id', $user_id)->first();
                if($status) {
                    $status_id = $status->patient_record_status_id;
                    return view('patient/demographics_patient', compact('patient', 'navs', 'vital_signs_header', 'disposition', 'status_id'));

                }
                else
                {
                    $error_message= "Student can only view their created patients. You are not authorized to view this page.";
                    return view('errors/error',compact('error_message'));
                }
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }
    public function get_HPI($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {

            //Student cannot view deleted patients
            $patient = patient::where('patient_id', $id)->first();
            if($patient->archived)
            {
                $error_message = "You cannot view deleted patient.";
                return view('errors/error', compact('error_message'));
            }
            //Student cannot edit submitted patients
            elseif ($patient->completed_flag) {
                $error_message = "You cannot edit submitted patient. ";
                return view('errors/error', compact('error_message'));
            }
            else
                {
                    $HPI = active_record::where('patient_id', $id)
                        ->where('navigation_id','1')
                        ->where('doc_control_id','1')->get();

                    //Fetching all navs associated with this patient's module
                    $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');

                    $navs = array();

                    //Now get nav names
                    foreach ($navIds as $key=>$nav_id) {
                        $nav = navigation::where('navigation_id', $nav_id)->get();
                        array_push($navs, $nav);
                    }

                    //Extracting vital signs for header
                    $vital_signs_header = $this->get_vital_signs_header($id);

                    //Extracting disposition to enable or disable the submit button
                    $disposition = active_record::where('patient_id', $id)
                        ->where('navigation_id', '34')->get();
                    $user_id = Auth::user()->id;
                    $status = users_patient::where('patient_id',$id)->where('user_id',$user_id)->first();
                            if($status) {
                                $status_id = $status->patient_record_status_id;
                                return view('patient/HPI', compact ('status_id','HPI','patient','navs','vital_signs_header','disposition'));
                            }
                            else
                            {
                                $error_message= "Student can only view their created patients. You are not authorized to view this page.";
                                return view('errors/error',compact('error_message'));
                            }
                        }
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }
    public function get_medical_history($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {

            //Student cannot view deleted patients
            $patient = patient::where('patient_id', $id)->first();
            if($patient->archived)
            {
                $error_message = "You cannot view deleted patient.";
                return view('errors/error', compact('error_message'));
            }
            //Student cannot edit submitted patients
            elseif ($patient->completed_flag) {
                $error_message = "You cannot edit submitted patient. ";
                return view('errors/error', compact('error_message'));
            }
            else {

            //Getting Personal History values
            $diagnosis_list_personal_history = active_record::where('patient_id', $id)
                ->where('navigation_id','3')
                ->where('doc_control_id','3')->get();
            $personal_history_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','3')
                ->where('doc_control_id','4')->get();

            //Getting Family History values
            $comment_family_history = active_record::where('patient_id', $id)
                ->where('navigation_id','4')
                ->where('doc_control_id','8')->pluck('value');

            $members_family_history = active_record::where('patient_id', $id)
                ->where('navigation_id','4')
                ->where('doc_control_id','5')->get();

            $family_members_details = Array();

            foreach($members_family_history as $member)
            {
                $member_status = active_record::where('patient_id', $id)
                    ->where('navigation_id','4')
                    ->where('doc_control_id','7')
                    ->where('doc_control_group',$member->active_record_id)->pluck('value');

                $member_diagnosis = active_record::where('patient_id', $id)
                    ->where('navigation_id','4')
                    ->where('doc_control_id','6')
                    ->where('doc_control_group',$member->active_record_id)->pluck('value');

                $family_member_details = new family_member();
                $family_member_details->id = $member->active_record_id;
                $family_member_details->relation = $member->value;
                $family_member_details->status = $member_status;
                $family_member_details->diagnosis = $member_diagnosis;

                array_push($family_members_details, $family_member_details);
            }

            //Getting Surgical History values
            $diagnosis_list_surgical_history = active_record::where('patient_id', $id)
                ->where('navigation_id','5')
                ->where('doc_control_id','9')->get();

            $surgical_history_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','5')
                ->where('doc_control_id','10')->get();


            //Getting Social History values
            $social_history_smoke_tobacco="";
            $social_history_non_smoke_tobacco="";
            $social_history_alcohol="";
            $social_history_sexual_activity="";
            $social_history_comment="";
            $social_history_smoke_tobacco_id="";
            $social_history_non_smoke_tobacco_id="";
            $social_history_alcohol_id="";
            $social_history_sexual_activity_id="";
            $social_history_comment_id="";
            $is_new_entry_social_history = "";

            $social_history_values = active_record::where('patient_id',$id)->where('navigation_id','6')->get();
            foreach ($social_history_values as $social_history) {
                Switch($social_history->doc_control_id){
                    case "11":
                        $social_history_smoke_tobacco = $social_history-> value ;
                        $social_history_smoke_tobacco_id = $social_history-> active_record_id ;
                        $is_new_entry_social_history = "no";
                        break;

                    case "12":
                        $social_history_non_smoke_tobacco = $social_history-> value ;
                        $social_history_non_smoke_tobacco_id = $social_history-> active_record_id ;
                        $is_new_entry_social_history = "no";
                        break;

                    case "13":
                        $social_history_alcohol = $social_history-> value ;
                        $social_history_alcohol_id = $social_history-> active_record_id ;
                        $is_new_entry_social_history = "no";
                        break;

                    case "14":
                        $social_history_sexual_activity = $social_history-> value ;
                        $social_history_sexual_activity_id = $social_history-> active_record_id ;
                        $is_new_entry_social_history = "no";
                        break;

                    case "15":
                        $social_history_comment = $social_history-> value ;
                        $social_history_comment_id = $social_history-> active_record_id ;
                        $is_new_entry_social_history = "no";
                        break;
                }

            }
            //Fetching all navs associated with this patient's module
            $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');
            $navs = array();
            //Now get nav names
            foreach ($navIds as $nav_id) {
                $nav = navigation::where('navigation_id', $nav_id)->get();
                array_push($navs, $nav);
            }

            //Converting object to array
            $navIds = str_replace(['['], '', $navIds);
            $navIds = str_replace(['"'], '', $navIds);
            $navIds = str_replace(['"'], '', $navIds);
            $navIds = str_replace([']'], '', $navIds);

            $navIds = explode(",", $navIds);
            array_pop($navIds);

            //Extracting vital signs for header
            $vital_signs_header = $this->get_vital_signs_header($id);

            //Extracting disposition to enable or disable the submit button
            $disposition = active_record::where('patient_id', $id)
                ->where('navigation_id', '34')->get();

            $user_id = Auth::user()->id;
            $status = users_patient::where('patient_id',$id)->where('user_id',$user_id)->first();
                if($status) {
                    $status_id = $status->patient_record_status_id;
                    return view('patient/medical_history', compact ('status_id','navIds','disposition','vital_signs_header','patient','diagnosis_list_surgical_history','surgical_history_comment','diagnosis_list_personal_history','personal_history_comment','family_members_details','comment_family_history','is_new_entry_social_history','diagnosis_list_personal_history','navs','social_history_smoke_tobacco','social_history_non_smoke_tobacco','social_history_alcohol','social_history_sexual_activity','social_history_comment','social_history_smoke_tobacco_id','social_history_non_smoke_tobacco_id','social_history_alcohol_id','social_history_sexual_activity_id','social_history_comment_id'));
                }
                else
                {
                    $error_message= "Student can only view their created patients. You are not authorized to view this page.";
                    return view('errors/error',compact('error_message'));
                }
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }
    public function get_medications($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {

            //Student cannot view deleted patients
            $patient = patient::where('patient_id', $id)->first();
            if($patient->archived)
            {
                $error_message = "You cannot view deleted patient.";
                return view('errors/error', compact('error_message'));
            }
            //Student cannot edit submitted patients
            elseif ($patient->completed_flag) {
                $error_message = "You cannot edit submitted patient. ";
                return view('errors/error', compact('error_message'));
            }
            else {
                $medications = active_record::where('patient_id', $id)
                ->where('navigation_id','7')
                ->where('doc_control_id','16')->get();

            $medication_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','7')
                ->where('doc_control_id','17')->get();

            //Fetching all navs associated with this patient's module
            $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');

            $navs = array();
            //Now get nav names
            foreach ($navIds as $nav_id) {
                $nav = navigation::where('navigation_id', $nav_id)->get();
                array_push($navs, $nav);
            }

            //Extracting vital signs for header
            $vital_signs_header = $this->get_vital_signs_header($id);

            //Extracting disposition to enable or disable the submit button
            $disposition = active_record::where('patient_id', $id)
                ->where('navigation_id', '34')->get();
            $user_id = Auth::user()->id;
            $status = users_patient::where('patient_id',$id)->where('user_id',$user_id)->first();
             if($status) {
                $status_id = $status->patient_record_status_id;
                return view('patient/medications', compact ('status_id','vital_signs_header','medications','medication_comment','patient','navs','disposition'));
            }
            else
            {
                $error_message= "Student can only view their created patients. You are not authorized to view this page.";
                return view('errors/error',compact('error_message'));
            }
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }
    public function get_vital_signs($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {
            //Student cannot view deleted patients
            $patient = patient::where('patient_id', $id)->first();
            if($patient->archived)
            {
                $error_message = "You cannot view deleted patient.";
                return view('errors/error', compact('error_message'));
            }
            //Student cannot edit submitted patients
            elseif ($patient->completed_flag) {
                $error_message = "You cannot edit submitted patient. ";
                return view('errors/error', compact('error_message'));
            }
            else {
            $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');
            $navs = array();
            foreach ($navIds as $nav_id) {
                $nav = navigation::where('navigation_id', $nav_id)->get();
                array_push($navs, $nav);
            }
            $timestamps = active_record::where('patient_id', $id)
                ->where('navigation_id', '8')->distinct()
                ->orderBy('created_at','desc')
                ->pluck('created_at');

            $vital_sign_details = Array();
            foreach($timestamps as $ts)
            {
                $vital_sign_detail = new vital_signs();
                $vital_sign_detail->timestamp = $ts;
                $vital_sign_detail->BP_Diastolic = active_record::where('patient_id', $id)
                    ->where('navigation_id','8')
                    ->where('doc_control_id','19')
                    ->where('created_at',$ts)->pluck('value');
                $vital_sign_detail->BP_Systolic = active_record::where('patient_id', $id)
                    ->where('navigation_id','8')
                    ->where('doc_control_id','18')
                    ->where('created_at',$ts)->pluck('value');
                $vital_sign_detail->Heart_Rate =
                    active_record::where('patient_id', $id)
                        ->where('navigation_id','8')
                        ->where('doc_control_id','20')
                        ->where('created_at',$ts)->pluck('value');
                $vital_sign_detail->Respiratory_Rate = active_record::where('patient_id', $id)
                    ->where('navigation_id','8')
                    ->where('doc_control_id','21')
                    ->where('created_at',$ts)->pluck('value');
                $vital_sign_detail->Temperature = active_record::where('patient_id', $id)
                    ->where('navigation_id','8')
                    ->where('doc_control_id','22')
                    ->where('created_at',$ts)->pluck('value');
                $vital_sign_detail->Weight = active_record::where('patient_id', $id)
                    ->where('navigation_id','8')
                    ->where('doc_control_id','76')
                    ->where('created_at',$ts)->pluck('value');
                $vital_sign_detail->Height = active_record::where('patient_id', $id)
                    ->where('navigation_id','8')
                    ->where('doc_control_id','77')
                    ->where('created_at',$ts)->pluck('value');
                $vital_sign_detail->Pain = active_record::where('patient_id', $id)
                    ->where('navigation_id','8')
                    ->where('doc_control_id','23')
                    ->where('created_at',$ts)->pluck('value');
                $vital_sign_detail->Oxygen_Saturation = active_record::where('patient_id', $id)
                    ->where('navigation_id','8')
                    ->where('doc_control_id','69')
                    ->where('created_at',$ts)->pluck('value');
                $vital_sign_detail->Comment = active_record::where('patient_id', $id)
                    ->where('navigation_id','8')
                    ->where('doc_control_id','24')
                    ->where('created_at',$ts)->pluck('value');
                array_push($vital_sign_details, $vital_sign_detail);
            }
            //Extracting vital signs for header
            $vital_signs_header = $this->get_vital_signs_header($id);

            //Extracting disposition to enable or disable the submit button
            $disposition = active_record::where('patient_id', $id)
                ->where('navigation_id', '34')->get();
            $user_id = Auth::user()->id;
            $status = users_patient::where('patient_id',$id)->where('user_id',$user_id)->first();
               if($status) {
                    $status_id = $status->patient_record_status_id;
            return view('patient/vital_signs', compact('status_id','vital_signs_header','patient','navs','vital_sign_details','disposition'));
                }
                else
                {
                    $error_message= "Student can only view their created patients. You are not authorized to view this page.";
                    return view('errors/error',compact('error_message'));
                }
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }

   //PE methods
    public function get_physical_exams($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {
            //Student cannot view deleted patients
            $patient = patient::where('patient_id', $id)->first();
            if($patient->archived)
            {
                $error_message = "You cannot view deleted patient.";
                return view('errors/error', compact('error_message'));
            }
            //Student cannot edit submitted patients
            elseif ($patient->completed_flag) {
                $error_message = "You cannot edit submitted patient. ";
                return view('errors/error', compact('error_message'));
            }
            else {
            //Now getting actual selected values
            $gastrointestinal_symptoms= $this->get_physical_exams_gastrointestinal_symptoms($id);
            $gastrointestinal_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','30')->where('doc_control_id','64')->pluck('value');

            $psychological_symptoms= $this->get_physical_exams_psychological_symptoms($id);
            $psychological_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','29')->where('doc_control_id','62')->pluck('value');

            $neurological_symptoms= $this->get_physical_exams_neurological_symptoms($id);
            $neurological_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','28')->where('doc_control_id','60')->pluck('value');

            $integumentary_symptoms= $this->get_physical_exams_integumentary_symptoms($id);
            $integumentary_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','27')->where('doc_control_id','58')->pluck('value');

            $musculoskeletal_symptoms= $this->get_physical_exams_musculoskeletal_symptoms($id);
            $musculoskeletal_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','26')->where('doc_control_id','56')->pluck('value');

            $cardiovascular_symptoms= $this->get_physical_exams_cardiovascular_symptoms($id);
            $cardiovascular_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','25')->where('doc_control_id','54')->pluck('value');

            $respiratory_symptoms= $this->get_physical_exams_respiratory_symptoms($id);
            $respiratory_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','24')->where('doc_control_id','52')->pluck('value');

            $eyes_symptoms= $this->get_physical_exams_eyes_symptoms($id);
            $eyes_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','23')->where('doc_control_id','50')->pluck('value');

            $HENT_symptoms= $this->get_physical_exams_HENT_symptoms($id);
            $HENT_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','22')->where('doc_control_id','48')->pluck('value');

            $constitutional_symptoms= $this->get_physical_exams_constitutional_symptoms($id);
            $constitutional_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','21')->where('doc_control_id','46')->pluck('value');

            //Fetching all navs associated with this patient's module
            $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');

            $navs = array();
            //Now get nav names
            foreach ($navIds as $nav_id) {
                $nav = navigation::where('navigation_id', $nav_id)->get();
                array_push($navs, $nav);
            }

            //Converting object to array
            $navIds = str_replace(['['], '', $navIds);
            $navIds = str_replace(['"'], '', $navIds);
            $navIds = str_replace(['"'], '', $navIds);
            $navIds = str_replace([']'], '', $navIds);

            $navIds = explode(",", $navIds);

            //Extracting vital signs for header
            $vital_signs_header = $this->get_vital_signs_header($id);

            //Extracting disposition to enable or disable the submit button
            $disposition = active_record::where('patient_id', $id)
                ->where('navigation_id', '34')->get();
            $user_id = Auth::user()->id;
            $status = users_patient::where('patient_id',$id)->where('user_id',$user_id)->first();
                if($status) {
                    $status_id = $status->patient_record_status_id;
                    return view('patient/physical_exams', compact ('status_id','navIds',
                        'vital_signs_header','patient','navs','disposition','neurological_symptoms',
                        'neurological_comment','psychological_symptoms','psychological_comment',
                        'integumentary_symptoms','integumentary_comment','musculoskeletal_symptoms',
                        'musculoskeletal_comment','cardiovascular_symptoms','cardiovascular_comment',
                        'respiratory_symptoms','respiratory_comment','eyes_symptoms','eyes_comment','HENT_symptoms',
                        'HENT_comment','constitutional_symptoms','constitutional_comment', 'gastrointestinal_symptoms','gastrointestinal_comment' ));
                }
                else
                {
                    $error_message= "Student can only view their created patients. You are not authorized to view this page.";
                    return view('errors/error',compact('error_message'));
                }
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }

    public function get_physical_exams_gastrointestinal_symptoms($id)
    {
        $gastrointestinal_all_symptoms = array();
        $gastrointestinal_all_lookup_values = doc_lookup_value::where('doc_control_id',63)->pluck('lookup_value_id');

        foreach ($gastrointestinal_all_lookup_values as $gastrointestinal_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$gastrointestinal_all_lookup_value)->pluck('lookup_value');
            array_push($gastrointestinal_all_symptoms,$symptom );
        }

        $gastrointestinal_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','30')->where('doc_control_id','63')->pluck('value');

        //Converting object to array
        $gastrointestinal_saved_symptoms = str_replace(['['], '', $gastrointestinal_saved_symptoms);
        $gastrointestinal_saved_symptoms = str_replace(['"'], '', $gastrointestinal_saved_symptoms);
        $gastrointestinal_saved_symptoms = str_replace(['"'], '', $gastrointestinal_saved_symptoms);
        $gastrointestinal_saved_symptoms = str_replace([']'], '', $gastrointestinal_saved_symptoms);
        $gastrointestinal_saved_symptoms = explode(",", $gastrointestinal_saved_symptoms);

        $gastrointestinal_symptoms = Array();

        foreach($gastrointestinal_all_symptoms as $symptom)
        {
            $gastrointestinal_symptom = new symptom();
            $gastrointestinal_symptom->value = $symptom[0];
            if(in_array($symptom[0], $gastrointestinal_saved_symptoms))
            {
                $gastrointestinal_symptom->is_saved = true;
            }
            else
            {
                $gastrointestinal_symptom->is_saved = false;
            }
            array_push($gastrointestinal_symptoms, $gastrointestinal_symptom);
        }
        return $gastrointestinal_symptoms;

    }

    public function get_physical_exams_psychological_symptoms($id)
    {
        $psychological_all_symptoms = array();
        $psychological_all_lookup_values = doc_lookup_value::where('doc_control_id',61)->pluck('lookup_value_id');

        foreach ($psychological_all_lookup_values as $psychological_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$psychological_all_lookup_value)->pluck('lookup_value');
            array_push($psychological_all_symptoms,$symptom );
        }

        $psychological_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','29')->where('doc_control_id','61')->pluck('value');

        //Converting object to array
        $psychological_saved_symptoms = str_replace(['['], '', $psychological_saved_symptoms);
        $psychological_saved_symptoms = str_replace(['"'], '', $psychological_saved_symptoms);
        $psychological_saved_symptoms = str_replace(['"'], '', $psychological_saved_symptoms);
        $psychological_saved_symptoms = str_replace([']'], '', $psychological_saved_symptoms);
        $psychological_saved_symptoms = explode(",", $psychological_saved_symptoms);

        $psychological_symptoms = Array();

        foreach($psychological_all_symptoms as $symptom)
        {
            $psychological_symptom = new symptom();
            $psychological_symptom->value = $symptom[0];
            if(in_array($symptom[0], $psychological_saved_symptoms))
            {
                $psychological_symptom->is_saved = true;
            }
            else
            {
                $psychological_symptom->is_saved = false;
            }
            array_push($psychological_symptoms, $psychological_symptom);
        }
        return $psychological_symptoms;

    }
    public function get_physical_exams_neurological_symptoms($id)
    {
        $neurological_all_symptoms = array();
        $neurological_all_lookup_values = doc_lookup_value::where('doc_control_id',59)->pluck('lookup_value_id');

        foreach ($neurological_all_lookup_values as $neurological_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$neurological_all_lookup_value)->pluck('lookup_value');
            array_push($neurological_all_symptoms,$symptom );
        }

        $neurological_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','28')->where('doc_control_id','59')->pluck('value');

        //Converting object to array
        $neurological_saved_symptoms = str_replace(['['], '', $neurological_saved_symptoms);
        $neurological_saved_symptoms = str_replace(['"'], '', $neurological_saved_symptoms);
        $neurological_saved_symptoms = str_replace(['"'], '', $neurological_saved_symptoms);
        $neurological_saved_symptoms = str_replace([']'], '', $neurological_saved_symptoms);
        $neurological_saved_symptoms = explode(",", $neurological_saved_symptoms);

        $neurological_symptoms = Array();

        foreach($neurological_all_symptoms as $symptom)
        {
            $neurological_symptom = new symptom();
            $neurological_symptom->value = $symptom[0];
            if(in_array($symptom[0], $neurological_saved_symptoms))
            {
                $neurological_symptom->is_saved = true;
            }
            else
            {
                $neurological_symptom->is_saved = false;
            }
            array_push($neurological_symptoms, $neurological_symptom);
        }
        return $neurological_symptoms;

    }
    public function get_physical_exams_integumentary_symptoms($id)
    {
        $integumentary_all_symptoms = array();
        $integumentary_all_lookup_values = doc_lookup_value::where('doc_control_id',57)->pluck('lookup_value_id');

        foreach ($integumentary_all_lookup_values as $integumentary_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$integumentary_all_lookup_value)->pluck('lookup_value');
            array_push($integumentary_all_symptoms,$symptom );
        }

        $integumentary_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','27')->where('doc_control_id','57')->pluck('value');

        //Converting object to array
        $integumentary_saved_symptoms = str_replace(['['], '', $integumentary_saved_symptoms);
        $integumentary_saved_symptoms = str_replace(['"'], '', $integumentary_saved_symptoms);
        $integumentary_saved_symptoms = str_replace(['"'], '', $integumentary_saved_symptoms);
        $integumentary_saved_symptoms = str_replace([']'], '', $integumentary_saved_symptoms);
        $integumentary_saved_symptoms = explode(",", $integumentary_saved_symptoms);

        $integumentary_symptoms = Array();

        foreach($integumentary_all_symptoms as $symptom)
        {
            $integumentary_symptom = new symptom();
            $integumentary_symptom->value = $symptom[0];
            if(in_array($symptom[0], $integumentary_saved_symptoms))
            {
                $integumentary_symptom->is_saved = true;
            }
            else
            {
                $integumentary_symptom->is_saved = false;
            }
            array_push($integumentary_symptoms, $integumentary_symptom);
        }
        return $integumentary_symptoms;

    }
    public function get_physical_exams_musculoskeletal_symptoms($id)
    {
        $musculoskeletal_all_symptoms = array();
        $musculoskeletal_all_lookup_values = doc_lookup_value::where('doc_control_id',55)->pluck('lookup_value_id');

        foreach ($musculoskeletal_all_lookup_values as $musculoskeletal_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$musculoskeletal_all_lookup_value)->pluck('lookup_value');
            array_push($musculoskeletal_all_symptoms,$symptom );
        }

        $musculoskeletal_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','26')->where('doc_control_id','55')->pluck('value');

        //Converting object to array
        $musculoskeletal_saved_symptoms = str_replace(['['], '', $musculoskeletal_saved_symptoms);
        $musculoskeletal_saved_symptoms = str_replace(['"'], '', $musculoskeletal_saved_symptoms);
        $musculoskeletal_saved_symptoms = str_replace(['"'], '', $musculoskeletal_saved_symptoms);
        $musculoskeletal_saved_symptoms = str_replace([']'], '', $musculoskeletal_saved_symptoms);
        $musculoskeletal_saved_symptoms = explode(",", $musculoskeletal_saved_symptoms);

        $musculoskeletal_symptoms = Array();

        foreach($musculoskeletal_all_symptoms as $symptom)
        {
            $musculoskeletal_symptom = new symptom();
            $musculoskeletal_symptom->value = $symptom[0];
            if(in_array($symptom[0], $musculoskeletal_saved_symptoms))
            {
                $musculoskeletal_symptom->is_saved = true;
            }
            else
            {
                $musculoskeletal_symptom->is_saved = false;
            }
            array_push($musculoskeletal_symptoms, $musculoskeletal_symptom);
        }
        return $musculoskeletal_symptoms;

    }
    public function get_physical_exams_cardiovascular_symptoms($id)
    {
        $cardiovascular_all_symptoms = array();
        $cardiovascular_all_lookup_values = doc_lookup_value::where('doc_control_id',53)->pluck('lookup_value_id');

        foreach ($cardiovascular_all_lookup_values as $cardiovascular_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$cardiovascular_all_lookup_value)->pluck('lookup_value');
            array_push($cardiovascular_all_symptoms,$symptom );
        }

        $cardiovascular_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','25')->where('doc_control_id','53')->pluck('value');

        //Converting object to array
        $cardiovascular_saved_symptoms = str_replace(['['], '', $cardiovascular_saved_symptoms);
        $cardiovascular_saved_symptoms = str_replace(['"'], '', $cardiovascular_saved_symptoms);
        $cardiovascular_saved_symptoms = str_replace(['"'], '', $cardiovascular_saved_symptoms);
        $cardiovascular_saved_symptoms = str_replace([']'], '', $cardiovascular_saved_symptoms);
        $cardiovascular_saved_symptoms = explode(",", $cardiovascular_saved_symptoms);

        $cardiovascular_symptoms = Array();

        foreach($cardiovascular_all_symptoms as $symptom)
        {
            $cardiovascular_symptom = new symptom();
            $cardiovascular_symptom->value = $symptom[0];
            if(in_array($symptom[0], $cardiovascular_saved_symptoms))
            {
                $cardiovascular_symptom->is_saved = true;
            }
            else
            {
                $cardiovascular_symptom->is_saved = false;
            }
            array_push($cardiovascular_symptoms, $cardiovascular_symptom);
        }
        return $cardiovascular_symptoms;

    }
    public function get_physical_exams_respiratory_symptoms($id)
    {
        $respiratory_all_symptoms = array();
        $respiratory_all_lookup_values = doc_lookup_value::where('doc_control_id',51)->pluck('lookup_value_id');

        foreach ($respiratory_all_lookup_values as $respiratory_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$respiratory_all_lookup_value)->pluck('lookup_value');
            array_push($respiratory_all_symptoms,$symptom );
        }

        $respiratory_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','24')->where('doc_control_id','51')->pluck('value');

        //Converting object to array
        $respiratory_saved_symptoms = str_replace(['['], '', $respiratory_saved_symptoms);
        $respiratory_saved_symptoms = str_replace(['"'], '', $respiratory_saved_symptoms);
        $respiratory_saved_symptoms = str_replace(['"'], '', $respiratory_saved_symptoms);
        $respiratory_saved_symptoms = str_replace([']'], '', $respiratory_saved_symptoms);
        $respiratory_saved_symptoms = explode(",", $respiratory_saved_symptoms);

        $respiratory_symptoms = Array();

        foreach($respiratory_all_symptoms as $symptom)
        {
            $respiratory_symptom = new symptom();
            $respiratory_symptom->value = $symptom[0];
            if(in_array($symptom[0], $respiratory_saved_symptoms))
            {
                $respiratory_symptom->is_saved = true;
            }
            else
            {
                $respiratory_symptom->is_saved = false;
            }
            array_push($respiratory_symptoms, $respiratory_symptom);
        }
        return $respiratory_symptoms;

    }
    public function get_physical_exams_eyes_symptoms($id)
    {
        $eyes_all_symptoms = array();
        $eyes_all_lookup_values = doc_lookup_value::where('doc_control_id',49)->pluck('lookup_value_id');

        foreach ($eyes_all_lookup_values as $eyes_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$eyes_all_lookup_value)->pluck('lookup_value');
            array_push($eyes_all_symptoms,$symptom );
        }

        $eyes_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','23')->where('doc_control_id','49')->pluck('value');

        //Converting object to array
        $eyes_saved_symptoms = str_replace(['['], '', $eyes_saved_symptoms);
        $eyes_saved_symptoms = str_replace(['"'], '', $eyes_saved_symptoms);
        $eyes_saved_symptoms = str_replace(['"'], '', $eyes_saved_symptoms);
        $eyes_saved_symptoms = str_replace([']'], '', $eyes_saved_symptoms);
        $eyes_saved_symptoms = explode(",", $eyes_saved_symptoms);

        $eyes_symptoms = Array();

        foreach($eyes_all_symptoms as $symptom)
        {
            $eyes_symptom = new symptom();
            $eyes_symptom->value = $symptom[0];
            if(in_array($symptom[0], $eyes_saved_symptoms))
            {
                $eyes_symptom->is_saved = true;
            }
            else
            {
                $eyes_symptom->is_saved = false;
            }
            array_push($eyes_symptoms, $eyes_symptom);
        }
        return $eyes_symptoms;

    }
    public function get_physical_exams_HENT_symptoms($id)
    {
        $HENT_all_symptoms = array();
        $HENT_all_lookup_values = doc_lookup_value::where('doc_control_id',47)->pluck('lookup_value_id');

        foreach ($HENT_all_lookup_values as $HENT_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$HENT_all_lookup_value)->pluck('lookup_value');
            array_push($HENT_all_symptoms,$symptom );
        }

        $HENT_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','22')->where('doc_control_id','47')->pluck('value');

        //Converting object to array
        $HENT_saved_symptoms = str_replace(['['], '', $HENT_saved_symptoms);
        $HENT_saved_symptoms = str_replace(['"'], '', $HENT_saved_symptoms);
        $HENT_saved_symptoms = str_replace(['"'], '', $HENT_saved_symptoms);
        $HENT_saved_symptoms = str_replace([']'], '', $HENT_saved_symptoms);
        $HENT_saved_symptoms = explode(",", $HENT_saved_symptoms);

        $HENT_symptoms = Array();

        foreach($HENT_all_symptoms as $symptom)
        {
            $HENT_symptom = new symptom();
            $HENT_symptom->value = $symptom[0];
            if(in_array($symptom[0], $HENT_saved_symptoms))
            {
                $HENT_symptom->is_saved = true;
            }
            else
            {
                $HENT_symptom->is_saved = false;
            }
            array_push($HENT_symptoms, $HENT_symptom);
        }
        return $HENT_symptoms;

    }
    public function get_physical_exams_constitutional_symptoms($id)
    {
        $constitutional_all_symptoms = array();
        $constitutional_all_lookup_values = doc_lookup_value::where('doc_control_id',45)->pluck('lookup_value_id');

        foreach ($constitutional_all_lookup_values as $constitutional_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$constitutional_all_lookup_value)->pluck('lookup_value');
            array_push($constitutional_all_symptoms,$symptom );
        }

        $constitutional_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','21')->where('doc_control_id','45')->pluck('value');

        //Converting object to array
        $constitutional_saved_symptoms = str_replace(['['], '', $constitutional_saved_symptoms);
        $constitutional_saved_symptoms = str_replace(['"'], '', $constitutional_saved_symptoms);
        $constitutional_saved_symptoms = str_replace(['"'], '', $constitutional_saved_symptoms);
        $constitutional_saved_symptoms = str_replace([']'], '', $constitutional_saved_symptoms);
        $constitutional_saved_symptoms = explode(",", $constitutional_saved_symptoms);

        $constitutional_symptoms = Array();

        foreach($constitutional_all_symptoms as $symptom)
        {
            $constitutional_symptom = new symptom();
            $constitutional_symptom->value = $symptom[0];
            if(in_array($symptom[0], $constitutional_saved_symptoms))
            {
                $constitutional_symptom->is_saved = true;
            }
            else
            {
                $constitutional_symptom->is_saved = false;
            }
            array_push($constitutional_symptoms, $constitutional_symptom);
        }
        return $constitutional_symptoms;

    }

    //ROS methods
    public function get_ROS($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {
            //Student cannot view deleted patients
            $patient = patient::where('patient_id', $id)->first();
            if($patient->archived)
            {
                $error_message = "You cannot view deleted patient.";
                return view('errors/error', compact('error_message'));
            }
            //Student cannot edit submitted patients
            elseif ($patient->completed_flag) {
                $error_message = "You cannot edit submitted patient. ";
                return view('errors/error', compact('error_message'));
            }
            else {

                //Now getting actual selected values
            $ros_constitutional_symptoms= $this->get_ROS_costitutional_symptoms($id);
            $ros_constitutional_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','10')->where('doc_control_id','26')->pluck('value');

            $ros_hent_symptoms= $this->get_ROS_hent_symptoms($id);
            $ros_hent_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','11')->where('doc_control_id','28')->pluck('value');

            $ros_eyes_symptoms= $this->get_ROS_eyes_symptoms($id);
            $ros_eyes_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','12')->where('doc_control_id','30')->pluck('value');

            $ros_respiratory_symptoms= $this->get_ROS_respiratory_symptoms($id);
            $ros_respiratory_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','13')->where('doc_control_id','32')->pluck('value');

            $ros_cardiovascular_symptoms= $this->get_ROS_cardiovascular_symptoms($id);
            $ros_cardiovascular_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','14')->where('doc_control_id','34')->pluck('value');

           $ros_musculoskeletal_symptoms= $this->get_ROS_musculoskeletal_symptoms($id);
           $ros_musculoskeletal_comment = active_record::where('patient_id', $id)
               ->where('navigation_id','15')->where('doc_control_id','36')->pluck('value');

           $ros_integumentary_symptoms= $this->get_ROS_integumentary_symptoms($id);
           $ros_integumentary_comment = active_record::where('patient_id', $id)
               ->where('navigation_id','16')->where('doc_control_id','38')->pluck('value');

           $ros_neurological_symptoms= $this->get_ROS_neurological_symptoms($id);
           $ros_neurological_comment = active_record::where('patient_id', $id)
               ->where('navigation_id','17')->where('doc_control_id','40')->pluck('value');

           $ros_psychological_symptoms= $this->get_ROS_psychological_symptoms($id);
           $ros_psychological_comment = active_record::where('patient_id', $id)
               ->where('navigation_id','18')->where('doc_control_id','42')->pluck('value');

            $ros_gastrointestinal_symptoms= $this->get_ROS_gastrointestinal_symptoms($id);
           $ros_gastrointestinal_comment = active_record::where('patient_id', $id)
               ->where('navigation_id','19')->where('doc_control_id','44')->pluck('value');

            //Fetching all navs associated with this patient's module
            $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');

            $navs = array();
            //Now get nav names
            foreach ($navIds as $nav_id) {
                $nav = navigation::where('navigation_id', $nav_id)->get();
                array_push($navs, $nav);
            }

            //Converting object to array
            $navIds = str_replace(['['], '', $navIds);
            $navIds = str_replace(['"'], '', $navIds);
            $navIds = str_replace(['"'], '', $navIds);
            $navIds = str_replace([']'], '', $navIds);

            $navIds = explode(",", $navIds);

            //Extracting vital signs for header
            $vital_signs_header = $this->get_vital_signs_header($id);

            //Extracting disposition to enable or disable the submit button
            $disposition = active_record::where('patient_id', $id)
                ->where('navigation_id', '34')->get();
            $user_id = Auth::user()->id;
            $status = users_patient::where('patient_id',$id)->where('user_id',$user_id)->first();
                 if($status) {
                    $status_id = $status->patient_record_status_id;
                    return view('patient/review_of_system', compact ('navIds','vital_signs_header','patient','navs','disposition',
                        'ros_constitutional_symptoms','ros_constitutional_comment', 'ros_hent_symptoms','ros_hent_comment',
                        'ros_eyes_symptoms','ros_eyes_comment', 'ros_respiratory_symptoms','ros_respiratory_comment',
                        'ros_cardiovascular_symptoms','ros_cardiovascular_comment', 'ros_musculoskeletal_symptoms','ros_musculoskeletal_comment',
                        'ros_integumentary_symptoms','ros_integumentary_comment', 'ros_neurological_symptoms','ros_neurological_comment',
                        'ros_psychological_symptoms','ros_psychological_comment', 'ros_gastrointestinal_symptoms','ros_gastrointestinal_comment', 'status_id'));
                }
                else
                {
                    $error_message= "Student can only view their created patients. You are not authorized to view this page.";
                    return view('errors/error',compact('error_message'));
                }
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }
    public function get_ROS_costitutional_symptoms($id)
    {
        $ros_constitutional_all_symptoms = array();
        $ros_constitutional_all_lookup_values = doc_lookup_value::where('doc_control_id',25)->pluck('lookup_value_id');

        foreach ($ros_constitutional_all_lookup_values as $ros_constitutional_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$ros_constitutional_all_lookup_value)->pluck('lookup_value');
            array_push($ros_constitutional_all_symptoms,$symptom );
        }

        $ros_constitutional_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','10')->where('doc_control_id','25')->pluck('value');

        //Converting object to array
        $ros_constitutional_saved_symptoms = str_replace(['['], '', $ros_constitutional_saved_symptoms);
        $ros_constitutional_saved_symptoms = str_replace(['"'], '', $ros_constitutional_saved_symptoms);
        $ros_constitutional_saved_symptoms = str_replace(['"'], '', $ros_constitutional_saved_symptoms);
        $ros_constitutional_saved_symptoms = str_replace([']'], '', $ros_constitutional_saved_symptoms);
        $ros_constitutional_saved_symptoms = explode(",", $ros_constitutional_saved_symptoms);

        $ros_constitutional_symptoms = Array();

        foreach($ros_constitutional_all_symptoms as $symptom)
        {
            $ros_constitutional_symptom = new symptom();
            $ros_constitutional_symptom->value = $symptom[0];
            if(in_array($symptom[0], $ros_constitutional_saved_symptoms))
            {
                $ros_constitutional_symptom->is_saved = true;
            }
            else
            {
                $ros_constitutional_symptom->is_saved = false;
            }
            array_push($ros_constitutional_symptoms, $ros_constitutional_symptom);
        }
        return $ros_constitutional_symptoms;

    }
    public function get_ROS_hent_symptoms($id)
    {
        $ros_hent_all_symptoms = array();
        $ros_hent_all_lookup_values = doc_lookup_value::where('doc_control_id',27)->pluck('lookup_value_id');

        foreach ($ros_hent_all_lookup_values as $ros_hent_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$ros_hent_all_lookup_value)->pluck('lookup_value');
            array_push($ros_hent_all_symptoms,$symptom );
        }

        $ros_hent_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','11')->where('doc_control_id','27')->pluck('value');

        //Converting object to array
        $ros_hent_saved_symptoms = str_replace(['['], '', $ros_hent_saved_symptoms);
        $ros_hent_saved_symptoms = str_replace(['"'], '', $ros_hent_saved_symptoms);
        $ros_hent_saved_symptoms = str_replace(['"'], '', $ros_hent_saved_symptoms);
        $ros_hent_saved_symptoms = str_replace([']'], '', $ros_hent_saved_symptoms);
        $ros_hent_saved_symptoms = explode(",", $ros_hent_saved_symptoms);

        $ros_hent_symptoms = Array();

        foreach($ros_hent_all_symptoms as $symptom)
        {
            $ros_hent_symptom = new symptom();
            $ros_hent_symptom->value = $symptom[0];
            if(in_array($symptom[0], $ros_hent_saved_symptoms))
            {
                $ros_hent_symptom->is_saved = true;
            }
            else
            {
                $ros_hent_symptom->is_saved = false;
            }
            array_push($ros_hent_symptoms, $ros_hent_symptom);
        }
        return $ros_hent_symptoms;

    }
    public function get_ROS_eyes_symptoms($id)
    {
        $ros_eyes_all_symptoms = array();
        $ros_eyes_all_lookup_values = doc_lookup_value::where('doc_control_id',29)->pluck('lookup_value_id');

        foreach ($ros_eyes_all_lookup_values as $ros_eyes_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$ros_eyes_all_lookup_value)->pluck('lookup_value');
            array_push($ros_eyes_all_symptoms,$symptom );
        }

        $ros_eyes_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','12')->where('doc_control_id','29')->pluck('value');

        //Converting object to array
        $ros_eyes_saved_symptoms = str_replace(['['], '', $ros_eyes_saved_symptoms);
        $ros_eyes_saved_symptoms = str_replace(['"'], '', $ros_eyes_saved_symptoms);
        $ros_eyes_saved_symptoms = str_replace(['"'], '', $ros_eyes_saved_symptoms);
        $ros_eyes_saved_symptoms = str_replace([']'], '', $ros_eyes_saved_symptoms);
        $ros_eyes_saved_symptoms = explode(",", $ros_eyes_saved_symptoms);

        $ros_eyes_symptoms = Array();

        foreach($ros_eyes_all_symptoms as $symptom)
        {
            $ros_eyes_symptom = new symptom();
            $ros_eyes_symptom->value = $symptom[0];
            if(in_array($symptom[0], $ros_eyes_saved_symptoms))
            {
                $ros_eyes_symptom->is_saved = true;
            }
            else
            {
                $ros_eyes_symptom->is_saved = false;
            }
            array_push($ros_eyes_symptoms, $ros_eyes_symptom);
        }
        return $ros_eyes_symptoms;
    }
    public function get_ROS_respiratory_symptoms($id)
    {
        $ros_respiratory_all_symptoms = array();
        $ros_respiratory_all_lookup_values = doc_lookup_value::where('doc_control_id',31)->pluck('lookup_value_id');

        foreach ($ros_respiratory_all_lookup_values as $ros_respiratory_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$ros_respiratory_all_lookup_value)->pluck('lookup_value');
            array_push($ros_respiratory_all_symptoms,$symptom );
        }

        $ros_respiratory_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','13')->where('doc_control_id','31')->pluck('value');

        //Converting object to array
        $ros_respiratory_saved_symptoms = str_replace(['['], '', $ros_respiratory_saved_symptoms);
        $ros_respiratory_saved_symptoms = str_replace(['"'], '', $ros_respiratory_saved_symptoms);
        $ros_respiratory_saved_symptoms = str_replace(['"'], '', $ros_respiratory_saved_symptoms);
        $ros_respiratory_saved_symptoms = str_replace([']'], '', $ros_respiratory_saved_symptoms);
        $ros_respiratory_saved_symptoms = explode(",", $ros_respiratory_saved_symptoms);

        $ros_respiratory_symptoms = Array();

        foreach($ros_respiratory_all_symptoms as $symptom)
        {
            $ros_respiratory_symptom = new symptom();
            $ros_respiratory_symptom->value = $symptom[0];
            if(in_array($symptom[0], $ros_respiratory_saved_symptoms))
            {
                $ros_respiratory_symptom->is_saved = true;
            }
            else
            {
                $ros_respiratory_symptom->is_saved = false;
            }
            array_push($ros_respiratory_symptoms, $ros_respiratory_symptom);
        }
        return $ros_respiratory_symptoms;
    }
    public function get_ROS_cardiovascular_symptoms($id)
    {
        $ros_cardiovascular_all_symptoms = array();
        $ros_cardiovascular_all_lookup_values = doc_lookup_value::where('doc_control_id',33)->pluck('lookup_value_id');

        foreach ($ros_cardiovascular_all_lookup_values as $ros_cardiovascular_all_lookup_value)
        {
            $symptom = lookup_value::where('lookup_value_id',$ros_cardiovascular_all_lookup_value)->pluck('lookup_value');
            array_push($ros_cardiovascular_all_symptoms,$symptom );
        }

        $ros_cardiovascular_saved_symptoms = active_record::where('patient_id', $id)
            ->where('navigation_id','14')->where('doc_control_id','33')->pluck('value');

        //Converting object to array
        $ros_cardiovascular_saved_symptoms = str_replace(['['], '', $ros_cardiovascular_saved_symptoms);
        $ros_cardiovascular_saved_symptoms = str_replace(['"'], '', $ros_cardiovascular_saved_symptoms);
        $ros_cardiovascular_saved_symptoms = str_replace(['"'], '', $ros_cardiovascular_saved_symptoms);
        $ros_cardiovascular_saved_symptoms = str_replace([']'], '', $ros_cardiovascular_saved_symptoms);
        $ros_cardiovascular_saved_symptoms = explode(",", $ros_cardiovascular_saved_symptoms);

        $ros_cardiovascular_symptoms = Array();

        foreach($ros_cardiovascular_all_symptoms as $symptom)
        {
            $ros_cardiovascular_symptom = new symptom();
            $ros_cardiovascular_symptom->value = $symptom[0];
            if(in_array($symptom[0], $ros_cardiovascular_saved_symptoms))
            {
                $ros_cardiovascular_symptom->is_saved = true;
            }
            else
            {
                $ros_cardiovascular_symptom->is_saved = false;
            }
            array_push($ros_cardiovascular_symptoms, $ros_cardiovascular_symptom);
        }
        return $ros_cardiovascular_symptoms;
}
    public function get_ROS_musculoskeletal_symptoms($id)
{
    $ros_musculoskeletal_all_symptoms = array();
    $ros_musculoskeletal_all_lookup_values = doc_lookup_value::where('doc_control_id',35)->pluck('lookup_value_id');

    foreach ($ros_musculoskeletal_all_lookup_values as $ros_musculoskeletal_all_lookup_value)
    {
        $symptom = lookup_value::where('lookup_value_id',$ros_musculoskeletal_all_lookup_value)->pluck('lookup_value');
        array_push($ros_musculoskeletal_all_symptoms,$symptom );
    }

    $ros_musculoskeletal_saved_symptoms = active_record::where('patient_id', $id)
        ->where('navigation_id','15')->where('doc_control_id','35')->pluck('value');

    //Converting object to array
    $ros_musculoskeletal_saved_symptoms = str_replace(['['], '', $ros_musculoskeletal_saved_symptoms);
    $ros_musculoskeletal_saved_symptoms = str_replace(['"'], '', $ros_musculoskeletal_saved_symptoms);
    $ros_musculoskeletal_saved_symptoms = str_replace(['"'], '', $ros_musculoskeletal_saved_symptoms);
    $ros_musculoskeletal_saved_symptoms = str_replace([']'], '', $ros_musculoskeletal_saved_symptoms);
    $ros_musculoskeletal_saved_symptoms = explode(",", $ros_musculoskeletal_saved_symptoms);

    $ros_musculoskeletal_symptoms = Array();

    foreach($ros_musculoskeletal_all_symptoms as $symptom)
    {
        $ros_musculoskeletal_symptom = new symptom();
        $ros_musculoskeletal_symptom->value = $symptom[0];
        if(in_array($symptom[0], $ros_musculoskeletal_saved_symptoms))
        {
            $ros_musculoskeletal_symptom->is_saved = true;
        }
        else
        {
            $ros_musculoskeletal_symptom->is_saved = false;
        }
        array_push($ros_musculoskeletal_symptoms, $ros_musculoskeletal_symptom);
    }
    return $ros_musculoskeletal_symptoms;
}
    public function get_ROS_integumentary_symptoms($id)
{
    $ros_integumentary_all_symptoms = array();
    $ros_integumentary_all_lookup_values = doc_lookup_value::where('doc_control_id',37)->pluck('lookup_value_id');

    foreach ($ros_integumentary_all_lookup_values as $ros_integumentary_all_lookup_value)
    {
        $symptom = lookup_value::where('lookup_value_id',$ros_integumentary_all_lookup_value)->pluck('lookup_value');
        array_push($ros_integumentary_all_symptoms,$symptom );
    }

    $ros_integumentary_saved_symptoms = active_record::where('patient_id', $id)
        ->where('navigation_id','16')->where('doc_control_id','37')->pluck('value');

    //Converting object to array
    $ros_integumentary_saved_symptoms = str_replace(['['], '', $ros_integumentary_saved_symptoms);
    $ros_integumentary_saved_symptoms = str_replace(['"'], '', $ros_integumentary_saved_symptoms);
    $ros_integumentary_saved_symptoms = str_replace(['"'], '', $ros_integumentary_saved_symptoms);
    $ros_integumentary_saved_symptoms = str_replace([']'], '', $ros_integumentary_saved_symptoms);
    $ros_integumentary_saved_symptoms = explode(",", $ros_integumentary_saved_symptoms);

    $ros_integumentary_symptoms = Array();

    foreach($ros_integumentary_all_symptoms as $symptom)
    {
        $ros_integumentary_symptom = new symptom();
        $ros_integumentary_symptom->value = $symptom[0];
        if(in_array($symptom[0], $ros_integumentary_saved_symptoms))
        {
            $ros_integumentary_symptom->is_saved = true;
        }
        else
        {
            $ros_integumentary_symptom->is_saved = false;
        }
        array_push($ros_integumentary_symptoms, $ros_integumentary_symptom);
    }
    return $ros_integumentary_symptoms;
}
    public function get_ROS_neurological_symptoms($id)
{
    $ros_neurological_all_symptoms = array();
    $ros_neurological_all_lookup_values = doc_lookup_value::where('doc_control_id',39)->pluck('lookup_value_id');

    foreach ($ros_neurological_all_lookup_values as $ros_neurological_all_lookup_value)
    {
        $symptom = lookup_value::where('lookup_value_id',$ros_neurological_all_lookup_value)->pluck('lookup_value');
        array_push($ros_neurological_all_symptoms,$symptom );
    }

    $ros_neurological_saved_symptoms = active_record::where('patient_id', $id)
        ->where('navigation_id','17')->where('doc_control_id','39')->pluck('value');

    //Converting object to array
    $ros_neurological_saved_symptoms = str_replace(['['], '', $ros_neurological_saved_symptoms);
    $ros_neurological_saved_symptoms = str_replace(['"'], '', $ros_neurological_saved_symptoms);
    $ros_neurological_saved_symptoms = str_replace(['"'], '', $ros_neurological_saved_symptoms);
    $ros_neurological_saved_symptoms = str_replace([']'], '', $ros_neurological_saved_symptoms);
    $ros_neurological_saved_symptoms = explode(",", $ros_neurological_saved_symptoms);

    $ros_neurological_symptoms = Array();

    foreach($ros_neurological_all_symptoms as $symptom)
    {
        $ros_neurological_symptom = new symptom();
        $ros_neurological_symptom->value = $symptom[0];
        if(in_array($symptom[0], $ros_neurological_saved_symptoms))
        {
            $ros_neurological_symptom->is_saved = true;
        }
        else
        {
            $ros_neurological_symptom->is_saved = false;
        }
        array_push($ros_neurological_symptoms, $ros_neurological_symptom);
    }
    return $ros_neurological_symptoms;
}
    public function get_ROS_psychological_symptoms($id)
{
    $ros_psychological_all_symptoms = array();
    $ros_psychological_all_lookup_values = doc_lookup_value::where('doc_control_id',41)->pluck('lookup_value_id');

    foreach ($ros_psychological_all_lookup_values as $ros_psychological_all_lookup_value)
    {
        $symptom = lookup_value::where('lookup_value_id',$ros_psychological_all_lookup_value)->pluck('lookup_value');
        array_push($ros_psychological_all_symptoms,$symptom );
    }

    $ros_psychological_saved_symptoms = active_record::where('patient_id', $id)
        ->where('navigation_id','18')->where('doc_control_id','41')->pluck('value');

    //Converting object to array
    $ros_psychological_saved_symptoms = str_replace(['['], '', $ros_psychological_saved_symptoms);
    $ros_psychological_saved_symptoms = str_replace(['"'], '', $ros_psychological_saved_symptoms);
    $ros_psychological_saved_symptoms = str_replace(['"'], '', $ros_psychological_saved_symptoms);
    $ros_psychological_saved_symptoms = str_replace([']'], '', $ros_psychological_saved_symptoms);
    $ros_psychological_saved_symptoms = explode(",", $ros_psychological_saved_symptoms);

    $ros_psychological_symptoms = Array();

    foreach($ros_psychological_all_symptoms as $symptom)
    {
        $ros_psychological_symptom = new symptom();
        $ros_psychological_symptom->value = $symptom[0];
        if(in_array($symptom[0], $ros_psychological_saved_symptoms))
        {
            $ros_psychological_symptom->is_saved = true;
        }
        else
        {
            $ros_psychological_symptom->is_saved = false;
        }
        array_push($ros_psychological_symptoms, $ros_psychological_symptom);
    }
    return $ros_psychological_symptoms;
}

public function get_ROS_gastrointestinal_symptoms($id)
{
    $ros_gastrointestinal_all_symptoms = array();
    $ros_gastrointestinal_all_lookup_values = doc_lookup_value::where('doc_control_id',43)->pluck('lookup_value_id');

    foreach ($ros_gastrointestinal_all_lookup_values as $ros_gastrointestinal_all_lookup_value)
    {
        $symptom = lookup_value::where('lookup_value_id',$ros_gastrointestinal_all_lookup_value)->pluck('lookup_value');
        array_push($ros_gastrointestinal_all_symptoms,$symptom );
    }

    $ros_gastrointestinal_saved_symptoms = active_record::where('patient_id', $id)
        ->where('navigation_id','19')->where('doc_control_id','43')->pluck('value');

    //Converting object to array
    $ros_gastrointestinal_saved_symptoms = str_replace(['['], '', $ros_gastrointestinal_saved_symptoms);
    $ros_gastrointestinal_saved_symptoms = str_replace(['"'], '', $ros_gastrointestinal_saved_symptoms);
    $ros_gastrointestinal_saved_symptoms = str_replace(['"'], '', $ros_gastrointestinal_saved_symptoms);
    $ros_gastrointestinal_saved_symptoms = str_replace([']'], '', $ros_gastrointestinal_saved_symptoms);
    $ros_gastrointestinal_saved_symptoms = explode(",", $ros_gastrointestinal_saved_symptoms);

    $ros_gastrointestinal_symptoms = Array();

    foreach($ros_gastrointestinal_all_symptoms as $symptom)
    {
        $ros_gastrointestinal_symptom = new symptom();
        $ros_gastrointestinal_symptom->value = $symptom[0];
        if(in_array($symptom[0], $ros_gastrointestinal_saved_symptoms))
        {
            $ros_gastrointestinal_symptom->is_saved = true;
        }
        else
        {
            $ros_gastrointestinal_symptom->is_saved = false;
        }
        array_push($ros_gastrointestinal_symptoms, $ros_gastrointestinal_symptom);
    }
    return $ros_gastrointestinal_symptoms;
}

    public function get_orders($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {
            //Student cannot view deleted patients
            $patient = patient::where('patient_id', $id)->first();
            if($patient->archived)
            {
                $error_message = "You cannot view deleted patient.";
                return view('errors/error', compact('error_message'));
            }
            //Student cannot edit submitted patients
            elseif ($patient->completed_flag) {
                $error_message = "You cannot edit submitted patient. ";
                return view('errors/error', compact('error_message'));
            }
            else {
            $labs = active_record::where('patient_id', $id)
                ->where('navigation_id','31')->where('doc_control_id','73')->get();

            $images = active_record::where('patient_id', $id)
                ->where('navigation_id','31') ->where('doc_control_id','74')->get();

            $comment_order = active_record::where('patient_id', $id)
                ->where('navigation_id','31')
                ->where('doc_control_id','75')->get();

            //Fetching all navs associated with this patient's module
            $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');

            $navs = array();
            //Now get nav names
            foreach ($navIds as $nav_id) {
                $nav = navigation::where('navigation_id', $nav_id)->get();
                array_push($navs, $nav);
            }
            //Extracting vital signs for header
            $vital_signs_header = $this->get_vital_signs_header($id);

            //Extracting disposition to enable or disable the submit button
            $disposition = active_record::where('patient_id', $id)
                ->where('navigation_id', '34')->get();
            $user_id = Auth::user()->id;
            $status = users_patient::where('patient_id',$id)->where('user_id',$user_id)->first();
                if($status) {
                    $status_id = $status->patient_record_status_id;
                    return view('patient/orders', compact ('status_id','vital_signs_header','patient','navs','labs','images','comment_order','disposition'));
                }
                else
                {
                    $error_message= "Student can only view their created patients. You are not authorized to view this page.";
                    return view('errors/error',compact('error_message'));
                }
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }
    public function get_results($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {
            //Student cannot view deleted patients
            $patient = patient::where('patient_id', $id)->first();
            if($patient->archived)
            {
                $error_message = "You cannot view deleted patient.";
                return view('errors/error', compact('error_message'));
            }
            //Student cannot edit submitted patients
            elseif ($patient->completed_flag) {
                $error_message = "You cannot edit submitted patient. ";
                return view('errors/error', compact('error_message'));
            }
            else {
            $labs = active_record::where('patient_id', $id)
                ->where('navigation_id','31')->where('doc_control_id','73')->get();

            $images = active_record::where('patient_id', $id)
                ->where('navigation_id','31') ->where('doc_control_id','74')->get();

            $results = active_record::where('patient_id', $id)
                ->where('navigation_id','32')
                ->where('doc_control_id','71')->get();

            //Fetching all navs associated with this patient's module
            $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');

            $navs = array();
            //Now get nav names
            foreach ($navIds as $nav_id) {
                $nav = navigation::where('navigation_id', $nav_id)->get();
                array_push($navs, $nav);
            }
            //Extracting vital signs for header
            $vital_signs_header = $this->get_vital_signs_header($id);

            //Extracting disposition to enable or disable the submit button
            $disposition = active_record::where('patient_id', $id)
                ->where('navigation_id', '34')->get();
            $user_id = Auth::user()->id;
            $status = users_patient::where('patient_id',$id)->where('user_id',$user_id)->first();
            if($status) {
                $status_id = $status->patient_record_status_id;
                return view('patient/results', compact ('status_id','vital_signs_header','labs','images','results','patient','navs','disposition'));
            }
            else
            {
                $error_message= "Student can only view their created patients. You are not authorized to view this page.";
                return view('errors/error',compact('error_message'));
            }
        }
    }
    else
    {
        $error_message= "You are not authorized to view this page.";
        return view('errors/error',compact('error_message'));
    }
}
    public function get_MDM($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {
            //Student cannot view deleted patients
            $patient = patient::where('patient_id', $id)->first();
            if($patient->archived)
            {
                $error_message = "You cannot view deleted patient.";
                return view('errors/error', compact('error_message'));
            }
            //Student cannot edit submitted patients
            elseif ($patient->completed_flag) {
                $error_message = "You cannot edit submitted patient. ";
                return view('errors/error', compact('error_message'));
            }
            else {
            $MDM = active_record::where('patient_id', $id)
                ->where('navigation_id','33')
                ->where('doc_control_id','65')->get();

            //Fetching all navs associated with this patient's module
            $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');

            $navs = array();
            //Now get nav names
            foreach ($navIds as $nav_id) {
                $nav = navigation::where('navigation_id', $nav_id)->get();
                array_push($navs, $nav);
            }
            //Extracting vital signs for header
            $vital_signs_header = $this->get_vital_signs_header($id);

            //Extracting disposition to enable or disable the submit button
            $disposition = active_record::where('patient_id', $id)
                ->where('navigation_id', '34')->get();
            $user_id = Auth::user()->id;
            $status = users_patient::where('patient_id',$id)->where('user_id',$user_id)->first();
                if($status) {
                    $status_id = $status->patient_record_status_id;
                    return view('patient/MDM', compact ('MDM','patient','navs','vital_signs_header','disposition', 'status_id'));
                }
                else
                {
                    $error_message= "Student can only view their created patients. You are not authorized to view this page.";
                    return view('errors/error',compact('error_message'));
                }
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }
    public function get_disposition($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {

            //Student cannot view deleted patients
            $patient = patient::where('patient_id', $id)->first();
            if($patient->archived)
            {
                $error_message = "You cannot view deleted patient.";
                return view('errors/error', compact('error_message'));
            }
            //Student cannot edit submitted patients
            elseif ($patient->completed_flag) {
                $error_message = "You cannot edit submitted patient. ";
                return view('errors/error', compact('error_message'));
            }
            else {
            $disposition_value = active_record::where('patient_id', $id)
                ->where('navigation_id','34')
                ->where('doc_control_id','67')->pluck('value');

            $disposition_comment = active_record::where('patient_id', $id)
                ->where('navigation_id','34')
                ->where('doc_control_id','68')->pluck('value');

            if(!count($disposition_value)>0)
            {
                $disposition_value[0] = '';
            }
            if(!count($disposition_comment)>0)
            {
                $disposition_comment[0] = '';
            }
            //Fetching all navs associated with this patient's module
            $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');

            $navs = array();
            //Now get nav names
            foreach ($navIds as $nav_id) {
                $nav = navigation::where('navigation_id', $nav_id)->get();
                array_push($navs, $nav);
            }
            //Extracting vital signs for header
            $vital_signs_header = $this->get_vital_signs_header($id);

            //Extracting disposition to enable or disable the submit button
            $disposition = active_record::where('patient_id', $id)
                ->where('navigation_id', '34')->get();

            $user_id = Auth::user()->id;
            $status = users_patient::where('patient_id',$id)->where('user_id',$user_id)->first();
            if($status) {
                $status_id = $status->patient_record_status_id;
                return view('patient/disposition', compact ('disposition_value','disposition_comment','status_id','vital_signs_header','patient','navs','disposition'));
            }
            else
            {
                $error_message= "Student can only view their created patients. You are not authorized to view this page.";
                return view('errors/error',compact('error_message'));
            }
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }
    public function get_vital_signs_header($id)
    {
        $vital_signs_header = new vital_signs_header();
        $patient = patient::where('patient_id', $id)->first();

        $vital_signs_header->age = $patient->age;
        $vital_signs_header->name = $patient->first_name. ' '.$patient->last_name ;
        $vital_signs_header->gender = $patient->gender;
        $vital_signs_header->room_number = $patient->room_number;
        $vital_signs_header->visit_date = $patient->visit_date;


        $vital_signs_header->BP_systolic = active_record::where('patient_id', $id)
            ->where('navigation_id','8')
            ->where('doc_control_id','18')
            ->orderBy('created_at','desc')
            ->pluck('value');

        $vital_signs_header->BP_diastolic = active_record::where('patient_id', $id)
            ->where('navigation_id','8')
            ->where('doc_control_id','19')
            ->orderBy('created_at','desc')
            ->pluck('value');

        $vital_signs_header->heart_rate = active_record::where('patient_id', $id)
            ->where('navigation_id','8')
            ->where('doc_control_id','20')
            ->orderBy('created_at','desc')
            ->pluck('value');

        $vital_signs_header->respiratory_rate = active_record::where('patient_id', $id)
            ->where('navigation_id','8')
            ->where('doc_control_id','21')
            ->orderBy('created_at','desc')
            ->pluck('value');

        $vital_signs_header->temperature = active_record::where('patient_id', $id)
            ->where('navigation_id','8')
            ->where('doc_control_id','22')
            ->orderBy('created_at','desc')
            ->pluck('value');

        $vital_signs_header->oxygen_saturation = active_record::where('patient_id', $id)
            ->where('navigation_id','8')
            ->where('doc_control_id','69')
            ->orderBy('created_at','desc')
            ->pluck('value');

        $vital_signs_header->pain = active_record::where('patient_id', $id)
            ->where('navigation_id','8')
            ->where('doc_control_id','23')
            ->orderBy('created_at','desc')
            ->pluck('value');

        return $vital_signs_header;
    }
    public function get_assignInstructor($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {
                //Student cannot view submitted patients
                $patient_status = patient::where('patient_id', $id)->pluck('completed_flag');
                if ($patient_status[0]) {
                    $error_message = "You cannot edit submitted patient. ";
                    return view('errors/error', compact('error_message'));
                }
                else {
                $patient = patient::where('patient_id', $id)->first();
                //Fetching all navs associated with this patient's module
                $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');
                $navs = array();
                //Now get nav names
                foreach ($navIds as $nav_id) {
                    $nav = navigation::where('navigation_id', $nav_id)->get();
                    array_push($navs, $nav);
                }
                //Extracting vital signs for header
                $vital_signs_header = $this->get_vital_signs_header($id);
                //Extracting disposition to enable or disable the submit button
                $disposition = active_record::where('patient_id', $id)
                    ->where('navigation_id', '34')->get();
                $user_id = Auth::user()->id;
                $status = users_patient::where('patient_id',$id)->where('user_id',$user_id)->first();
                if($status) {
                    $status_id = $status->patient_record_status_id;
                    return view('patient/assign_instructor', compact ('disposition','status_id','vital_signs_header','medications','medication_comment','patient','navs'));
                }
                else
                {
                    $error_message= "Student can only view their created patients. You are not authorized to view this page.";
                    return view('errors/error',compact('error_message'));
                }
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }
    public function generate_pdf($id)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student' || $role == 'Instructor') {
            //Student cannot preview deleted patients
            $patient = patient::where('patient_id', $id)->first();
            if($patient->archived)
            {
                $error_message = "You cannot generate pdf of deleted patient.";
                return view('errors/error', compact('error_message'));
            }
            //Student cannot preview saved patients
            elseif (!$patient->completed_flag) {
                $error_message = "This patient is in saved state. You can generate pdf of only submitted patient.";
                return view('errors/error', compact('error_message'));
            }
            else {
                $HPI = active_record::where('patient_id', $id)
                    ->where('navigation_id', '1')
                    ->where('doc_control_id', '1')->get();

                //Getting Personal History values
                $diagnosis_list_personal_history = active_record::where('patient_id', $id)
                    ->where('navigation_id', '3')
                    ->where('doc_control_id', '3')->get();

                $personal_history_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '3')
                    ->where('doc_control_id', '4')->get();

                //Getting Family History values
                $comment_family_history = active_record::where('patient_id', $id)
                    ->where('navigation_id', '4')
                    ->where('doc_control_id', '8')->pluck('value');

                $members_family_history = active_record::where('patient_id', $id)
                    ->where('navigation_id', '4')
                    ->where('doc_control_id', '5')->get();

                $family_members_details = Array();

                foreach ($members_family_history as $member) {
                    $member_status = active_record::where('patient_id', $id)
                        ->where('navigation_id', '4')
                        ->where('doc_control_id', '7')
                        ->where('doc_control_group', $member->active_record_id)->pluck('value');

                    $member_diagnosis = active_record::where('patient_id', $id)
                        ->where('navigation_id', '4')
                        ->where('doc_control_id', '6')
                        ->where('doc_control_group', $member->active_record_id)->pluck('value');

                    $family_member_details = new family_member();
                    $family_member_details->relation = $member->value;
                    $family_member_details->status = $member_status;
                    $family_member_details->diagnosis = $member_diagnosis;

                    array_push($family_members_details, $family_member_details);
                }

                //Getting Surgical History values
                $diagnosis_list_surgical_history = active_record::where('patient_id', $id)
                    ->where('navigation_id', '5')
                    ->where('doc_control_id', '9')->get();

                $surgical_history_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '5')
                    ->where('doc_control_id', '10')->get();

                //Getting Social History values
                $social_history_smoke_tobacco = "";
                $social_history_non_smoke_tobacco = "";
                $social_history_alcohol = "";
                $social_history_sexual_activity = "";
                $social_history_comment = "";

                $social_history_values = active_record::where('patient_id', $id)->where('navigation_id', '6')->get();
                foreach ($social_history_values as $social_history) {
                    Switch ($social_history->doc_control_id) {
                        case "11":
                            $social_history_smoke_tobacco = $social_history->value;
                            break;

                        case "12":
                            $social_history_non_smoke_tobacco = $social_history->value;
                            break;

                        case "13":
                            $social_history_alcohol = $social_history->value;
                            break;

                        case "14":
                            $social_history_sexual_activity = $social_history->value;
                            break;

                        case "15":
                            $social_history_comment = $social_history->value;
                            break;
                    }

                }

                //Getting medications
                $medications = active_record::where('patient_id', $id)
                    ->where('navigation_id', '7')
                    ->where('doc_control_id', '16')->get();

                $medication_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '7')
                    ->where('doc_control_id', '17')->get();

                //Getting vital signs
                $timestamps = active_record::where('patient_id', $id)
                    ->where('navigation_id', '8')->distinct()->pluck('created_at');
                $vital_sign_details = Array();
                foreach ($timestamps as $ts) {
                    $vital_sign_detail = new vital_signs();
                    $vital_sign_detail->timestamp = $ts;
                    $vital_sign_detail->BP_Diastolic = active_record::where('patient_id', $id)
                        ->where('navigation_id', '8')
                        ->where('doc_control_id', '19')
                        ->where('created_at', $ts)->pluck('value');
                    $vital_sign_detail->BP_Systolic = active_record::where('patient_id', $id)
                        ->where('navigation_id', '8')
                        ->where('doc_control_id', '18')
                        ->where('created_at', $ts)->pluck('value');
                    $vital_sign_detail->Heart_Rate =
                        active_record::where('patient_id', $id)
                            ->where('navigation_id', '8')
                            ->where('doc_control_id', '20')
                            ->where('created_at', $ts)->pluck('value');
                    $vital_sign_detail->Respiratory_Rate = active_record::where('patient_id', $id)
                        ->where('navigation_id', '8')
                        ->where('doc_control_id', '21')
                        ->where('created_at', $ts)->pluck('value');
                    $vital_sign_detail->Temperature = active_record::where('patient_id', $id)
                        ->where('navigation_id', '8')
                        ->where('doc_control_id', '22')
                        ->where('created_at', $ts)->pluck('value');
                    $vital_sign_detail->Weight = active_record::where('patient_id', $id)
                        ->where('navigation_id', '8')
                        ->where('doc_control_id', '76')
                        ->where('created_at', $ts)->pluck('value');
                    $vital_sign_detail->Height = active_record::where('patient_id', $id)
                        ->where('navigation_id', '8')
                        ->where('doc_control_id', '77')
                        ->where('created_at', $ts)->pluck('value');
                    $vital_sign_detail->Pain = active_record::where('patient_id', $id)
                        ->where('navigation_id', '8')
                        ->where('doc_control_id', '23')
                        ->where('created_at', $ts)->pluck('value');
                    $vital_sign_detail->Oxygen_Saturation = active_record::where('patient_id', $id)
                        ->where('navigation_id', '8')
                        ->where('doc_control_id', '69')
                        ->where('created_at', $ts)->pluck('value');
                    $vital_sign_detail->Comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '8')
                        ->where('doc_control_id', '24')
                        ->where('created_at', $ts)->pluck('value');
                    array_push($vital_sign_details, $vital_sign_detail);
                }
                // ROS
                $ros_constitutional_symptoms = $this->get_ROS_costitutional_symptoms($id);
                $ros_constitutional_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '10')->where('doc_control_id', '26')->pluck('value');

                $ros_hent_symptoms = $this->get_ROS_hent_symptoms($id);
                $ros_hent_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '11')->where('doc_control_id', '28')->pluck('value');

                $ros_eyes_symptoms = $this->get_ROS_eyes_symptoms($id);
                $ros_eyes_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '12')->where('doc_control_id', '30')->pluck('value');

                $ros_respiratory_symptoms = $this->get_ROS_respiratory_symptoms($id);
                $ros_respiratory_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '13')->where('doc_control_id', '32')->pluck('value');

                $ros_cardiovascular_symptoms = $this->get_ROS_cardiovascular_symptoms($id);
                $ros_cardiovascular_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '14')->where('doc_control_id', '34')->pluck('value');

                $ros_musculoskeletal_symptoms = $this->get_ROS_musculoskeletal_symptoms($id);
                $ros_musculoskeletal_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '15')->where('doc_control_id', '36')->pluck('value');

                $ros_integumentary_symptoms = $this->get_ROS_integumentary_symptoms($id);
                $ros_integumentary_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '16')->where('doc_control_id', '38')->pluck('value');

                $ros_neurological_symptoms = $this->get_ROS_neurological_symptoms($id);
                $ros_neurological_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '17')->where('doc_control_id', '40')->pluck('value');

                $ros_psychological_symptoms = $this->get_ROS_psychological_symptoms($id);
                $ros_psychological_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '18')->where('doc_control_id', '42')->pluck('value');

                $ros_gastrointestinal_symptoms = $this->get_ROS_gastrointestinal_symptoms($id);
                $ros_gastrointestinal_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '19')->where('doc_control_id', '44')->pluck('value');

                //PE

                $gastrointestinal_symptoms = $this->get_physical_exams_gastrointestinal_symptoms($id);
                $gastrointestinal_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '30')->where('doc_control_id', '64')->pluck('value');

                $psychological_symptoms = $this->get_physical_exams_psychological_symptoms($id);
                $psychological_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '29')->where('doc_control_id', '62')->pluck('value');

                $neurological_symptoms = $this->get_physical_exams_neurological_symptoms($id);
                $neurological_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '28')->where('doc_control_id', '60')->pluck('value');

                $integumentary_symptoms = $this->get_physical_exams_integumentary_symptoms($id);
                $integumentary_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '27')->where('doc_control_id', '58')->pluck('value');

                $musculoskeletal_symptoms = $this->get_physical_exams_musculoskeletal_symptoms($id);
                $musculoskeletal_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '26')->where('doc_control_id', '56')->pluck('value');

                $cardiovascular_symptoms = $this->get_physical_exams_cardiovascular_symptoms($id);
                $cardiovascular_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '25')->where('doc_control_id', '54')->pluck('value');

                $respiratory_symptoms = $this->get_physical_exams_respiratory_symptoms($id);
                $respiratory_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '24')->where('doc_control_id', '52')->pluck('value');

                $eyes_symptoms = $this->get_physical_exams_eyes_symptoms($id);
                $eyes_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '23')->where('doc_control_id', '50')->pluck('value');

                $hent_symptoms = $this->get_physical_exams_HENT_symptoms($id);
                $hent_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '22')->where('doc_control_id', '48')->pluck('value');

                $constitutional_symptoms = $this->get_physical_exams_constitutional_symptoms($id);
                $constitutional_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '21')->where('doc_control_id', '46')->pluck('value');

                //Get orders
                $labs = active_record::where('patient_id', $id)
                    ->where('navigation_id', '31')->where('doc_control_id', '73')->get();

                $images = active_record::where('patient_id', $id)
                    ->where('navigation_id', '31')->where('doc_control_id', '74')->get();

                $comment_order = active_record::where('patient_id', $id)
                    ->where('navigation_id', '31')
                    ->where('doc_control_id', '75')->get();

                //Get results
                $results = active_record::where('patient_id', $id)
                    ->where('navigation_id', '32')
                    ->where('doc_control_id', '71')->get();

                //Get MDM
                $mdm = active_record::where('patient_id', $id)
                    ->where('navigation_id', '33')
                    ->where('doc_control_id', '65')->get();

                //Get Disposition
                $disposition_value = active_record::where('patient_id', $id)
                    ->where('navigation_id', '34')
                    ->where('doc_control_id', '67')->pluck('value');

                $disposition_comment = active_record::where('patient_id', $id)
                    ->where('navigation_id', '34')
                    ->where('doc_control_id', '68')->pluck('value');


                $patient = patient::where('patient_id', $id)->first();
                //Fetching all navs associated with this patient's module
                $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');

                $navs = array();

                //Now get nav names
                foreach ($navIds as $key => $nav_id) {
                    $nav = navigation::where('navigation_id', $nav_id)->get();
                    array_push($navs, $nav);
                }

                //Extracting vital signs for header
                $vital_signs_header = $this->get_vital_signs_header($id);

                //Fetching assigned instructors for student
                $instructorIds = users_patient::where('patient_id', $id)
                    ->where(function ($q)
                    {
                        $q->where('patient_record_status_id', '2')->orWhere('patient_record_status_id', '3');
                    })
                    ->pluck('user_id');
                $instructor_Details = array();

                 //Now get Instructor names
                foreach ($instructorIds as $key => $instructorId) {
                    $instructorDetail = User::where('id', $instructorId)->where('role', 'Instructor')->get();
                    array_push($instructor_Details, $instructorDetail);
                }

                //getting student name for instructor
                $student_record = users_patient::where('patient_id',$id)
                    ->where('patient_record_status_id','2')->first();
                $student_id = $student_record->created_by;
                $student_details = User::where('id', $student_id)->where('role', 'Student')->get();

                try {
                    $pdf = PDF::loadView('patient.preview', compact('student_details','instructor_Details', 'patient', 'navs',
                        'vital_signs_header', 'HPI', 'diagnosis_list_surgical_history', 'surgical_history_comment',
                        'diagnosis_list_personal_history', 'personal_history_comment', 'family_members_details',
                        'comment_family_history', 'social_history_smoke_tobacco', 'social_history_non_smoke_tobacco',
                        'social_history_alcohol', 'social_history_sexual_activity', 'social_history_comment', 'medications',
                        'medication_comment', 'vital_sign_details', 'ros_constitutional_symptoms', 'ros_constitutional_comment',
                        'ros_hent_symptoms', 'ros_hent_comment', 'ros_eyes_symptoms', 'ros_eyes_comment', 'ros_respiratory_symptoms',
                        'ros_respiratory_comment', 'ros_cardiovascular_symptoms', 'ros_cardiovascular_comment',
                        'ros_musculoskeletal_symptoms', 'ros_musculoskeletal_comment', 'ros_integumentary_symptoms',
                        'ros_integumentary_comment', 'ros_neurological_symptoms', 'ros_neurological_comment',
                        'ros_psychological_symptoms', 'ros_psychological_comment',  'ros_gastrointestinal_symptoms', 'ros_gastrointestinal_comment', 'neurological_symptoms',
                        'neurological_comment', 'psychological_symptoms', 'psychological_comment', 'gastrointestinal_symptoms', 'gastrointestinal_comment', 'integumentary_symptoms',
                        'integumentary_comment', 'musculoskeletal_symptoms', 'musculoskeletal_comment',
                        'cardiovascular_symptoms', 'cardiovascular_comment', 'respiratory_symptoms', 'respiratory_comment',
                        'eyes_symptoms', 'eyes_comment', 'hent_symptoms', 'hent_comment', 'constitutional_symptoms',
                        'constitutional_comment', 'comment_order', 'labs', 'images', 'results', 'mdm', 'disposition_value', 'disposition_comment'));

                    return $pdf->download('patient_report.pdf');
                } catch (\Exception $e) {
                    $error_message = "We have encountered an error while generating the pdf file. Please try again!";
                    return view('errors/error', compact('error_message'));
                }
            }
        }
        else
        {
            $error_message= "You are not authorized to view this page.";
            return view('errors/error',compact('error_message'));
        }
    }
    public function get_preview($id){
            $role='';
            if(Auth::check()) {
                $role = Auth::user()->role;
            }

            if($role == 'Student' || $role == 'Instructor') {
                //Student cannot preview deleted patients
                $patient = patient::where('patient_id', $id)->first();
                if($patient->archived)
                {
                    $error_message = "You cannot preview deleted patient.";
                    return view('errors/error', compact('error_message'));
                }
                //Student cannot preview saved patients
                elseif (!$patient->completed_flag) {
                    $error_message = "This patient is in saved state. You can preview only submitted patient.";
                    return view('errors/error', compact('error_message'));
                } else {
                    $HPI = active_record::where('patient_id', $id)
                        ->where('navigation_id', '1')
                        ->where('doc_control_id', '1')->get();

                    //Getting Personal History values
                    $diagnosis_list_personal_history = active_record::where('patient_id', $id)
                        ->where('navigation_id', '3')
                        ->where('doc_control_id', '3')->get();

                    $personal_history_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '3')
                        ->where('doc_control_id', '4')->get();

                    //Getting Family History values
                    $comment_family_history = active_record::where('patient_id', $id)
                        ->where('navigation_id', '4')
                        ->where('doc_control_id', '8')->pluck('value');

                    $members_family_history = active_record::where('patient_id', $id)
                        ->where('navigation_id', '4')
                        ->where('doc_control_id', '5')->get();

                    $family_members_details = Array();

                    foreach ($members_family_history as $member) {
                        $member_status = active_record::where('patient_id', $id)
                            ->where('navigation_id', '4')
                            ->where('doc_control_id', '7')
                            ->where('doc_control_group', $member->active_record_id)->pluck('value');

                        $member_diagnosis = active_record::where('patient_id', $id)
                            ->where('navigation_id', '4')
                            ->where('doc_control_id', '6')
                            ->where('doc_control_group', $member->active_record_id)->pluck('value');

                        $family_member_details = new family_member();
                        $family_member_details->relation = $member->value;
                        $family_member_details->status = $member_status;
                        $family_member_details->diagnosis = $member_diagnosis;

                        array_push($family_members_details, $family_member_details);
                    }

                    //Getting Surgical History values
                    $diagnosis_list_surgical_history = active_record::where('patient_id', $id)
                        ->where('navigation_id', '5')
                        ->where('doc_control_id', '9')->get();

                    $surgical_history_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '5')
                        ->where('doc_control_id', '10')->get();

                    //Getting Social History values
                    $social_history_smoke_tobacco = "";
                    $social_history_non_smoke_tobacco = "";
                    $social_history_alcohol = "";
                    $social_history_sexual_activity = "";
                    $social_history_comment = "";

                    $social_history_values = active_record::where('patient_id', $id)->where('navigation_id', '6')->get();
                    foreach ($social_history_values as $social_history) {
                        Switch ($social_history->doc_control_id) {
                            case "11":
                                $social_history_smoke_tobacco = $social_history->value;
                                break;

                            case "12":
                                $social_history_non_smoke_tobacco = $social_history->value;
                                break;

                            case "13":
                                $social_history_alcohol = $social_history->value;
                                break;

                            case "14":
                                $social_history_sexual_activity = $social_history->value;
                                break;

                            case "15":
                                $social_history_comment = $social_history->value;
                                break;
                        }

                    }

                    //Getting medications
                    $medications = active_record::where('patient_id', $id)
                        ->where('navigation_id', '7')
                        ->where('doc_control_id', '16')->get();

                    $medication_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '7')
                        ->where('doc_control_id', '17')->get();

                    //Getting vital signs
                    $timestamps = active_record::where('patient_id', $id)
                        ->where('navigation_id', '8')->distinct()->pluck('created_at');
                    $vital_sign_details = Array();
                    foreach ($timestamps as $ts) {
                        $vital_sign_detail = new vital_signs();
                        $vital_sign_detail->timestamp = $ts;
                        $vital_sign_detail->BP_Diastolic = active_record::where('patient_id', $id)
                            ->where('navigation_id', '8')
                            ->where('doc_control_id', '19')
                            ->where('created_at', $ts)->pluck('value');
                        $vital_sign_detail->BP_Systolic = active_record::where('patient_id', $id)
                            ->where('navigation_id', '8')
                            ->where('doc_control_id', '18')
                            ->where('created_at', $ts)->pluck('value');
                        $vital_sign_detail->Heart_Rate =
                            active_record::where('patient_id', $id)
                                ->where('navigation_id', '8')
                                ->where('doc_control_id', '20')
                                ->where('created_at', $ts)->pluck('value');
                        $vital_sign_detail->Respiratory_Rate = active_record::where('patient_id', $id)
                            ->where('navigation_id', '8')
                            ->where('doc_control_id', '21')
                            ->where('created_at', $ts)->pluck('value');
                        $vital_sign_detail->Temperature = active_record::where('patient_id', $id)
                            ->where('navigation_id', '8')
                            ->where('doc_control_id', '22')
                            ->where('created_at', $ts)->pluck('value');
                        $vital_sign_detail->Weight = active_record::where('patient_id', $id)
                            ->where('navigation_id', '8')
                            ->where('doc_control_id', '76')
                            ->where('created_at', $ts)->pluck('value');
                        $vital_sign_detail->Height = active_record::where('patient_id', $id)
                            ->where('navigation_id', '8')
                            ->where('doc_control_id', '77')
                            ->where('created_at', $ts)->pluck('value');
                        $vital_sign_detail->Pain = active_record::where('patient_id', $id)
                            ->where('navigation_id', '8')
                            ->where('doc_control_id', '23')
                            ->where('created_at', $ts)->pluck('value');
                        $vital_sign_detail->Oxygen_Saturation = active_record::where('patient_id', $id)
                            ->where('navigation_id', '8')
                            ->where('doc_control_id', '69')
                            ->where('created_at', $ts)->pluck('value');
                        $vital_sign_detail->Comment = active_record::where('patient_id', $id)
                            ->where('navigation_id', '8')
                            ->where('doc_control_id', '24')
                            ->where('created_at', $ts)->pluck('value');
                        array_push($vital_sign_details, $vital_sign_detail);
                    }
                    // ROS
                    $ros_constitutional_symptoms = $this->get_ROS_costitutional_symptoms($id);
                    $ros_constitutional_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '10')->where('doc_control_id', '26')->pluck('value');

                    $ros_hent_symptoms = $this->get_ROS_hent_symptoms($id);
                    $ros_hent_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '11')->where('doc_control_id', '28')->pluck('value');

                    $ros_eyes_symptoms = $this->get_ROS_eyes_symptoms($id);
                    $ros_eyes_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '12')->where('doc_control_id', '30')->pluck('value');

                    $ros_respiratory_symptoms = $this->get_ROS_respiratory_symptoms($id);
                    $ros_respiratory_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '13')->where('doc_control_id', '32')->pluck('value');

                    $ros_cardiovascular_symptoms = $this->get_ROS_cardiovascular_symptoms($id);
                    $ros_cardiovascular_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '14')->where('doc_control_id', '34')->pluck('value');

                    $ros_musculoskeletal_symptoms = $this->get_ROS_musculoskeletal_symptoms($id);
                    $ros_musculoskeletal_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '15')->where('doc_control_id', '36')->pluck('value');

                    $ros_integumentary_symptoms = $this->get_ROS_integumentary_symptoms($id);
                    $ros_integumentary_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '16')->where('doc_control_id', '38')->pluck('value');

                    $ros_neurological_symptoms = $this->get_ROS_neurological_symptoms($id);
                    $ros_neurological_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '17')->where('doc_control_id', '40')->pluck('value');

                    $ros_psychological_symptoms = $this->get_ROS_psychological_symptoms($id);
                    $ros_psychological_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '18')->where('doc_control_id', '42')->pluck('value');

                    $ros_gastrointestinal_symptoms = $this->get_ROS_gastrointestinal_symptoms($id);
                    $ros_gastrointestinal_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '19')->where('doc_control_id', '43')->pluck('value');

                    //PE

                    $gastrointestinal_symptoms = $this->get_physical_exams_gastrointestinal_symptoms($id);
                    $gastrointestinal_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '30')->where('doc_control_id', '64')->pluck('value');

                    $psychological_symptoms = $this->get_physical_exams_psychological_symptoms($id);
                    $psychological_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '29')->where('doc_control_id', '62')->pluck('value');

                    $neurological_symptoms = $this->get_physical_exams_neurological_symptoms($id);
                    $neurological_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '28')->where('doc_control_id', '60')->pluck('value');

                    $integumentary_symptoms = $this->get_physical_exams_integumentary_symptoms($id);
                    $integumentary_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '27')->where('doc_control_id', '58')->pluck('value');

                    $musculoskeletal_symptoms = $this->get_physical_exams_musculoskeletal_symptoms($id);
                    $musculoskeletal_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '26')->where('doc_control_id', '56')->pluck('value');

                    $cardiovascular_symptoms = $this->get_physical_exams_cardiovascular_symptoms($id);
                    $cardiovascular_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '25')->where('doc_control_id', '54')->pluck('value');

                    $respiratory_symptoms = $this->get_physical_exams_respiratory_symptoms($id);
                    $respiratory_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '24')->where('doc_control_id', '52')->pluck('value');

                    $eyes_symptoms = $this->get_physical_exams_eyes_symptoms($id);
                    $eyes_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '23')->where('doc_control_id', '50')->pluck('value');

                    $hent_symptoms = $this->get_physical_exams_HENT_symptoms($id);
                    $hent_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '22')->where('doc_control_id', '48')->pluck('value');

                    $constitutional_symptoms = $this->get_physical_exams_constitutional_symptoms($id);
                    $constitutional_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id', '21')->where('doc_control_id', '46')->pluck('value');

                    //Get orders
                    $labs = active_record::where('patient_id', $id)
                        ->where('navigation_id', '31')->where('doc_control_id', '73')->get();

                    $images = active_record::where('patient_id', $id)
                        ->where('navigation_id', '31')->where('doc_control_id', '74')->get();

                    $comment_order = active_record::where('patient_id', $id)
                        ->where('navigation_id', '31')
                        ->where('doc_control_id', '75')->get();

                    //Get results
                    $results = active_record::where('patient_id', $id)
                        ->where('navigation_id', '32')
                        ->where('doc_control_id', '71')->get();

                    //Get MDM
                    $mdm = active_record::where('patient_id', $id)
                        ->where('navigation_id','33')
                        ->where('doc_control_id','65')->get();

                    //Get Disposition
                    $disposition_value = active_record::where('patient_id', $id)
                        ->where('navigation_id','34')
                        ->where('doc_control_id','67')->pluck('value');

                    $disposition_comment = active_record::where('patient_id', $id)
                        ->where('navigation_id','34')
                        ->where('doc_control_id','68')->pluck('value');


                    $patient = patient::where('patient_id', $id)->first();
                    //Fetching all navs associated with this patient's module
                    $navIds = module_navigation::where('module_id', $patient->module_id)->orderBy('navigation_id')->pluck('navigation_id');

                    $navs = array();

                    //Now get nav names
                    foreach ($navIds as $key => $nav_id) {
                        $nav = navigation::where('navigation_id', $nav_id)->get();
                        array_push($navs, $nav);
                    }

                    //Extracting vital signs for header
                    $vital_signs_header = $this->get_vital_signs_header($id);

                    //Fetching assigned instructors for student
                    $instructorIds = users_patient::where('patient_id', $id)
                        ->where(function ($q)
                        {
                            $q->where('patient_record_status_id', '2')->orWhere('patient_record_status_id', '3');
                        })
                        ->pluck('user_id');

                    $instructor_Details = array();

                    //Now get Instructor names
                    foreach ($instructorIds as $key => $instructorId) {
                        $instructorDetail = User::where('id', $instructorId)->where('role', 'Instructor')->get();
                        array_push($instructor_Details, $instructorDetail);
                    }

                    //getting student name for instructor
                    $student_record = users_patient::where('patient_id',$id)
                        ->where('patient_record_status_id','2')->first();
                    $student_id = $student_record->created_by;
                    $student_details = User::where('id', $student_id)->where('role', 'Student')->get();

                    return view('patient/preview', compact('student_details','instructor_Details', 'patient', 'navs',
                        'vital_signs_header', 'HPI', 'diagnosis_list_surgical_history', 'surgical_history_comment',
                        'diagnosis_list_personal_history', 'personal_history_comment', 'family_members_details',
                        'comment_family_history', 'social_history_smoke_tobacco', 'social_history_non_smoke_tobacco',
                        'social_history_alcohol', 'social_history_sexual_activity', 'social_history_comment', 'medications',
                        'medication_comment', 'vital_sign_details', 'ros_constitutional_symptoms', 'ros_constitutional_comment',
                        'ros_hent_symptoms', 'ros_hent_comment', 'ros_eyes_symptoms', 'ros_eyes_comment', 'ros_respiratory_symptoms',
                        'ros_respiratory_comment', 'ros_cardiovascular_symptoms', 'ros_cardiovascular_comment',
                        'ros_musculoskeletal_symptoms', 'ros_musculoskeletal_comment', 'ros_integumentary_symptoms',
                        'ros_integumentary_comment', 'ros_neurological_symptoms', 'ros_neurological_comment',
                        'ros_psychological_symptoms', 'ros_psychological_comment', 'ros_gastrointestinal_symptoms', 'ros_gastrointestinal_comment', 'gastrointestinal_symptoms', 'gastrointestinal_comment', 'neurological_symptoms',
                        'neurological_comment', 'psychological_symptoms', 'psychological_comment', 'integumentary_symptoms',
                        'integumentary_comment', 'musculoskeletal_symptoms', 'musculoskeletal_comment',
                        'cardiovascular_symptoms', 'cardiovascular_comment', 'respiratory_symptoms', 'respiratory_comment',
                        'eyes_symptoms', 'eyes_comment', 'hent_symptoms', 'hent_comment', 'constitutional_symptoms',
                        'constitutional_comment', 'comment_order', 'labs', 'images', 'results','mdm','disposition_value','disposition_comment'));
                }
            }
            else
            {
                $error_message= "You are not authorized to view this page";
                return view('errors/error',compact('error_message'));
            }
        }
    }
