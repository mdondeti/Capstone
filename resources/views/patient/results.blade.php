@extends('patient.active_record')

@section('documentation_panel')
{{--@parent--}}
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                    <h4 style="margin-top: 0" id="results_heading">Results</h4>
                </div>

                <div class="panel-body ">
                    <form class="form-horizontal" method="POST" action="{{ route('post_results') }}" id="results_form">
                    {{ csrf_field() }}
                        <input id="module_id" name="module_id" type="hidden" value="{{ $patient->module_id }}">
                        <input id="patient_id" name="patient_id" type="hidden" value="{{ $patient->patient_id }}">
                        <input type=hidden id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-sm-6">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr class="bg-info">
                                            <th>List of ordered labs</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($labs as $lab)
                                            <tr>
                                                <td><p>{{$lab->value}}</p></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-6">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr class="bg-info">
                                            <th>List of ordered images</th>
                                         </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($images as $image)
                                            <tr>
                                                <td><p>{{$image->value}}</p></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12">
                                <h4>Results:</h4>
                                @if(!count($results)>0)
                                    <textarea id="results" name="results" rows="6" style="width: 100%;display: block"></textarea>
                                @else
                                    <textarea id="results" name="results" rows="6" style="width: 100%;display: block">{{$results[0]->value}}</textarea>
                                @endif
                            </div>
                        </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="reset" id="btn_clear_results_comment" class="btn btn-success" style="float: left">
                                        <i class="fa fa-refresh" aria-hidden="true"></i> Reset Results
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button id="btn_save_results" type="save" class="btn btn-primary" style="float: right">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp;Save Results
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
        $(document).ready(function(){
            var inputsChanged = false;
            $('#results_form').change(function() {
                inputsChanged = true;
            });

            function unloadPage(){
                if(inputsChanged){
                    return "Do you want to leave this page?. Changes you made may not be saved.";
                }
            }

            $("#btn_save_results").click(function(){
                inputsChanged = false;
            });

            window.onbeforeunload = unloadPage;

            $('#btn_clear_results_comment').click( function()
            {
                $('#results').val('');
                inputsChanged = false;
            } );
        });
    </script>
@endsection