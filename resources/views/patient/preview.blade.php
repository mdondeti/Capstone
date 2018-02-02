<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>WeChart</title>
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div class="container-fluid">
    <!--This is a container for vital signs header -->
    <div class="row" >
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-3">
                    <label style="float: left">Instructor: </label>
                    @foreach ($instructor_Details as $key=>$instructor_Detail)
                        @if(count($instructor_Detail)>0)
                            <label>{{ $instructor_Detail[0]->firstname}} {{ $instructor_Detail[0]->lastname}}</label>
                            <br>
                        @endif
                    @endforeach
                </div>
                <div class="col-md-6">
                    <h3 id="patient_active_record" align="center" style="margin-top: 0;"><b>Patient Active Record</b></h3>
                </div>
                <div class="col-md-3">
                    @if(count($student_details) > 0)
                        <label style="float: right">Student: {{$student_details[0]->firstname}} {{$student_details[0]->lastname}}</label>
                    @endif
                   <br>
                        <label style="float: right">Date: {{$patient->submitted_date}} </label>
                </div>
            </div>
        </div>
        <div class="panel-body" style="margin-bottom: 0;padding-bottom: 0;background-color: #FFFAF0;margin-top: 0;padding-top: 0">
            <table class="table" style=" margin-top: 0;padding-top: 0;margin-bottom: 0;padding-bottom: 0">
                <!--This is the first row in the vital signs panel -->
                <tr style="padding-top: 0;padding-bottom: 0%; border-style: hidden">
                    <td style="padding-top: 0;padding-bottom: 0%">
                        <p id="name_label" style="align-self: center"><strong>Patient Name:</strong>
                            {{$vital_signs_header->name}}
                        </p>
                    </td>
                    <td style="padding-top: 0;padding-bottom: 0%">
                        <p id="age_label"><strong>Patient Age: </strong>
                            {{$vital_signs_header->age}}
                        </p>
                    </td>
                    <td style="padding-top: 0;padding-bottom: 0%">
                        <p id="sex_label"><strong>Patient Sex: </strong>
                            {{$vital_signs_header->gender}}
                        </p>
                    </td>
                    <td style="padding-top: 0;padding-bottom: 0%">
                        <p id="room_number_label"> <strong>Room No: </strong>
                            {{$vital_signs_header->room_number}}</p>
                    </td>
                </tr>
                <!--This is the second row in the vital signs panel -->
                <tr style="padding-top: 0;padding-bottom: 0%; border-style: hidden">
                    <td style="padding-top: 0%;padding-bottom: 0%">
                        <p id="visit_date_label"><strong>Visit Date: </strong>
                            {{$vital_signs_header->visit_date}}</p>
                    </td>
                    <td style="padding-top: 0;padding-bottom: 0%">
                        <p id="RR_label" style="align-self: center"><strong>Respiratory Rate (RR):</strong>
                            @foreach($vital_signs_header->respiratory_rate as $key=>$respiratory_rate)
                                @if($respiratory_rate != null)
                                    {{$vital_signs_header->respiratory_rate[$key]}}
                                    @break
                                @endif
                            @endforeach
                        </p>
                    </td>
                    <td style="padding-top: 0%;padding-bottom: 0%">
                        <p id="temperature_label"><strong>Temperature: </strong>
                            @foreach($vital_signs_header->temperature as $key=>$temperature)
                                @if($temperature != ' ')
                                    {{$vital_signs_header->temperature[$key]}}
                                    @break
                                @endif
                            @endforeach
                        </p>
                    </td>
                    <td style="padding-top: 0%;padding-bottom: 0%">
                        <p id="oxygen_saturation_label"><strong>O<sub>2</sub> Sat: </strong>
                            @foreach($vital_signs_header->oxygen_saturation as $key=>$oxygen_saturation)
                                @if($oxygen_saturation != null)
                                    {{$vital_signs_header->oxygen_saturation[$key]}}
                                    @break
                                @endif
                            @endforeach
                        </p>
                    </td>
                </tr>
                <!--This is the third row in the vital signs panel -->
                <tr style="padding-top: 0;padding-bottom: 0%; border-style: hidden">
                    <td style="padding-top: 0;padding-bottom: 0%">
                        <p id="bp_systolic_label" style="align-self: center"><strong>Blood Pressure (BP) Systolic: </strong>
                            @foreach($vital_signs_header->BP_systolic as $key=>$BP_systolic)
                                @if($BP_systolic != null)
                                    {{$vital_signs_header->BP_systolic[$key]}}
                                    @break
                                @endif
                            @endforeach
                        </p>
                    </td>
                    <td style="padding-top: 0%;padding-bottom: 0%">
                        <p id="bp_diastolic_label"><strong>Blood Pressure (BP) Diastolic: </strong>
                            @foreach($vital_signs_header->BP_diastolic as $key=>$BP_diastolic)
                                @if($BP_diastolic != null)
                                    {{$vital_signs_header->BP_diastolic[$key]}}
                                    @break
                                @endif
                            @endforeach
                        </p>
                    </td>
                    <td style="padding-top: 0%;padding-bottom: 0%">
                        <p id="hr_label"><strong>Heart Rate (HR): </strong>
                            @foreach($vital_signs_header->heart_rate as $key=>$heart_rate)
                                @if($heart_rate != null)
                                    {{$vital_signs_header->heart_rate[$key]}}
                                    @break
                                @endif
                            @endforeach
                        </p>
                    </td>
                    <td style="padding-top: 0%;padding-bottom: 0%">
                        <p id="pain_label"><strong>Pain (0/10):  </strong>
                            @foreach($vital_signs_header->pain as $key=>$pain)
                                @if($pain != null)
                                    {{$vital_signs_header->pain[$key]}}
                                    @break
                                @endif
                            @endforeach
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    {{--HPI--}}
    <div class="row">
        <div class="panel panel-default">
        <div class="panel-heading" style="background-color: lightblue">
            <a data-toggle="collapse" href="#HPI">HPI</a>
        </div>
        <div class="panel-body" id="HPI" class="panel-collapse collapse in ">
            @if(count($HPI)>0)
                <p>{{$HPI[0]->value}}</p>
            @endif
        </div>
    </div>
    </div>
    {{--Medical History--}}
    <div class="row">
        <div class="panel panel-default">
        <div class="panel-heading" style="background-color: lightblue">
            <a data-toggle="collapse" href="#medical_history">Medical History</a>
        </div>
        <div class="panel-body" id="medical_history" class="panel-collapse collapse in ">
            {{--Personal History--}}
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr class="bg-info">
                    <th colspan="2">Personal History</th>
                </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <p><strong>List of Diagnosis: </strong><br>
                                @foreach ($diagnosis_list_personal_history as $diagnosis)
                                    <br>
                                   * <?php echo ($diagnosis->value); ?>
                                @endforeach
                            </p>
                            <p><strong>Comments:</strong>
                                @if(count($personal_history_comment)>0)
                                    {{$personal_history_comment[0]->value}}
                                @endif
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
            {{--Family History--}}
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr class="bg-info">
                        <th colspan="6">Family History</th>
                    </tr>
                    <tr>
                        <th>Relation</th>
                        <th>Alive?</th>
                        <th>List of Diagnosis</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($family_members_details as $family_member_details)
                    <tr>
                        <td><p><?php echo ($family_member_details->relation); ?></p></td>
                        <td>
                            @if(count($family_member_details->status)>0)
                                <p><?php echo ($family_member_details->status[0]); ?></p>
                            @endif
                        </td>
                        <td colspan="10">
                            @foreach ($family_member_details->diagnosis as $family_member_diagnosis)
                                <table>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <p><?php echo ($family_member_diagnosis); ?></p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3">
                        <p><strong>Comments: </strong>
                            @if(count($comment_family_history) > 0)
                                {{$comment_family_history[0]}}
                            @endif
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
            {{--Surgical History --}}
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr class="bg-info">
                    <th colspan="2">Surgical History</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <p><strong>List of Diagnosis: </strong><br>
                            @foreach ($diagnosis_list_surgical_history as $diagnosis)
                                * <?php echo ($diagnosis->value); ?><br>
                            @endforeach
                        </p>
                        <p><strong>Comments:</strong>
                            @if(count($surgical_history_comment)>0)
                                {{$surgical_history_comment[0]->value}}
                            @endif
                        </p>
                    </td>
                </tr>
               </tbody>
            </table>
            {{--Social History--}}
            <table class="table table-striped table-bordered table-hover">
                <thead>
                <tr class="bg-info">
                    <th colspan="8">Social History</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>
                        <label id="smoke_tobacco">Smoke Tobacco?: </label>
                        @if($social_history_smoke_tobacco == "YES")
                            <label id="smoke_tobacco">Yes </label>
                        @else
                            <label id="smoke_tobacco">No </label>
                        @endif
                    </td>
                    <td>
                        <label id="non_smoke_tobacco">Non-Smoke Tobacco?: </label>
                        @if($social_history_non_smoke_tobacco == "YES")
                            <label id="non_smoke_tobacco">Yes </label>
                        @else
                            <label id="non_smoke_tobacco">No </label>
                        @endif
                    </td>
                    <td >
                        <label id="alcohol">Drink Alcohol?: </label>
                        @if($social_history_alcohol == "YES")
                            <label id="alcohol">Yes </label>
                        @else
                            <label id="alcohol">No </label>
                        @endif
                    </td>
                    <td >
                        <label id="sexual_activity">Sexual Activity?: </label>
                        @if($social_history_sexual_activity == "YES")
                            <label id="sexual_activity">Yes </label>
                        @else
                            <label id="sexual_activity">No </label>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="8">
                        <p><strong>Comments:</strong> {{$social_history_comment}}
                        </p>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    {{--Medications--}}
    <div class="row">
        <div class="panel panel-default">
                <div class="panel-heading" style="background-color: lightblue">
                        <a data-toggle="collapse" href="#medications">Medications</a>
                </div>
                <div class="panel-body" id="medications" class="panel-collapse collapse in">
                     <p>
                        <strong>List of medications: </strong><br>
                        @foreach ($medications as $medicine)
                                * {{$medicine->value}}<br>
                        @endforeach
                     </p>
                    <p>
                        <strong>Comments:</strong>
                        @if(count($medication_comment)>0)
                            {{$medication_comment[0]->value}}
                        @endif
                    </p>
                </div>
        </div>
    </div>
    {{--Vital signs--}}
    <div class="row">
        <table class="table table-striped table-bordered table-hover" id="vital_signs_table">
        <thead>
        <tr>
            <th style="background-color: lightblue" colspan="12">
                <a data-toggle="collapse" href="#vital_signs">Vital Signs</a>
            </th>
        </tr>
        <tr class="bg-info">
            <th>Timestamp</th>
            <th>BP Systolic</th>
            <th>BP Diastolic</th>
            <th>Heart Rate</th>
            <th>Respiratory Rate</th>
            <th>Temperature</th>
            <th>Weight</th>
            <th>Height</th>
            <th>Pain (0/10)</th>
            <th>O<sub>2</sub> Sat</th>
            <th>Comment</th>
        </tr>
        </thead>
        <tbody id="vital_signs" class="panel-collapse collapse in">
        {{--Checking for no records--}}
        @if(!count($vital_sign_details)> 0)
            <tr>
                <td colspan="12" style="text-align: center">
                    <br>
                    <b>There are no vital signs.</b>
                    <br>
                </td>
            </tr>
        @else
            @foreach ($vital_sign_details as $vs)
                <tr>
                    <td>
                        {{ $vs->timestamp }}
                    </td>
                    <td>
                        @if(count($vs->BP_Systolic)>0)
                            {{ $vs->BP_Systolic[0] }}
                        @endif
                    </td>
                    <td>
                        @if(count($vs->BP_Diastolic)>0)
                            {{$vs->BP_Diastolic[0]}}
                        @endif
                    </td>
                    <td>
                        @if(count($vs->Heart_Rate)>0)
                            {{$vs->Heart_Rate[0]}}
                        @endif
                    </td>
                    <td>
                        @if(count($vs->Respiratory_Rate)>0)
                            {{$vs->Respiratory_Rate[0]}}
                        @endif
                    </td>
                    <td>
                        @if(count($vs->Temperature)>0)
                            {{$vs->Temperature[0]}}
                        @endif
                    </td>
                    <td>
                        @if(count($vs->Weight)>0)
                            {{$vs->Weight[0]}}
                        @endif
                    </td>
                    <td>
                        @if(count($vs->Height)>0)
                            {{$vs->Height[0]}}
                        @endif
                    </td>
                    <td>
                        @if(count($vs->Pain)>0)
                            {{$vs->Pain[0]}}
                        @endif
                    </td>
                    <td>
                        @if(count($vs->Oxygen_Saturation)>0)
                            {{$vs->Oxygen_Saturation[0]}}
                        @endif
                    </td>
                    <td>
                        @if(count($vs->Comment)>0)
                            {{$vs->Comment[0]}}
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>
    </table>
    </div>
    {{--ROS--}}
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: lightblue">
                <a data-toggle="collapse" href="#ros">ROS</a>
            </div>
            <div class="panel-body" id="ros" class="panel-collapse collapse in">
                {{--ros_constitutional--}}
                <div class="panel panel-default" id="constitutional">
                        <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                            <p style="margin-top: 0">ROS- Constitutional</p>
                        </div>
                        <div class="panel-body" style="padding-bottom: 0">
                                    <p>
                                        <strong>Symptoms: </strong><br>
                                        @foreach ($ros_constitutional_symptoms as $ros_constitutional_symptom)

                                                @if($ros_constitutional_symptom->is_saved)
                                                      * {{$ros_constitutional_symptom->value}}<br>
                                                @endif

                                        @endforeach
                                    </p>
                                    <p>
                                        <strong> Comments:</strong>
                                        @if(count($ros_constitutional_comment)>0)
                                            {{$ros_constitutional_comment[0]}}
                                        @endif
                                    </p>
                           </div>
                </div>
                {{--ros_hent--}}
                <div class="panel panel-default" id="hent">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">ROS- HENT</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($ros_hent_symptoms as $ros_hent_symptom)
                                @if($ros_hent_symptom->is_saved)
                                   * {{$ros_hent_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($ros_hent_comment)>0)
                                {{$ros_hent_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--ros_eyes--}}
                <div class="panel panel-default" id="eyes">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">ROS- Eyes</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($ros_eyes_symptoms as $ros_eyes_symptom)
                                @if($ros_eyes_symptom->is_saved)
                                    * {{$ros_eyes_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($ros_eyes_comment)>0)
                                {{$ros_eyes_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--ros_respiratory--}}
                <div class="panel panel-default" id="respiratory">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">ROS- Respiratory</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($ros_respiratory_symptoms as $ros_respiratory_symptom)
                                @if($ros_respiratory_symptom->is_saved)
                                    * {{$ros_respiratory_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($ros_respiratory_comment)>0)
                                {{$ros_respiratory_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--ros_cardiovascular--}}
                <div class="panel panel-default" id="cardiovascular">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">ROS- Cardiovascular</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($ros_cardiovascular_symptoms as $ros_cardiovascular_symptom)
                                @if($ros_cardiovascular_symptom->is_saved)
                                  * {{$ros_cardiovascular_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($ros_cardiovascular_comment)>0)
                                {{$ros_cardiovascular_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--ros_musculosketal--}}
                <div class="panel panel-default" id="musculoskeletal">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">ROS- Musculoskeletal </p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($ros_musculoskeletal_symptoms as $ros_musculoskeletal_symptom)
                                @if($ros_musculoskeletal_symptom->is_saved)
                                  * {{$ros_musculoskeletal_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($ros_musculoskeletal_comment)>0)
                                {{$ros_musculoskeletal_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--ros_integumentary--}}
                <div class="panel panel-default" id="integumentary">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">ROS- Integumentary</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($ros_integumentary_symptoms as $ros_integumentary_symptom)
                                @if($ros_integumentary_symptom->is_saved)
                                    * {{$ros_integumentary_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($ros_integumentary_comment)>0)
                                {{$ros_integumentary_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--ros_neurological--}}
                <div class="panel panel-default" id="eyes">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">ROS- Neurological</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($ros_neurological_symptoms as $ros_neurological_symptom)
                                @if($ros_neurological_symptom->is_saved)
                                    * {{$ros_neurological_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($ros_neurological_comment)>0)
                                {{$ros_neurological_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--ros_psychological--}}
                <div class="panel panel-default" id="psychological">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">ROS- Psychological</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($ros_psychological_symptoms as $ros_psychological_symptom)
                                @if($ros_psychological_symptom->is_saved)
                                    * {{$ros_psychological_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($ros_psychological_comment)>0)
                                {{$ros_psychological_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--PE--}}
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: lightblue">
                <a data-toggle="collapse" href="#pe">PE</a>
            </div>
            <div class="panel-body" id="pe" class="panel-collapse collapse in">
                {{--PE_constitutional--}}
                <div class="panel panel-default" id="pe_constitutional">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">PE- Constitutional</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($constitutional_symptoms as $constitutional_symptom)

                                @if($constitutional_symptom->is_saved)
                                   * {{$constitutional_symptom->value}}<br>
                                @endif

                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($constitutional_comment)>0)
                                {{$constitutional_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--pe_hent--}}
                <div class="panel panel-default" id="pe_hent">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">PE- HENT</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($hent_symptoms as $hent_symptom)
                                @if($hent_symptom->is_saved)
                                   * {{$hent_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($hent_comment)>0)
                                {{$hent_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--pe_eyes--}}
                <div class="panel panel-default" id="pe_eyes">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">PE- Eyes</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($eyes_symptoms as $eyes_symptom)
                                @if($eyes_symptom->is_saved)
                                    * {{$eyes_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($eyes_comment)>0)
                                {{$eyes_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--pe_respiratory--}}
                <div class="panel panel-default" id="pe_respiratory">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">PE- Respiratory</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($respiratory_symptoms as $respiratory_symptom)
                                @if($respiratory_symptom->is_saved)
                                    * {{$respiratory_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($respiratory_comment)>0)
                                {{$respiratory_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--cardiovascular--}}
                <div class="panel panel-default" id="pe_cardiovascular">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">PE- Cardiovascular</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($cardiovascular_symptoms as $cardiovascular_symptom)
                                @if($cardiovascular_symptom->is_saved)
                                    * {{$cardiovascular_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($cardiovascular_comment)>0)
                                {{$cardiovascular_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--musculosketal--}}
                <div class="panel panel-default" id="pe_musculoskeletal">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">PE- Musculoskeletal </p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($musculoskeletal_symptoms as $musculoskeletal_symptom)
                                @if($musculoskeletal_symptom->is_saved)
                                    * {{$musculoskeletal_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($musculoskeletal_comment)>0)
                                {{$musculoskeletal_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--integumentary--}}
                <div class="panel panel-default" id="pe_integumentary">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">PE- Integumentary</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($integumentary_symptoms as $integumentary_symptom)
                                @if($integumentary_symptom->is_saved)
                                   * {{$integumentary_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($integumentary_comment)>0)
                                {{$integumentary_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--neurological--}}
                <div class="panel panel-default" id="pe_eyes">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">PE- Neurological</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($neurological_symptoms as $neurological_symptom)
                                @if($neurological_symptom->is_saved)
                                   * {{$neurological_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($neurological_comment)>0)
                                {{$neurological_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
                {{--psychological--}}
                <div class="panel panel-default" id="pe_psychological">
                    <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                        <p style="margin-top: 0">PE- Psychological</p>
                    </div>
                    <div class="panel-body" style="padding-bottom: 0">
                        <p>
                            <strong>Symptoms: </strong><br>
                            @foreach ($psychological_symptoms as $psychological_symptom)
                                @if($psychological_symptom->is_saved)
                                    * {{$psychological_symptom->value}}<br>
                                @endif
                            @endforeach
                        </p>
                        <p>
                            <strong> Comments:</strong>
                            @if(count($psychological_comment)>0)
                                {{$psychological_comment[0]}}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--Orders--}}
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: lightblue">
                <a data-toggle="collapse" href="#orders">Orders</a>
            </div>
            <div class="panel-body" id="orders" class="panel-collapse collapse in">
                <p>
                    <strong>List of labs: </strong><br>
                    @foreach ($labs as $lab)
                        * {{$lab->value}}<br>
                    @endforeach
                </p>
                <p>
                    <strong>List of Images: </strong><br>
                    @foreach ($images as $image)
                       * {{$image->value}}<br>
                    @endforeach
                </p>
                <p><strong>Comments: </strong>
                    @if(count($comment_order)>0)
                        {{$comment_order[0]->value}}
                    @endif
                </p>
            </div>
        </div>
    </div>
    {{--Results--}}
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                <a data-toggle="collapse" href="#results">Results</a>
            </div>
            <div class="panel-body " id="results" class="panel-collapse collapse in">
                    @if(count($results)>0)
                        {{$results[0]->value}}
                    @endif
            </div>
        </div>
    </div>
    {{--MDM/Plan--}}
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                <a data-toggle="collapse" href="#mdm">MDM/Plan</a>
            </div>
            <div class="panel-body " id="mdm" class="panel-collapse collapse in">
                @if(count($mdm)>0)
                    {{$mdm[0]->value}}
                @endif
            </div>
        </div>
    </div>
    {{--Disposition--}}
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                <a data-toggle="collapse" href="#disposition">Disposition</a>
            </div>
            <div class="panel-body " id="disposition" class="panel-collapse collapse in">
                <p><strong>Status: </strong>
                    @if(count($disposition_value)>0)
                        {{$disposition_value[0]}}
                    @endif
                </p>
                <p><strong>Comments: </strong>
                    @if(count($disposition_comment)>0)
                        {{$disposition_comment[0]}}
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

<?php
set_time_limit(0);
?>

</body>
</html>