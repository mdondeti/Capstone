<?php

namespace App\Http\Controllers;

use App\diagnosis_lookup_value;
use App\med_lookup_value;
use App\imaging_orders_lookup_value;
use App\lab_orders_lookup_value;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\users_patient;
use App\patient;
use App\active_record;
use Illuminate\Support\Facades\DB;
use Carbon;

class DocumentationController extends Controller
{
    //Below five are autocomplete search methods
    public function find_diagnosis(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $lookups = diagnosis_lookup_value::search($term)->get();

        $formatted_lookups = [];

        foreach ($lookups as $lookup) {
            $formatted_lookups[] = ['id' => $lookup->diagnosis_lookup_value_id, 'text' => $lookup->diagnosis_lookup_value];
        }

        return \Response::json($formatted_lookups);
    }
    public function find_medications(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $lookups = med_lookup_value::search($term)->get();

        $formatted_lookups = [];

        foreach ($lookups as $lookup) {
            $formatted_lookups[] = ['id' => $lookup->med_lookup_value_id, 'text' => $lookup->med_lookup_value];
        }

        return \Response::json($formatted_lookups);
    }
    public function find_lab_orders(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }
        $lookups = lab_orders_lookup_value::search($term)->get();

        $formatted_lookups = [];

        foreach ($lookups as $lookup) {
            $formatted_lookups[] = ['id' => $lookup->lab_orders_lookup_value_id, 'text' => $lookup->lab_orders_lookup_value];
        }

        return \Response::json($formatted_lookups);
    }
    public function find_imaging_orders(Request $request)
    {
        $term = trim($request->q);

        if (empty($term)) {
            return \Response::json([]);
        }

        $lookups = imaging_orders_lookup_value::search($term)->get();

        $formatted_lookups = [];

        foreach ($lookups as $lookup) {
            $formatted_lookups[] = ['id' => $lookup->imaging_orders_lookup_value_id, 'text' => $lookup->imaging_orders_lookup_value];
        }

        return \Response::json($formatted_lookups);
    }
    public function find_instructor(Request $request)
    {
        $term = trim($request->q);
        if (empty($term)) {
            return \Response::json([]);
        }
        $lookups = User::where('role', 'Instructor')->where('archived',false)->where(function ($q) use ($term)
        {
            $q->where('firstname', 'ILIKE', '%'.$term.'%')->orWhere('lastname', 'ILIKE', '%'.$term.'%');
        })->get();
        $formatted_lookups = [];
        foreach ($lookups as $lookup) {
            $formatted_lookups[] = ['id' => $lookup->firstname. ' ' . $lookup->lastname, 'text' => $lookup->firstname. ' ' . $lookup->lastname ];
        }
        return \Response::json($formatted_lookups);
    }

    public function post_Demographics(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
                //Validating input data
                $this->validate($request, [
                    'age' => 'required|numeric',
                    'room_number' => 'required',
                ]);
                $patient = patient::where('patient_id', $request['patient_id'])->first();
                //if sex is male then first name is John else Jane
                if ($request->gender == 'Male')
                {
                    $patient['first_name'] = 'John';
                }
                else
                {
                    $patient['first_name'] = 'Jane';
                }

                $patient->gender = $request->gender;
                $patient->room_number = $request->room_number;
                $patient->age = $request->age;
                $patient->save();

                return redirect()->route('Demographics',[$patient->patient_id]);

        }
        else
        {
            return view('auth/not_authorized');
        }
    }
    public function post_HPI(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //Saving HPI
                $HPI_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','1')
                    ->where('doc_control_id','1')->get();

                if(!count($HPI_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '1';
                    $active_record['doc_control_id'] = '1';
                    $active_record['value'] = $request['HPI'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $HPI_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['HPI'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('History of Present Illness (HPI)',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_results(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //Saving results
                $results_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','32')
                    ->where('doc_control_id','71')->get();

                if(!count($results_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '32';
                    $active_record['doc_control_id'] = '71';
                    $active_record['value'] = $request['results'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $results_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['results'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Results',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_orders(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                $labs = $request['search_labs_orders'];
                $images = $request['search_labs_imaging'];

                //Saving labs
                foreach ((array)$labs as $key=>$lab) {
                    $lab_value = lab_orders_lookup_value::where('lab_orders_lookup_value_id',$lab)->pluck('lab_orders_lookup_value');
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '31';
                    $active_record['doc_control_id'] = '73';
                    $active_record['value'] = $lab_value[0];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }

                //Saving Images
                foreach ((array)$images as $key=>$image) {
                    $image_value = imaging_orders_lookup_value::where('imaging_orders_lookup_value_id',$image)->pluck('imaging_orders_lookup_value');
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '31';
                    $active_record['doc_control_id'] = '74';
                    $active_record['value'] = $image_value[0];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }

                //Saving comment
                $comment_order_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','31')
                    ->where('doc_control_id','75')->get();

                if(!count($comment_order_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '31';
                    $active_record['doc_control_id'] = '75';
                    $active_record['value'] = $request['orders_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_order_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['orders_comment'];
                    $active_record->save();
                }

                //Now redirecting to orders page
                return redirect()->route('Orders',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_social_history(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //Determining its save or update
                if($request['is_new_entry_social_history'] == "no")
                {
                    $social_history_smoke_tobacco_id = $request['social_history_smoke_tobacco_id'];
                    $active_record = active_record::where('active_record_id', $social_history_smoke_tobacco_id)->first();
                    $active_record['value'] = $request['smoke_tobacco'];
                    $active_record->save();
                }
                else
                {
                    //Inserting Smoke Tobacco
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '6';
                    $active_record['doc_control_id'] = '11';
                    $active_record['value'] = $request['smoke_tobacco'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }

                //Determining its save or update
                if($request['is_new_entry_social_history'] == "no")
                {
                    $social_history_non_smoke_tobacco_id = $request['social_history_non_smoke_tobacco_id'];
                    $active_record = active_record::where('active_record_id',$social_history_non_smoke_tobacco_id)->first();
                    $active_record->value = $request['non_smoke_tobacco'];
                    $active_record->save();
                }
                else
                {
                    //Inserting Non-Smoke Tobacco
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '6';
                    $active_record['doc_control_id'] = '12';
                    $active_record['value'] = $request['non_smoke_tobacco'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }

                //Determining its save or update
                if($request['is_new_entry_social_history'] == "no")
                {
                    $social_history_alcohol_id = $request['social_history_alcohol_id'];
                    $active_record = active_record::find($request['social_history_alcohol_id']);
                    $active_record->value = $request['alcohol'];
                    $active_record->save();
                }
                else
                {
                    //Inserting Alcohol
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '6';
                    $active_record['doc_control_id'] = '13';
                    $active_record['value'] = $request['alcohol'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }

                //Determining its save or update
                if($request['is_new_entry_social_history'] == "no")
                {
                    $social_history_sexual_activity_id = $request['social_history_sexual_activity_id'];
                    $active_record = active_record::where('active_record_id',$social_history_sexual_activity_id)->first();
                    $active_record['value'] = $request['sexual_activity'];
                    $active_record->save();
                }
                else
                {
                    //Inserting Sexual Activity
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '6';
                    $active_record['doc_control_id'] = '14';
                    $active_record['value'] = $request['sexual_activity'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }

                //Determining its save or update
                if($request['is_new_entry_social_history'] == "no")
                {
                    $social_history_comment_id = $request['social_history_comment_id'];
                    $active_record = active_record::where('active_record_id',$social_history_comment_id)->first();
                    $active_record['value'] = $request['social_history_comment'];
                    $active_record->save();
                }
                else
                {
                    //Inserting Comment
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '6';
                    $active_record['doc_control_id'] = '15';
                    $active_record['value'] = $request['social_history_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }

                return redirect()->route('Social History (SHx)2',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_personal_history(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                $diagnosis = $request['search_diagnosis_personal_history'];

                //Saving medications
                foreach ((array)$diagnosis as $key=>$item) {
                    $lab_value = diagnosis_lookup_value::where('diagnosis_lookup_value_id',$item)->pluck('diagnosis_lookup_value');
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '3';
                    $active_record['doc_control_id'] = '3';
                    $active_record['value'] = $lab_value[0];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }

                //Saving comment
                $comment_personal_history_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','3')
                    ->where('doc_control_id','4')->get();

                if(!count($comment_personal_history_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '3';
                    $active_record['doc_control_id'] = '4';
                    $active_record['value'] = $request['personal_history_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_personal_history_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['personal_history_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Personal History (PMHx)2',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_surgical_history(Request $request)
    {

        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {

                $diagnosis = $request['search_diagnosis_surgical_history'];

                //Saving medications
                foreach ((array)$diagnosis as $key=>$item) {
                    $lab_value = diagnosis_lookup_value::where('diagnosis_lookup_value_id',$item)->pluck('diagnosis_lookup_value');
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '5';
                    $active_record['doc_control_id'] = '9';
                    $active_record['value'] = $lab_value[0];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }

                //Saving comment
                $comment_surgical_history_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','5')
                    ->where('doc_control_id','10')->get();

                if(!count($comment_surgical_history_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '5';
                    $active_record['doc_control_id'] = '10';
                    $active_record['value'] = $request['surgical_history_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_surgical_history_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['surgical_history_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Surgical History2',[$request['patient_id']]);
            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_new_family_member(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }
        if($role == 'Student') {
//            try
//            {

                //Saving family member relation
                $active_record = new active_record();
                $active_record['patient_id'] = $request['patient_id'];
                $active_record['navigation_id'] = '4';
                $active_record['doc_control_id'] = '5';
                $active_record['value'] = $request['relation'];
                $active_record['created_by'] = $request['user_id'];
                $active_record['updated_by'] = $request['user_id'];
                $active_record->save();

                //Saving active record id to group all diagnosis together
                $saved_active_record_id = $active_record->active_record_id;

                //Saving family member status
                $active_record = new active_record();
                $active_record['patient_id'] = $request['patient_id'];
                $active_record['navigation_id'] = '4';
                $active_record['doc_control_id'] = '7';
                $active_record['value'] = $request['family_member_status'];
                $active_record['doc_control_group'] = $saved_active_record_id;
                $active_record['created_by'] = $request['user_id'];
                $active_record['updated_by'] = $request['user_id'];
                $active_record->save();


                //Saving family member's diagnosis
                foreach ($request['diagnosis_list'] as $key=>$list) {
                    $list_value = diagnosis_lookup_value::where('diagnosis_lookup_value_id',$list)->pluck('diagnosis_lookup_value');
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '4';
                    $active_record['doc_control_id'] = '6';
                    $active_record['value'] = $list_value[0];
                    $active_record['doc_control_group'] = $saved_active_record_id;
                    $active_record['doc_control_group_order'] = $key+1;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                    }
                return redirect()->route('Family History (FMHx)2',[$request['patient_id']]);
//                }
//                catch (\Exception $e) {
//                    return view('errors/503');
//                }
        }
        else
        {
            return view('auth/not_authorized');
        }
    }
    public function post_family_history(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {

                //Saving comment
                $comment_family_history_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','4')
                    ->where('doc_control_id','8')->get();

                if(!count($comment_family_history_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '4';
                    $active_record['doc_control_id'] = '8';
                    $active_record['value'] = $request['family_history_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_family_history_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['family_history_comment'];
                    $active_record->save();
                }

                //Now redirecting to orders page
                return redirect()->route('Family History (FMHx)2',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_medications(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                $medications = $request['search_medications'];
                //Saving medications
                foreach ((array)$medications as $key=>$medicine) {
                    $lab_value = med_lookup_value::where('med_lookup_value_id',$medicine)->pluck('med_lookup_value');
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '7';
                    $active_record['doc_control_id'] = '16';
                    $active_record['value'] = $lab_value[0];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_medicine_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','7')
                    ->where('doc_control_id','17')->get();

                if(!count($comment_medicine_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '7';
                    $active_record['doc_control_id'] = '17';
                    $active_record['value'] = $request['medication_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_medicine_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['medication_comment'];
                    $active_record->save();
                }

                //Now redirecting to orders page
                return redirect()->route('Medications',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_vital_signs(Request $request)
{
    $role='';
    if(Auth::check()) {
        $role = Auth::user()->role;
    }         if($role == 'Student') {
    try {
        $active_record = new active_record();
        $active_record['patient_id'] = $request['patient_id'];
        $active_record['navigation_id'] = '8';
        $active_record['doc_control_id'] = '18';
        $active_record['value'] = $request['BP_Systolic'];
        $active_record['created_by'] = $request['user_id'];
        //$active_record['created_at'] = $request['timestamp'];
        $active_record['updated_by'] = $request['user_id'];
        $active_record->save();
        $active_record = new active_record();
        $active_record['patient_id'] = $request['patient_id'];
        $active_record['navigation_id'] = '8';
        $active_record['doc_control_id'] = '19';
        $active_record['value'] = $request['BP_Diastolic'];
        $active_record['created_by'] = $request['user_id'];
        //$active_record['created_at'] = $request['timestamp'];
        $active_record['updated_by'] = $request['user_id'];
        $active_record->save();
        $active_record = new active_record();
        $active_record['patient_id'] = $request['patient_id'];
        $active_record['navigation_id'] = '8';
        $active_record['doc_control_id'] = '20';
        $active_record['value'] = $request['Heart_Rate'];
        $active_record['created_by'] = $request['user_id'];
        //$active_record['created_at'] = $request['timestamp'];
        $active_record['updated_by'] = $request['user_id'];
        $active_record->save();
        $active_record = new active_record();
        $active_record['patient_id'] = $request['patient_id'];
        $active_record['navigation_id'] = '8';
        $active_record['doc_control_id'] = '21';
        $active_record['value'] = $request['Respiratory_Rate'];
        $active_record['created_by'] = $request['user_id'];
        //$active_record['created_at'] = $request['timestamp'];
        $active_record['updated_by'] = $request['user_id'];
        $active_record->save();
        $active_record = new active_record();
        $active_record['patient_id'] = $request['patient_id'];
        $active_record['navigation_id'] = '8';
        $active_record['doc_control_id'] = '22';
        $active_record['value'] = $request['Temperature'] . " " . $request['temperature_unit'];
        $active_record['created_by'] = $request['user_id'];
        //$active_record['created_at'] = $request['timestamp'];
        $active_record['updated_by'] = $request['user_id'];
        $active_record->save();
        $active_record = new active_record();
        $active_record['patient_id'] = $request['patient_id'];
        $active_record['navigation_id'] = '8';
        $active_record['doc_control_id'] = '76';
        $active_record['value'] = $request['Weight'] . " " . $request['weight_unit'];
        $active_record['created_by'] = $request['user_id'];
        //$active_record['created_at'] = $request['timestamp'];
        $active_record['updated_by'] = $request['user_id'];
        $active_record->save();
        $active_record = new active_record();
        $active_record['patient_id'] = $request['patient_id'];
        $active_record['navigation_id'] = '8';
        $active_record['doc_control_id'] = '77';
        $active_record['value'] = $request['Height'] . " " . $request['height_unit'];
        $active_record['created_by'] = $request['user_id'];
        //$active_record['created_at'] = $request['timestamp'];
        $active_record['updated_by'] = $request['user_id'];
        $active_record->save();
        $active_record = new active_record();
        $active_record['patient_id'] = $request['patient_id'];
        $active_record['navigation_id'] = '8';
        $active_record['doc_control_id'] = '23';
        $active_record['value'] = $request['Pain'];
        $active_record['created_by'] = $request['user_id'];
        //$active_record['created_at'] = $request['timestamp'];
        $active_record['updated_by'] = $request['user_id'];
        $active_record->save();
        $active_record = new active_record();
        $active_record['patient_id'] = $request['patient_id'];
        $active_record['navigation_id'] = '8';
        $active_record['doc_control_id'] = '69';
        $active_record['value'] = $request['Oxygen_Saturation'];
        $active_record['created_by'] = $request['user_id'];
        //$active_record['created_at'] = $request['timestamp'];
        $active_record['updated_by'] = $request['user_id'];
        $active_record->save();
        $active_record = new active_record();
        $active_record['patient_id'] = $request['patient_id'];
        $active_record['navigation_id'] = '8';
        $active_record['doc_control_id'] = '24';
        $active_record['value'] = $request['Comments'];
        $active_record['created_by'] = $request['user_id'];
        //$active_record['created_at'] = $request['timestamp'];
        $active_record['updated_by'] = $request['user_id'];
        $active_record->save();
        return redirect()->route('Vital Signs',[$request['patient_id']]);
    }
    catch (\Exception $e)
    {
        return view('errors/503');
    }
}
else {
    return view('auth/not_authorized');
}
}

    //All PE post routes

public function post_gastrointestinal(Request $request)
        {
            $role='';
            if(Auth::check()) {
                $role = Auth::user()->role;
            }

            if($role == 'Student') {
                try {
                    //First deleting all saved symptoms
                    active_record::where('patient_id', $request['patient_id'])
                        ->where('navigation_id','30')->where('doc_control_id','63')->delete();

                    $gastrointestinal_symptoms = $request['$gastrointestinal_symptoms'];

                    //Now saving
                    foreach ((array)$gastrointestinal_symptoms as $key=>$gastrointestinal_symptom) {
                        $active_record = new active_record();
                        $active_record['patient_id'] = $request['patient_id'];
                        $active_record['navigation_id'] = '30';
                        $active_record['doc_control_id'] = '63';
                        $active_record['value'] = $gastrointestinal_symptom;
                        $active_record['created_by'] = $request['user_id'];
                        $active_record['updated_by'] = $request['user_id'];
                        $active_record->save();
                    }
                    //Saving comment
                    $comment_gastrointestinal_record = active_record::where('patient_id', $request['patient_id'])
                        ->where('navigation_id','30')
                        ->where('doc_control_id','64')->get();

                    if(!count($comment_gastrointestinal_record)>0)
                    {
                        $active_record = new active_record();
                        $active_record['patient_id'] = $request['patient_id'];
                        $active_record['navigation_id'] = '30';
                        $active_record['doc_control_id'] = '64';
                        $active_record['value'] = $request['gastrointestinal_comment'];
                        $active_record['created_by'] = $request['user_id'];
                        $active_record['updated_by'] = $request['user_id'];
                        $active_record->save();
                    }
                    else {
                        $active_record = active_record::where('active_record_id', $comment_gastrointestinal_record[0]->active_record_id)->first();
                        $active_record['value'] = $request['gastrointestinal_comment'];
                        $active_record->save();
                    }

                    //Now redirecting to page
                    return redirect()->route('Gastrointestinal20',[$request['patient_id']]);

                } catch (\Exception $e) {
                    return view('errors/503');
                }
            }
            else
            {
                return view('auth/not_authorized');
            }

        }

    public function post_psychological(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','29')->where('doc_control_id','61')->delete();

                $psychological_symptoms = $request['$psychological_symptoms'];

                //Now saving
                foreach ((array)$psychological_symptoms as $key=>$psychological_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '29';
                    $active_record['doc_control_id'] = '61';
                    $active_record['value'] = $psychological_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_psychological_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','29')
                    ->where('doc_control_id','62')->get();

                if(!count($comment_psychological_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '29';
                    $active_record['doc_control_id'] = '62';
                    $active_record['value'] = $request['psychological_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_psychological_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['psychological_comment'];
                    $active_record->save();
                }

                //Now redirecting to orders page
                return redirect()->route('Psychological20',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_neurological(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','28')->where('doc_control_id','59')->delete();

                $neurological_symptoms = $request['$neurological_symptoms'];

                //Now saving
                foreach ((array)$neurological_symptoms as $key=>$neurological_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '28';
                    $active_record['doc_control_id'] = '59';
                    $active_record['value'] = $neurological_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_neurological_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','28')
                    ->where('doc_control_id','60')->get();

                if(!count($comment_neurological_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '28';
                    $active_record['doc_control_id'] = '60';
                    $active_record['value'] = $request['neurological_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_neurological_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['neurological_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Neurological20',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_integumentary(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','27')->where('doc_control_id','57')->delete();

                $integumentary_symptoms = $request['$integumentary_symptoms'];

                //Now saving
                foreach ((array)$integumentary_symptoms as $key=>$integumentary_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '27';
                    $active_record['doc_control_id'] = '57';
                    $active_record['value'] = $integumentary_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_integumentary_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','27')
                    ->where('doc_control_id','58')->get();

                if(!count($comment_integumentary_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '27';
                    $active_record['doc_control_id'] = '58';
                    $active_record['value'] = $request['integumentary_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_integumentary_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['integumentary_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Integumentary20',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_musculoskeletal(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','26')->where('doc_control_id','55')->delete();

                $musculoskeletal_symptoms = $request['$musculoskeletal_symptoms'];

                //Now saving
                foreach ((array)$musculoskeletal_symptoms as $key=>$musculoskeletal_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '26';
                    $active_record['doc_control_id'] = '55';
                    $active_record['value'] = $musculoskeletal_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_musculoskeletal_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','26')
                    ->where('doc_control_id','56')->get();

                if(!count($comment_musculoskeletal_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '26';
                    $active_record['doc_control_id'] = '56';
                    $active_record['value'] = $request['musculoskeletal_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_musculoskeletal_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['musculoskeletal_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Musculoskeletal20',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_cardiovascular(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','25')->where('doc_control_id','53')->delete();

                $cardiovascular_symptoms = $request['$cardiovascular_symptoms'];

                //Now saving
                foreach ((array)$cardiovascular_symptoms as $key=>$cardiovascular_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '25';
                    $active_record['doc_control_id'] = '53';
                    $active_record['value'] = $cardiovascular_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_cardiovascular_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','25')
                    ->where('doc_control_id','54')->get();

                if(!count($comment_cardiovascular_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '25';
                    $active_record['doc_control_id'] = '54';
                    $active_record['value'] = $request['cardiovascular_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_cardiovascular_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['cardiovascular_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Cardiovascular20',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_respiratory(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','24')->where('doc_control_id','51')->delete();

                $respiratory_symptoms = $request['$respiratory_symptoms'];

                //Now saving
                foreach ((array)$respiratory_symptoms as $key=>$respiratory_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '24';
                    $active_record['doc_control_id'] = '51';
                    $active_record['value'] = $respiratory_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_respiratory_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','24')
                    ->where('doc_control_id','52')->get();

                if(!count($comment_respiratory_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '24';
                    $active_record['doc_control_id'] = '52';
                    $active_record['value'] = $request['respiratory_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_respiratory_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['respiratory_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Respiratory20',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_eyes(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','23')->where('doc_control_id','49')->delete();

                $eyes_symptoms = $request['$eyes_symptoms'];

                //Now saving
                foreach ((array)$eyes_symptoms as $key=>$eyes_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '23';
                    $active_record['doc_control_id'] = '49';
                    $active_record['value'] = $eyes_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_eyes_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','23')
                    ->where('doc_control_id','50')->get();

                if(!count($comment_eyes_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '23';
                    $active_record['doc_control_id'] = '50';
                    $active_record['value'] = $request['eyes_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_eyes_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['eyes_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Eyes20',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_HENT(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','22')->where('doc_control_id','47')->delete();

                $HENT_symptoms = $request['$HENT_symptoms'];

                //Now saving
                foreach ((array)$HENT_symptoms as $key=>$HENT_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '22';
                    $active_record['doc_control_id'] = '47';
                    $active_record['value'] = $HENT_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_HENT_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','22')
                    ->where('doc_control_id','48')->get();

                if(!count($comment_HENT_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '22';
                    $active_record['doc_control_id'] = '48';
                    $active_record['value'] = $request['HENT_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_HENT_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['HENT_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('HENT20',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_constitutional(Request $request)
        {
            $role='';
            if(Auth::check()) {
                $role = Auth::user()->role;
            }

            if($role == 'Student') {
                try {
                    //First deleting all saved symptoms
                    active_record::where('patient_id', $request['patient_id'])
                        ->where('navigation_id','21')->where('doc_control_id','45')->delete();

                    $constitutional_symptoms = $request['$constitutional_symptoms'];

                    //Now saving
                    foreach ((array)$constitutional_symptoms as $key=>$constitutional_symptom) {
                        $active_record = new active_record();
                        $active_record['patient_id'] = $request['patient_id'];
                        $active_record['navigation_id'] = '21';
                        $active_record['doc_control_id'] = '45';
                        $active_record['value'] = $constitutional_symptom;
                        $active_record['created_by'] = $request['user_id'];
                        $active_record['updated_by'] = $request['user_id'];
                        $active_record->save();
                    }
                    //Saving comment
                    $comment_constitutional_record = active_record::where('patient_id', $request['patient_id'])
                        ->where('navigation_id','21')
                        ->where('doc_control_id','46')->get();

                    if(!count($comment_constitutional_record)>0)
                    {
                        $active_record = new active_record();
                        $active_record['patient_id'] = $request['patient_id'];
                        $active_record['navigation_id'] = '21';
                        $active_record['doc_control_id'] = '46';
                        $active_record['value'] = $request['constitutional_comment'];
                        $active_record['created_by'] = $request['user_id'];
                        $active_record['updated_by'] = $request['user_id'];
                        $active_record->save();
                    }
                    else {
                        $active_record = active_record::where('active_record_id', $comment_constitutional_record[0]->active_record_id)->first();
                        $active_record['value'] = $request['constitutional_comment'];
                        $active_record->save();
                    }

                    //Now redirecting to page
                    return redirect()->route('Constitutional20',[$request['patient_id']]);

                } catch (\Exception $e) {
                    return view('errors/503');
                }
            }
            else
            {
                return view('auth/not_authorized');
            }

        }

    //All ROS post methods
    public function post_ros_constitutional(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','10')->where('doc_control_id','25')->delete();

                $ros_constitutional_symptoms = $request['$ros_constitutional_symptoms'];

                //Now saving
                foreach ((array)$ros_constitutional_symptoms as $key=>$ros_constitutional_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '10';
                    $active_record['doc_control_id'] = '25';
                    $active_record['value'] = $ros_constitutional_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_ros_constitutional_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','10')
                    ->where('doc_control_id','26')->get();

                if(!count($comment_ros_constitutional_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '10';
                    $active_record['doc_control_id'] = '26';
                    $active_record['value'] = $request['ros_constitutional_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_ros_constitutional_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['ros_constitutional_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Constitutional9',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }

    }
    public function post_ros_hent(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','11')->where('doc_control_id','27')->delete();

                $ros_hent_symptoms = $request['$ros_hent_symptoms'];

                //Now saving
                foreach ((array)$ros_hent_symptoms as $key=>$ros_hent_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '11';
                    $active_record['doc_control_id'] = '27';
                    $active_record['value'] = $ros_hent_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_ros_hent_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','11')
                    ->where('doc_control_id','28')->get();

                if(!count($comment_ros_hent_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '11';
                    $active_record['doc_control_id'] = '28';
                    $active_record['value'] = $request['ros_hent_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_ros_hent_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['ros_hent_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('HENT9',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }
    }
    public function post_ros_eyes(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','12')->where('doc_control_id','29')->delete();

                $ros_eyes_symptoms = $request['$ros_eyes_symptoms'];

                //Now saving
                foreach ((array)$ros_eyes_symptoms as $key=>$ros_eyes_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '12';
                    $active_record['doc_control_id'] = '29';
                    $active_record['value'] = $ros_eyes_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_ros_eyes_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','12')
                    ->where('doc_control_id','30')->get();

                if(!count($comment_ros_eyes_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '12';
                    $active_record['doc_control_id'] = '30';
                    $active_record['value'] = $request['ros_eyes_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_ros_eyes_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['ros_eyes_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Eyes9',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }
    }
    public function post_ros_respiratory(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','13')->where('doc_control_id','31')->delete();

                $ros_respiratory_symptoms = $request['$ros_respiratory_symptoms'];

                //Now saving
                foreach ((array)$ros_respiratory_symptoms as $key=>$ros_respiratory_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '13';
                    $active_record['doc_control_id'] = '31';
                    $active_record['value'] = $ros_respiratory_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_ros_respiratory_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','13')
                    ->where('doc_control_id','32')->get();

                if(!count($comment_ros_respiratory_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '13';
                    $active_record['doc_control_id'] = '32';
                    $active_record['value'] = $request['ros_respiratory_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_ros_respiratory_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['ros_respiratory_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Respiratory9',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }
    }
    public function post_ros_cardiovascular(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','14')->where('doc_control_id','33')->delete();

                $ros_cardiovascular_symptoms = $request['$ros_cardiovascular_symptoms'];

                //Now saving
                foreach ((array)$ros_cardiovascular_symptoms as $key=>$ros_cardiovascular_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '14';
                    $active_record['doc_control_id'] = '33';
                    $active_record['value'] = $ros_cardiovascular_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_ros_cardiovascular_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','14')
                    ->where('doc_control_id','34')->get();

                if(!count($comment_ros_cardiovascular_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '14';
                    $active_record['doc_control_id'] = '34';
                    $active_record['value'] = $request['ros_cardiovascular_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_ros_cardiovascular_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['ros_cardiovascular_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Cardiovascular9',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }
    }
    public function post_ros_musculoskeletal(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','15')->where('doc_control_id','35')->delete();

                $ros_musculoskeletal_symptoms = $request['$ros_musculoskeletal_symptoms'];

                //Now saving
                foreach ((array)$ros_musculoskeletal_symptoms as $key=>$ros_musculoskeletal_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '15';
                    $active_record['doc_control_id'] = '35';
                    $active_record['value'] = $ros_musculoskeletal_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_ros_musculoskeletal_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','15')
                    ->where('doc_control_id','36')->get();

                if(!count($comment_ros_musculoskeletal_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '15';
                    $active_record['doc_control_id'] = '36';
                    $active_record['value'] = $request['ros_musculoskeletal_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_ros_musculoskeletal_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['ros_musculoskeletal_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Musculoskeletal9',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }
    }
    public function post_ros_integumentary(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','16')->where('doc_control_id','37')->delete();

                $ros_integumentary_symptoms = $request['$ros_integumentary_symptoms'];

                //Now saving
                foreach ((array)$ros_integumentary_symptoms as $key=>$ros_integumentary_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '16';
                    $active_record['doc_control_id'] = '37';
                    $active_record['value'] = $ros_integumentary_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_ros_integumentary_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','16')
                    ->where('doc_control_id','38')->get();

                if(!count($comment_ros_integumentary_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '16';
                    $active_record['doc_control_id'] = '38';
                    $active_record['value'] = $request['ros_integumentary_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_ros_integumentary_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['ros_integumentary_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Integumentary9',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }
    }
    public function post_ros_neurological(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','17')->where('doc_control_id','39')->delete();

                $ros_neurological_symptoms = $request['$ros_neurological_symptoms'];

                //Now saving
                foreach ((array)$ros_neurological_symptoms as $key=>$ros_neurological_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '17';
                    $active_record['doc_control_id'] = '39';
                    $active_record['value'] = $ros_neurological_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_ros_neurological_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','17')
                    ->where('doc_control_id','40')->get();

                if(!count($comment_ros_neurological_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '17';
                    $active_record['doc_control_id'] = '40';
                    $active_record['value'] = $request['ros_neurological_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_ros_neurological_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['ros_neurological_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Neurological9',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }
    }
    public function post_ros_psychological(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','18')->where('doc_control_id','41')->delete();

                $ros_psychological_symptoms = $request['$ros_psychological_symptoms'];

                //Now saving
                foreach ((array)$ros_psychological_symptoms as $key=>$ros_psychological_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '18';
                    $active_record['doc_control_id'] = '41';
                    $active_record['value'] = $ros_psychological_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_ros_psychological_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','18')
                    ->where('doc_control_id','42')->get();

                if(!count($comment_ros_psychological_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '18';
                    $active_record['doc_control_id'] = '42';
                    $active_record['value'] = $request['ros_psychological_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_ros_psychological_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['ros_psychological_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Psychological9',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }
    }

    public function post_ros_gastrointestinal(Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }

        if($role == 'Student') {
            try {
                //First deleting all saved symptoms
                active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','19')->where('doc_control_id','43')->delete();

                $ros_gastrointestinal_symptoms = $request['$ros_gastrointestinal_symptoms'];

                //Now saving
                foreach ((array)$ros_gastrointestinal_symptoms as $key=>$ros_gastrointestinal_symptom) {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '19';
                    $active_record['doc_control_id'] = '43';
                    $active_record['value'] = $ros_gastrointestinal_symptom;
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                //Saving comment
                $comment_ros_gastrointestinal_record = active_record::where('patient_id', $request['patient_id'])
                    ->where('navigation_id','19')
                    ->where('doc_control_id','44')->get();

                if(!count($comment_ros_gastrointestinal_record)>0)
                {
                    $active_record = new active_record();
                    $active_record['patient_id'] = $request['patient_id'];
                    $active_record['navigation_id'] = '19';
                    $active_record['doc_control_id'] = '44';
                    $active_record['value'] = $request['ros_gastrointestinal_comment'];
                    $active_record['created_by'] = $request['user_id'];
                    $active_record['updated_by'] = $request['user_id'];
                    $active_record->save();
                }
                else {
                    $active_record = active_record::where('active_record_id', $comment_ros_gastrointestinal_record[0]->active_record_id)->first();
                    $active_record['value'] = $request['ros_gastrointestinal_comment'];
                    $active_record->save();
                }

                //Now redirecting to page
                return redirect()->route('Gastrointestinal9',[$request['patient_id']]);

            } catch (\Exception $e) {
                return view('errors/503');
            }
        }
        else
        {
            return view('auth/not_authorized');
        }
    }

    public function post_assignInstructor(Request $request)
        {
            $role='';
            if(Auth::check()) {
                $role = Auth::user()->role;
            }
            if ($role == 'Student')
            {
                 $messages = ['required' => 'Please assign atleast one instructor.'];
                
                  //Validating input data
                $this->validate($request, [                    
                    'search_instructors' => 'required',
               ],$messages);
                
                $student_id = Auth::user()->id;
                $users_patient = users_patient::where('patient_id', $request['patient_id'])->where('user_id', Auth::user()->id)->first();
                DB::table('users_patient')->where('patient_id', $request['patient_id'])->where('user_id', Auth::user()->id)->update(['patient_record_status_id' => '2']);
                $instructors = $request['search_instructors'];
                foreach ((array)$instructors as $instructor)
                {
                    $splitName = explode(' ', $instructor, 2);
                    $firstname = $splitName[0];
                    $lastname = $splitName[1];
                    $instructor_id = User::where('firstname', $firstname)->where('lastname', $lastname)->where('role', 'Instructor')->first();
                    $users_patient['patient_record_status_id'] = '2';
                    $users_patient['patient_id'] = $request['patient_id'];
                    $users_patient['user_id'] = $instructor_id['id'];
                    DB::table('users_patient')->insert([
                        'patient_record_status_id' => '2',
                        'patient_id' => $request['patient_id'],
                        'user_id' => $instructor_id['id'],
                        'created_by' => $student_id,
                        'updated_by' => $student_id,
                        'updated_at' => Carbon\Carbon::now('CDT')
                    ]);
                }
                patient::where('patient_id', $request['patient_id'])->update(array('completed_flag' => true));
                patient::where('patient_id', $request['patient_id'])->update(array('submitted_date' => Carbon\Carbon::now('CDT')->format('m-d-Y')));

                return redirect()->route('student.home');
            }
            else
            {
                return view('auth/not_authorized');
            }
        }
    public function post_MDM(Request$request){
            $role='';
            if(Auth::check()) {
                $role = Auth::user()->role;
            }
            if($role == 'Student') {
                try {
                    //Saving MDM
                    $MDM_record = active_record::where('patient_id', $request['patient_id'])
                        ->where('navigation_id','33')
                        ->where('doc_control_id','65')->get();
                    if(!count($MDM_record)>0)
                    {
                        $active_record = new active_record();
                        $active_record['patient_id'] = $request['patient_id'];
                        $active_record['navigation_id'] = '33';
                        $active_record['doc_control_id'] = '65';
                        $active_record['value'] = $request['MDM'];
                        $active_record['created_by'] = $request['user_id'];
                        $active_record['updated_by'] = $request['user_id'];
                        $active_record->save();
                    }
                    else {
                        $active_record = active_record::where('active_record_id', $MDM_record[0]->active_record_id)->first();
                        $active_record['value'] = $request['MDM'];
                        $active_record->save();
                    }
                    //Now redirecting to page
                    return redirect()->route('MDM/Plan',[$request['patient_id']]);
                } catch (\Exception $e) {
                    return view('errors/503');
                }
            }
            else
            {
                return view('auth/not_authorized');
            }
        }
    public function post_disposition(Request $request)
        {
            $role='';
            if(Auth::check()) {
                $role = Auth::user()->role;
            }

            if($role == 'Student') {

                //Validating input data
                $this->validate($request, [
                    'disposition' => 'required'
                ]);

                try {
                    //Saving Disposition
                    $disposition_record = active_record::where('patient_id', $request['patient_id'])
                        ->where('navigation_id','34')
                        ->where('doc_control_id','67')->get();

                    if(!count($disposition_record)>0)
                    {
                        $active_record = new active_record();
                        $active_record['patient_id'] = $request['patient_id'];
                        $active_record['navigation_id'] = '34';
                        $active_record['doc_control_id'] = '67';
                        $active_record['value'] = $request['disposition'];
                        $active_record['created_by'] = $request['user_id'];
                        $active_record['updated_by'] = $request['user_id'];
                        $active_record->save();
                    }
                    else {
                        $active_record = active_record::where('active_record_id', $disposition_record[0]->active_record_id)->first();
                        $active_record['value'] = $request['disposition'];
                        $active_record->save();
                    }

                    //Saving comment
                    $comment_disposition_record = active_record::where('patient_id', $request['patient_id'])
                        ->where('navigation_id','34')
                        ->where('doc_control_id','68')->get();

                    if(!count($comment_disposition_record)>0)
                    {
                        $active_record = new active_record();
                        $active_record['patient_id'] = $request['patient_id'];
                        $active_record['navigation_id'] = '34';
                        $active_record['doc_control_id'] = '68';
                        $active_record['value'] = $request['disposition_comment'];
                        $active_record['created_by'] = $request['user_id'];
                        $active_record['updated_by'] = $request['user_id'];
                        $active_record->save();
                    }
                    else {
                        $active_record = active_record::where('active_record_id', $comment_disposition_record[0]->active_record_id)->first();
                        $active_record['value'] = $request['disposition_comment'];
                        $active_record->save();
                    }

                    //Now redirecting to page
                    return redirect()->route('Disposition',[$request['patient_id']]);

                } catch (\Exception $e) {
                    return view('errors/503');
                }
            }
            else
            {
                return view('auth/not_authorized');
            }

        }

    //All delete methods

    public function delete_vital_signs($ts, Request $request)
    {
        $role='';
        if(Auth::check()) {
            $role = Auth::user()->role;
        }         if($role == 'Student') {
        try {
            active_record::where('created_at',$ts)->where('navigation_id', '8')->where('doc_control_id','18')->delete();
            active_record::where('created_at',$ts)->where('navigation_id', '8')->where('doc_control_id','19')->delete();
            active_record::where('created_at',$ts)->where('navigation_id', '8')->where('doc_control_id','20')->delete();
            active_record::where('created_at',$ts)->where('navigation_id', '8')->where('doc_control_id','21')->delete();
            active_record::where('created_at',$ts)->where('navigation_id', '8')->where('doc_control_id','22')->delete();
            active_record::where('created_at',$ts)->where('navigation_id', '8')->where('doc_control_id','23')->delete();
            active_record::where('created_at',$ts)->where('navigation_id', '8')->where('doc_control_id','24')->delete();
            active_record::where('created_at',$ts)->where('navigation_id', '8')->where('doc_control_id','69')->delete();
            active_record::where('created_at',$ts)->where('navigation_id', '8')->where('doc_control_id','76')->delete();
            active_record::where('created_at',$ts)->where('navigation_id', '8')->where('doc_control_id','77')->delete();

            return redirect()->route('Vital Signs',[$request['patient_id']]);
        }
        catch (\Exception $e)
        {
            return view('errors/503');
        }
    }
    else {
        return view('auth/not_authorized');
    }
    }
    public function delete_personal_history($id)
    {
        $record = active_record::find($id);
        $patient_id = $record->patient_id;
        $record->delete();
        //Now redirecting back to the orders page
        return redirect()->route('Personal History (PMHx)2',$patient_id);
    }
    public function delete_family_history($id)
    {
        $record = active_record::find($id);
        $patient_id = $record->patient_id;
        $record->delete();
        //Now redirecting back to the orders page
        return redirect()->route('Family History (FMHx)2',$patient_id);
    }

    public function delete_surgical_history($id)
    {
        $record = active_record::find($id);
        $patient_id = $record->patient_id;
        $record->delete();
        //Now redirecting back to the orders page
        return redirect()->route('Surgical History2',$patient_id);
    }
    public function delete_medication($id)
    {
        $med = active_record::find($id);
        $patient_id = $med->patient_id;
        $med->delete();
        return redirect()->route('Medications',$patient_id);
    }
    public function delete_image_order($id)
    {
        $image = active_record::find($id);
        $patient_id = $image->patient_id;
        $image->delete();
        //Now redirecting back to the orders page
        return redirect()->route('Orders',$patient_id);
    }
    public function delete_lab_order($id)
    {
        $lab = active_record::find($id);
        $patient_id = $lab->patient_id;
        $lab->delete();
        return redirect()->route('Orders',$patient_id);
    }
}
