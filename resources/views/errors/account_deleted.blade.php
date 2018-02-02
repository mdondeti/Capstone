@extends('layouts.app')

@section('content')
  
    <div class="container">
        <div class="content">
            <div class="alert alert-info" align="middle">
                <p align="middle">
                    <strong> Your account has been deleted. Please contact admin for more details.
                    </strong>
                </p>
                 <a href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        Logout
                 </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                
            </div>
        </div>
    </div>
@endsection
