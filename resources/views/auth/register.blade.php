@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="padding-bottom: 0;padding-top: 0">
                        <h3 >Register</h3>
                </div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block" >
                                        <strong id="emailidalert">{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Password<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block" >
                                        <strong id="passwordalert">{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label">Confirm Password<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                          <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
                            <label for="firstname" class="col-md-4 control-label">First Name<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" required autofocus>

                                @if ($errors->has('firstname'))
                                    <span class="help-block" >
                                        <strong id="firstnamealert">{{ $errors->first('firstname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
                            <label for="lastname" class="col-md-4 control-label">Last Name<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                                <input id="lastname" type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" required autofocus>

                                @if ($errors->has('lastname'))
                                    <span class="help-block" >
                                        <strong id="lastnamealert">{{ $errors->first('lastname') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('contactno') ? ' has-error' : '' }}">
                            <label for="contactno" class="col-md-4 control-label">Contact Number</label>

                            <div class="col-md-6">
                                <input id="contactno" type="text" class="form-control" name="contactno" value="{{ old('contactno') }}">

                                @if ($errors->has('contactno'))
                                    <span class="help-block" >
                                        <strong id="contactnoalert">{{ $errors->first('contactno') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('role') ? ' has-error' : '' }}">
                            <label for="role" class="col-md-4 control-label">Role<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                            <input type="radio" class="form-check-input inline" name="role" value="Student" id="roleStudent" checked="checked">&nbsp;Student
                              &nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" class="form-check-input inline" name="role" value="Instructor" id="roleInstructor">&nbsp;Instructor
                            @if ($errors->has('role'))
                                    <span class="help-block" id="rolealert">
                                        <strong>{{ $errors->first('role') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                      
                        <div class="form-group{{ $errors->has('departmentName') ? ' has-error' : '' }}">
                            <label for="departmentName" class="col-md-4 control-label">Department Name<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                            <input id="departmentName" type="text" class="form-control" name="departmentName" value="{{ old('departmentName') }}" >
                            @if ($errors->has('departmentName'))
                                    <span class="help-block" >
                                        <strong id="departmentNamealert">{{ $errors->first('departmentName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <p> <strong>Note:</strong> Department name is must for Instructor role only. Students can keep it blank.</p>
                            </div>
                        </div>

                        <hr>
                        <h4> Security Questions </h4>
                        <hr>

                      <div class="form-group{{ $errors->has('security_question1_Id') ? ' has-error' : '' }}">
                            <label for="security_question1_Id" class="col-md-4 control-label">Question 1<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                                <select class="form-control" name="security_question1_Id" value="{{ old('security_question1_Id') }}">
                                     @foreach ($securityquestions as $question)
                                        <option value="{{ $question->id }}">
                                           {{ $question->security_question }}
                                        </option>
                                    @endforeach                                
                                </select>

                                @if ($errors->has('security_question1_Id'))
                                    <span class="help-block" >
                                        <strong id="securityQuestion1Alert">{{ $errors->first('security_question1_Id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('security_answer1') ? ' has-error' : '' }}">
                            <label for="state" class="col-md-4 control-label">Answer<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                                <input id="security_answer1" type="text" class="form-control" name="security_answer1" value="{{ old('security_answer1') }}">

                                @if ($errors->has('security_answer1'))
                                    <span class="help-block" >
                                        <strong id="securityAnswer1Alert">{{ $errors->first('security_answer1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('security_question2_Id') ? ' has-error' : '' }}">
                            <label for="security_question1_Id" class="col-md-4 control-label">Question 2<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                                <select class="form-control" name="security_question2_Id" value="{{ old('security_question2_Id') }}">
                                    @foreach ($securityquestions as $question)
                                        <option value="{{ $question->id }}">
                                           {{ $question->security_question}}     
                                        </option>
                                    @endforeach                                
                                </select>

                                @if ($errors->has('security_question2_Id'))
                                    <span class="help-block" >
                                        <strong id="securityQuestion2Alert">{{ $errors->first('security_question2_Id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('security_answer2') ? ' has-error' : '' }}">
                            <label for="state" class="col-md-4 control-label">Answer<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                                <input id="security_answer2" type="text" class="form-control" name="security_answer2" value="{{ old('security_answer2') }}">

                                @if ($errors->has('security_answer2'))
                                    <span class="help-block" >
                                        <strong id="securityAnswer2Alert">{{ $errors->first('security_answer2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                         <div class="form-group{{ $errors->has('security_question3_Id') ? ' has-error' : '' }}">
                            <label for="security_question3_Id" class="col-md-4 control-label">Question 3<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                                <select class="form-control" name="security_question3_Id" value="{{ old('security_question3_Id') }}">
                                    @foreach ($securityquestions as $question)
                                        <option value="{{ $question->id }}">
                                           {{ $question->security_question}}     
                                        </option>
                                    @endforeach                                
                                </select>

                                @if ($errors->has('security_question3_Id'))
                                    <span class="help-block" >
                                        <strong id="securityQuestion3Alert">{{ $errors->first('security_question3_Id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                  
                    <div class="form-group{{ $errors->has('security_answer3') ? ' has-error' : '' }}">
                        <label for="state" class="col-md-4 control-label">Answer<span style="color: red;font-size: large">*</span></label>

                        <div class="col-md-6">
                            <input id="security_answer3" type="text" class="form-control" name="security_answer3" value="{{ old('security_answer3') }}">

                            @if ($errors->has('security_answer3'))
                                <span class="help-block" >
                                    <strong id="securityAnswer3Alert">{{ $errors->first('security_answer3') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Register
                            </button>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
