@extends('layouts.app')

@section('content')
<div class="container">
 @if(empty($user))
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: lightBlue">Reset Password</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ url('/SecurityQuestions') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address<span style="color: red;font-size: large">*</span></label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Submit
                                </button>
                            </div>
                        </div>                        
                    </form>                    
                </div>
            </div>
        </div>
    </div>
 @endif

<!-- After user submits request --> 
 @if(!empty($IsEmailSubmitted))
<div class="row">
        <div class="col-md-8 col-md-offset-2">           
                @if(empty($user))
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Sorry! This email id is not registered in our database. Please try again. 
                </div>
                @else
                 <div class="panel panel-default">
                    <div class="panel-heading" style="background-color: lightBlue"> Reset Password- Please answer the below security questions.
                    </div>
                    <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/ResetPassword') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label"> Your email id: </label>

                            <div class="col-md-6">
                                <input id="email" type="security_answer1" class="form-control" name="email" value="<?php echo ($user['email']); ?>" readonly="true">
                            </div>
                        </div>

                        <input id="randomQuestionNumber" name="randomQuestionNumber" type="hidden" value="<?php echo ($randomQuestionNumber); ?>">
                     
                         @if($randomQuestionNumber == '1')
                        <div class="form-group{{ $errors->has('security_question1') ? ' has-error' : '' }}">
                            <label for="security_question1" class="col-md-4 control-label"><?php echo ($question); ?></label>

                            <div class="col-md-6">
                                <input id="security_answer1" type="security_answer1" class="form-control" name="security_answer1" value="{{ old('security_answer1') }}">

                                @if ($errors->has('security_question1'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('security_question1') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($randomQuestionNumber == '2')
                        <div class="form-group{{ $errors->has('security_question2') ? ' has-error' : '' }}">
                            <label for="security_question1" class="col-md-4 control-label"><?php echo ($question); ?></label>

                            <div class="col-md-6">
                                <input id="security_answer2" type="security_answer2" class="form-control" name="security_answer2" value="{{ old('security_answer2') }}">

                                @if ($errors->has('security_question2'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('security_question2') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        @if($randomQuestionNumber == '3')
                        <div class="form-group{{ $errors->has('security_question3') ? ' has-error' : '' }}">
                            <label for="security_question3" class="col-md-4 control-label"><?php echo ($question); ?></label>

                            <div class="col-md-6">
                                <input id="security_answer3" type="security_answer3" class="form-control" name="security_answer3" value="{{ old('security_answer3') }}">

                                @if ($errors->has('security_question3'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('security_question3') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" >
                                     Submit Answers
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                @endif

            </div>
        </div>
    </div>
 @endif

@if(!empty($wrongSecurityAnswers))
<div class="row">
        <div class="col-md-8 col-md-offset-2">
             <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>Sorry! Your submitted answer do not match with our record. Try again. 
            </div>
        </div>
</div>
@endIf

</div>
@endsection
