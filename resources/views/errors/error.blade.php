@extends('layouts.app')
@section('content')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info" align="middle">
                    <p align="middle">
                        @if($error_message)
                            <strong> {{$error_message}} </strong>
                        @else
                            <strong>Something went wrong!</strong>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
