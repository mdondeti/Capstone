@extends('patient.active_record')

@section('documentation_panel')
{{--@parent--}}
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                    <h4 style="margin-top: 0" id="hpi_heading">History of Present Illness (HPI)</h4>
                </div>

                <div class="panel-body ">
                    <form class="form-horizontal" method="POST" id="HPI_form" action="{{ route('post_HPI') }}">
                    {{ csrf_field() }}
                        <input id="module_id" name="module_id" type="hidden" value="{{ $patient->module_id }}">
                        <input id="patient_id" name="patient_id" type="hidden" value="{{ $patient->patient_id }}">
                        <input type=hidden id="user_id" name="user_id" value="{{ Auth::user()->id }}">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <h4>History of Present Illness:</h4>
                                    @if(!count($HPI)>0)
                                        <textarea id="HPI" name="HPI" rows="6" style="width: 100%;display: block"></textarea>
                                    @else
                                        <textarea id="HPI" name="HPI" rows="6" style="width: 100%;display: block">{{$HPI[0]->value}}</textarea>
                                    @endif
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="reset" id="btn_clear_HPI_comment" class="btn btn-success" style="float: left">
                                        <i class="fa fa-refresh" aria-hidden="true"></i> Reset HPI
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <button id="save_button" type="save" class="btn btn-primary" style="float: right">
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> &nbsp;Save HPI
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
            $('#HPI_form').change(function() {
                inputsChanged = true;
                });

            function unloadPage(){
                if(inputsChanged){
                    return "Do you want to leave this page?. Changes you made may not be saved.";
                }
            }

            $("#save_button").click(function(){
                inputsChanged = false;
            });

            window.onbeforeunload = unloadPage;

            $('#btn_clear_HPI_comment').click( function()
            {
                $('#HPI').val('');
                inputsChanged = false;
            } );
        });
    </script>
@endsection