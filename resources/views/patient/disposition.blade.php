@extends('patient.active_record')

@section('documentation_panel')
    {{--Disposition--}}
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                <h4 style="margin-top: 0">Disposition<span style="color: red;font-size: large">*</span>

                </h4>
            </div>
            <div class="panel-body">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-horizontal" method="POST" action="{{ route('post_disposition') }}" id="disposition_form">
                    {{ csrf_field() }}
                     <input id="module_id" name="module_id" type="hidden" value="{{ $patient->module_id }}">
                     <input id="patient_id" name="patient_id" type="hidden" value="{{ $patient->patient_id }}">
                     <input type=hidden id="user_id" name="user_id" value="{{ Auth::user()->id }}">

                     <div class="container-fluid">
                         <div class="row">
                             <div class="col-md-12">
                                <table class="table table-striped table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td>
                                                @if($disposition_value[0] == 'Discharged')
                                                    <input type="radio" class="form-check-input inline" name="disposition" value="Discharged" checked="checked" id="disposition_discharged" >&nbsp;Discharged                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                @else
                                                    <input type="radio" class="form-check-input inline" name="disposition" value="Discharged" id="disposition_discharged" >&nbsp;Discharged
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($disposition_value[0] == 'Admitted')
                                                    <input type="radio" class="form-check-input inline" checked="checked" name="disposition" value="Admitted" id="disposition_admitted" >&nbsp;Admitted
                                                @else
                                                    <input type="radio" class="form-check-input inline" name="disposition" value="Admitted" id="disposition_admitted" >&nbsp;Admitted
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($disposition_value[0] == 'Transferred')
                                                    <input type="radio" class="form-check-input inline" name="disposition" checked="checked" value="Transferred" id="disposition_transferred" >&nbsp;Transferred
                                                @else
                                                    <input type="radio" class="form-check-input inline" name="disposition" value="Transferred" id="disposition_transferred" >&nbsp;Transferred
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($disposition_value[0] == 'Expired')
                                                    <input type="radio" class="form-check-input inline" name="disposition" checked="checked" value="Expired" id="disposition_expired" >&nbsp;Expired
                                                @else
                                                    <input type="radio" class="form-check-input inline" name="disposition" value="Expired" id="disposition_expired" >&nbsp;Expired
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($disposition_value[0] == 'AMA')
                                                    <input type="radio" class="form-check-input inline" name="disposition" checked="checked" value="AMA" id="disposition_ama" >&nbsp;AMA
                                                @else
                                                    <input type="radio" class="form-check-input inline" name="disposition" value="AMA" id="disposition_ama" >&nbsp;AMA                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($disposition_value[0] == 'Eloped')
                                                    <input type="radio" class="form-check-input inline" name="disposition" value="Eloped" checked="checked" id="disposition_eloped" >&nbsp;Eloped                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                @else
                                                    <input type="radio" class="form-check-input inline" name="disposition" value="Eloped" id="disposition_eloped" >&nbsp;Eloped                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($disposition_value[0] == 'LWBS')
                                                    <input type="radio" class="form-check-input inline" name="disposition" value="LWBS" checked="checked" id="disposition_lwbs" >&nbsp;LWBS                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                @else
                                                    <input type="radio" class="form-check-input inline" name="disposition" value="LWBS" id="disposition_lwbs" >&nbsp;LWBS                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                             </div>
                         </div>
                         <!-- Comment box -->
                         <div class="row">
                             <div class="col-md-12">
                                 <label for="Comment"> Comments:</label>
                                 <br>
                                 @if(!count($disposition_comment)>0)
                                     <textarea rows="4" id="disposition_comment" name="disposition_comment" style="width: 100%;display: block"></textarea>
                                 @else
                                     <textarea rows="4" id="disposition_comment" name="disposition_comment" style="width: 100%;display: block">{{$disposition_comment[0]}}</textarea>
                                 @endif
                             </div>
                        </div>
                         <br>
                         <!-- Buttons -->
                         <div class="row">
                             <div class="col-md-6">
                                 <button type="reset" id="btn_clear_disposition_comment" class="btn btn-success" style="float: left">
                                     <i class="fa fa-refresh" aria-hidden="true"></i> Reset Disposition
                                 </button>
                             </div>
                             <div class="col-sm-6">
                                 <button type="submit" id="btn_save_disposition" class="btn btn-primary" disabled="true" style="float: right">
                                     <i class="fa fa-floppy-o" aria-hidden="true"></i> Save Disposition
                                 </button>
                             </div>
                         </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            var inputsChanged = false;
            $('#disposition_form').change(function() {
                inputsChanged = true;
            });

            function unloadPage(){
                if(inputsChanged){
                    return "Do you want to leave this page?. Changes you made may not be saved.";
                }
            }

            $("#btn_save_disposition").click(function(){
                inputsChanged = false;
            });

            $('#btn_clear_disposition_comment').click( function()
            {
                $('#disposition_comment').val('');
                $('#btn_save_disposition').prop('disabled', true);
                $('.form-check-input').prop('checked',false);
                inputsChanged = false;
            } );
            window.onbeforeunload = unloadPage;
        });

        $('.form-check-input').click( function()
        {
            $('#btn_save_disposition').prop('disabled', false);
        } );

    </script>

@endsection