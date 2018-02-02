<!--
 Developer - Varun Parihar
 Date - 09/23/2017
 Description - View for Edit Profile functionality.
-->
@extends('layouts.app')
@section('content')

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>



  <div class="container">
  <div class="col-md-8 col-md-offset-2">
    @if($user['role'] == 'Admin')
    <div class="row">
      <a href="{{url('/home')}}" class="btn btn-success" style="float: left">
        <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
        Back to Dashboard</a>
    </div>
      @elseif($user['role'] == 'Instructor')
        <div class="row">
          <a href="{{url('/InstructorHome')}}" class="btn btn-success" style="float: left">
            <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
            Back to Dashboard</a>
        </div>
        @else($user['role'] == 'Student')
          <div class="row">
            <a href="{{url('/StudentHome')}}" class="btn btn-success" style="float: left">
              <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
              Back to Dashboard</a>
          </div>
    @endif
    <br>
      <div class="panel panel-default">

        <div class="panel-heading" style="padding-bottom: 0;padding-top: 0">
          <h3 >Edit Profile</h3>
        </div>

        @if (count($errors) > 0)
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <div class="panel-body">

          <form class="form-horizontal" method="POST" action="{{ url('EditProfile') }}">
            {{ csrf_field() }}
            <div class="form-group">
              <label for="email" class="col-md-4 control-label">E-Mail Address</label>
              <div class="col-md-6">

                <input id="email" type="email" class="form-control" name="email" value="<?php echo ($user['email']); ?>" readonly="true">
              </div>
            </div>

            <div class="form-group">
              <label for="departmentName" class="col-md-4 control-label">Department</label>
              <div class="col-md-6">

                <input id="departmentName" type="departmentName" class="form-control" name="departmentName" value="<?php echo ($user['departmentName']); ?>" >
              </div>
            </div>
            <div class="form-group">
              <label for="firstname" class="col-md-4 control-label">First Name</label>
              <div class="col-md-6">

                <input id="firstname" type="firstname" class="form-control" name="firstname" value="<?php echo ($user['firstname']); ?>">
              </div>
            </div>
            <div class="form-group">
              <label for="lastname" class="col-md-4 control-label">Last Name</label>
              <div class="col-md-6">

                <input id="lastname" type="lastname" class="form-control" name="lastname" value="<?php echo ($user['lastname']); ?>">
              </div>
            </div>

            <div class="form-group">
              <label for="contactno" class="col-md-4 control-label">Contact No.</label>
              <div class="col-md-6">

                <input id="contactno" type="contactno" class="form-control" name="contactno" value="<?php echo ($user['contactno']); ?>">
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <p> <strong>Note:</strong> 10-digit US number</p>
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                          Save Changes
                </button>
              </div>
            </div>
          </form>
        </div>

      </div>
    <!-- After user submits request -->
    @if($Profilesubmitted == 'Yes')
      <div class="row">
        <div class="alert alert-success alert-dismissable">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          Profile updated successfully.
        </div>
      </div>
    @endif
    </div>
  </div>
  @endsection
