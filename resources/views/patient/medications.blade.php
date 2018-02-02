{{--@extends('layouts.app')--}}
{{--@extends('patient.vital_signs_header')--}}
@extends('patient.active_record')

@section('documentation_panel')
    {{--Medications--}}
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: lightblue;padding-bottom: 0">
                <h4 style="margin-top: 0">Medications</h4>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="{{ route('post_medications') }}" id="medications_form">
                    {{ csrf_field() }}
                     <input id="module_id" name="module_id" type="hidden" value="{{ $patient->module_id }}">
                     <input id="patient_id" name="patient_id" type="hidden" value="{{ $patient->patient_id }}">
                     <input type=hidden id="user_id" name="user_id" value="{{ Auth::user()->id }}">

                     <div class="container-fluid">
                         <div class="row">
                            <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr class="bg-info">
                                        <th>List of Medicines</th>
                                        <th colspan="2"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($medications as $medicine)
                                        <tr>
                                            <td><p>{{$medicine->value}}</p></td>
                                            <td style="text-align: right">
                                                <a href="{{ route( 'delete_medication', ['active_record_id' => $medicine->active_record_id]) }}"
                                                   class="btn btn-danger confirmation" id="delete">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                        </div>
                       <hr>
                         <!-- Search For Medications -->
                         <div class="row">
                            <div class="col-md-2 ">
                                <label for="Medications"> Medications:</label>
                            </div>
                            <div class="col-md-6 ">
                                <select id="search_medications" class="js-example-basic-multiple js-states form-control" name="search_medications[]" multiple></select>
                            </div>
                        </div>
                         <br>
                         <br>
                         <!-- Comment box -->
                         <div class="row">
                             <div class="col-md-12">
                                 <label for="Comment"> Comments:</label>
                                 @if(!count($medication_comment)>0)
                                     <textarea rows="4" id="medication_comment" name="medication_comment" style="width: 100%;display: block"></textarea>
                                 @else
                                     <textarea rows="4" id="medication_comment" name="medication_comment" style="width: 100%;display: block">{{$medication_comment[0]->value}}</textarea>
                                 @endif
                             </div>
                        </div>
                         <br>
                         <!-- Buttons -->
                         <div class="row">
                             <div class="col-md-6">
                                 <button type="reset" id="btn_clear_medication" class="btn btn-success" style="float: left">
                                     <i class="fa fa-refresh" aria-hidden="true"></i> Reset Medications
                                 </button>
                             </div>
                             <div class="col-sm-6">
                                 <button type="submit" id="btn_save_medication" class="btn btn-primary" style="float: right">
                                     <i class="fa fa-floppy-o" aria-hidden="true"></i> Save Medications
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
        $('#search_medications').select2({
            placeholder: "Choose Medications...",
            minimumInputLength: 2,
            ajax: {
                url: '{{route('medications_find')}}',
                dataType: 'json',
                data: function (params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function (data) {
                    return {
                        results: data
                    };
                },
                cache: false
            }
        });
        $(document).ready(function(){
            var inputsChanged = false;
            $('#medications_form').change(function() {
                inputsChanged = true;
            });

            function unloadPage(){
                if(inputsChanged){
                    return "Do you want to leave this page?. Changes you made may not be saved.";
                }
            }

            $("#btn_save_medication").click(function(){
                inputsChanged = false;
            });

            $('#btn_clear_medication').click( function()
            {
                $('#medication_comment').val('');
                $('#search_medications').empty().trigger('change');
                inputsChanged = false;
            } );

            window.onbeforeunload = unloadPage;
        });

    </script>

@endsection