@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                <div class="panel-heading" style="background-color: lightBlue">Reset Password</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('/ChangePassword') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="<?php echo ($user->email); ?>" required  readonly="true">

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">Enter your New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required autofocus>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label for="password-confirm" class="col-md-4 control-label">Re-Enter your new Password</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <input type="submit" value="Reset Password" class="btn btn-primary" >       
                                
                            </div>
                        </div>
                    </form>

                    @if($erroredForm == 'Passwords do not match')
                        <div class="row">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
                                    <strong>Passwords do not match. Please try again.</strong>
                                </div>
                            </div>
                        </div>
                    @endIf

                     @if($erroredForm == 'Password short')
                        <div class="row">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>  
                                    <strong>Password must contain minimum 6 letters. Please try again.</strong>
                                </div>
                            </div>
                        </div>
                    @endIf                   
                </div>
            </div>
        </div>
    </div>

     @if($PasswordChanged == 'Yes')
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="alert alert-success alert-dismissable">
                        <a href="{{url('/login')}}" class="close" data-dismiss="alert" aria-label="close">&times;</a>                  
                        <strong>
                        Your password is changed. Please login with your new password.
                        </strong>
                    </div>
                </div>
            </div>
     @endIf
     
 </div>
@endsection
