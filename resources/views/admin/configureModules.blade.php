@extends('layouts.app')
@section('content')

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <div class="container">
        <div class="row" style="padding-top: 0; margin: 0">
            <h3 align = "center">Active Modules</h3>
        </div>

        <div class="row">
            <div class="col-md-2">
                <a href="{{url('/home')}}" class="btn btn-success" >
                    <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                    Back to Dashboard</a>
            </div>
            <div class="col-md-2 col-md-offset-8">
                    <a href="#" title="" class="btn btn-primary" id="add-record" style="float: right">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add new Module</a>
            </div>
        </div>
        <br>
        <br>
        <div class="row" style="overflow-x: scroll;width: 1200px">
            <table class="table-responsive table-striped" border="2" id="main_table">
                <thead >
                    <tr>
                        <td style="background-color:#5DADE2;">
                            <h5 style="width: 150px;margin-left: 1%;margin-right: 1%">
                                <h4 style="color: #000000">Module <i class="fa fa-arrows-v" aria-hidden="true"></i>/Navigations <i class="fa fa-arrows-h" aria-hidden="true"></i></h4>
                            </h5>
                        </td>
                        <td style="background-color:#5DADE2;" align="middle">
                            <h5 style="width: 150px;color: #000000"><b>Demographics</b></h5>
                        </td>
                        @foreach ($navs as $nav)
                            @if($nav->navigation_id == '2' || $nav->navigation_id == '9' || $nav->navigation_id == '20')
                                <td  style="background-color:#5DADE2;color: #000000"  align="middle">
                                    <h5 style="padding-left: 1%;padding-right: 1%;width: 100px"><b>{{ $nav->navigation_name }}</b></h5>
                                </td>
                            @else
                                @if($nav->parent_id != NULL)
                                    <td  style="background-color:#5DADE2; color: #000000; border: none">

                                    </td>
                                @else
                                    <td  style="background-color:#5DADE2; color: #000000"  align="middle">
                                        <h5 style="padding-left: 1%;padding-right: 1%;width: 100px"><b>{{ $nav->navigation_name }}</b></h5>
                                    </td>
                                @endif
                            @endif
                        @endforeach
                        <td>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color:#5DADE2; color: #000000">
                        </td>

                        <td style="background-color:#5DADE2; color: #000000" align="middle">
                        </td>

                        @foreach ($navs as $nav)
                            @if($nav->parent_id != NULL)
                                <td  style="background-color:#5DADE2; color: #000000"  align="middle">
                                    <h5 style="padding-left: 1%;padding-right: 1%;width: 100px">
                                    <b>{{ $nav->navigation_name }}</b>
                                    </h5>
                                </td>
                            @else
                                <td  style="background-color:#5DADE2; color: #000000"  align="middle">
                                    <h5 style="padding-left: 1%;padding-right: 1%;width: 100px">
                                    </h5>
                                </td>
                            @endif
                        @endforeach
                        <td>
                        </td>
                    </tr>
                </thead>
                <tbody style="overflow-x: scroll">
                @if($mods->isEmpty())
                    <tr id="onetimedisplay">
                        <td colspan="5" height="100" style="border: none; background-color:#F5F8FA">
                            <b>There are no active modules.<br> Please click the "Add Module" button to add module.</b>
                        </td>
                    </tr>
                @else
                @foreach ($mods as $mod)
                    <tr style="overflow-x: scroll">
                        <td align="middle">
                            {{ $mod->module_name }}
                        </td>
                        <td align="middle">
                            <input type="checkbox" checked onclick="return false">
                        </td>
                        @foreach ($navs as $nav)
                            <td align="middle">
                                <?php $check = 0; ?>
                                @foreach($navs_mods as $nm)
                                    @if($nm->module_id == $mod->module_id && $nm->navigation_id == $nav->navigation_id && $nm->visible ==1)
                                        <?php $check = 1; ?>
                                        @break;
                                    @else
                                        <?php $check = 0; ?>
                                    @endif
                                @endforeach

                                @if ($check == 1)
                                    <input type="checkbox" class="form-check-input inline" checked="checked" onclick="return false" >
                                @else
                                    <input type="checkbox" class="form-check-input inline" onclick="return false">
                                @endif
                            </td>
                        @endforeach

                        <td>
                            {{ Form::open(array('method' => 'post', 'route' => array('deletemodule', $mod->module_id))) }}
                                <div class="form-group">
                                    <button name="delbutton" class="btn btn-danger btn-delete">Delete</button>
                                </div>
                            {{ Form::close() }}
                        </td>
                    </tr>
                @endforeach
                @endif
                </tbody>
            </table>
        </div>
        <br>
        <br>

        {{ Form::open(array('method' => 'post', 'route' => array('submitmodule'))) }}
        <div class="row" id="childTable" style="overflow-x: scroll;width: 1200px">
        <table border="2" >
            <tr>
                <td style="background-color:#5DADE2;">
                    <h5 style="width: 150px;margin-left: 1%;margin-right: 1%">
                        <b>Module/Navigations</b>
                    </h5>
                </td>
                @foreach ($navs as $nav)
                    @if($nav->navigation_id == '2' || $nav->navigation_id == '9' || $nav->navigation_id == '20')
                        <td  style="background-color:#5DADE2;"  align="middle">
                            <h5 style="padding-left: 1%;padding-right: 1%;width: 100px"><b>{{ $nav->navigation_name }}- All</b></h5>
                        </td>
                    @else
                        @if($nav->parent_id != NULL)
                            <td  style="background-color:#5DADE2;border: none">

                            </td>
                        @else
                            <td  style="background-color:#5DADE2;"  align="middle">
                                <h5 style="padding-left: 1%;padding-right: 1%;width: 100px"><b>{{ $nav->navigation_name }}</b></h5>
                            </td>
                        @endif
                    @endif
                @endforeach
                <td>
                </td>
            </tr>
            <tr>
                <td style="background-color:#5DADE2;">
                </td>
                @foreach ($navs as $nav)
                    @if($nav->parent_id != NULL)
                        <td  style="background-color:#5DADE2;"  align="middle">
                            <h5 style="padding-left: 1%;padding-right: 1%;width: 100px">
                                <b>{{ $nav->navigation_name }}</b>
                            </h5>
                        </td>
                    @else
                        <td  style="background-color:#5DADE2;"  align="middle">
                            <h5 style="padding-left: 1%;padding-right: 1%;width: 100px">
                            </h5>
                        </td>
                    @endif
                @endforeach
                <td>
                </td>
            </tr>
            <tr>
               <td align="middle">
                   <input type="text" name="modulename" required id="new_module_name" placeholder="Module name">
                   @if ($errors->has('modulename'))
                       <span class="help-block" >
                                        <strong id="module_alert">{{ $errors->first('modulename') }}</strong>
                       </span>
                   @endif
               </td>
               @foreach ($navs as $nav)
                   <td align="middle">
                        {{-- To ensure Disposition is always checked --}}
                       @if($nav->navigation_id == 34)
                            <input type="checkbox" id=34 name="navs[]" value=34 checked onclick="return false">
                       @else
                            <input type="checkbox" id={{$nav->navigation_id}} name="navs[]" value={{$nav->navigation_id}}>
                       @endif
                   </td>
               @endforeach
               <td>
                   <button name="submitbutton" class="btn btn-success btn-submit" id="add_new_module">Add</button>
               </td>
            </tr>
        </table>

            <br>
            <a href="#" title="" class="btn btn-primary" id="cancel_add_module" style="float: left">
                Cancel</a>
            <br>

        </div>
        {{ Form::close() }}
    </div>
<br>
    <script>
        $(document).ready(function(){
            $("#new_module_name").keyup(function() {
                if($(this).val() != '') {
                    $('#add_new_module').prop('disabled', false);
                }
            });

            $('#childTable').hide();

            $("#add-record").click(function(){
                $('#onetimedisplay').hide();
                $('#add_new_module').prop('disabled', true);
                $('#childTable').show();
                $("#add-record").hide();
            });

            $("#cancel_add_module").click(function(){
                $('#childTable').hide();
                $("#add-record").show();

                for (var i = 1; i < 34; i++) {
                    $('#'+i).prop('checked', false);
                }
                $('#new_module_name').val('');
                $('#add_new_module').prop('disabled', true);
            });

            // Selecting medical history selects all children
            $('#2').click(function () {
                for (var i = 3; i < 7; i++) {
                    $('#'+i).prop('checked', true);
                }
            });

            $('#3').click(function () {
                $('#2').prop('checked',false);
            });
            $('#4').click(function () {
                $('#2').prop('checked',false);
            });
            $('#5').click(function () {
                $('#2').prop('checked',false);
            });
            $('#6').click(function () {
                $('#2').prop('checked',false);
            });


            // Selecting ROS selects all children
            $('#9').click(function () {
                for (var i = 10; i < 20; i++) {
                    $('#'+i).prop('checked', true);
                }
            });

            $('#10').click(function () {
                $('#9').prop('checked',false);
            });
            $('#11').click(function () {
                $('#9').prop('checked',false);
            });
            $('#12').click(function () {
                $('#9').prop('checked',false);
            });
            $('#13').click(function () {
                $('#9').prop('checked',false);
            });
            $('#14').click(function () {
                $('#9').prop('checked',false);
            });
            $('#15').click(function () {
                $('#9').prop('checked',false);
            });
            $('#16').click(function () {
                $('#9').prop('checked',false);
            });
            $('#17').click(function () {
                $('#9').prop('checked',false);
            });
            $('#18').click(function () {
                $('#9').prop('checked',false);
            });
            $('#19').click(function () {
                $('#9').prop('checked',false);
            });


            // Selecting PE selects all children
            $('#20').click(function () {
                for (var i = 21; i < 31; i++) {
                    $('#'+i).prop('checked', true);
                }
            });

            $('#21').click(function () {
                $('#20').prop('checked',false);
            });
            $('#22').click(function () {
                $('#20').prop('checked',false);
            });
            $('#23').click(function () {
                $('#20').prop('checked',false);
            });
            $('#24').click(function () {
                $('#20').prop('checked',false);
            });
            $('#25').click(function () {
                $('#20').prop('checked',false);
            });
            $('#26').click(function () {
                $('#20').prop('checked',false);
            });
            $('#27').click(function () {
                $('#20').prop('checked',false);
            });
            $('#28').click(function () {
                $('#20').prop('checked',false);
            });
            $('#29').click(function () {
                $('#20').prop('checked',false);
            });
            $('#30').click(function () {
                $('#20').prop('checked',false);
            });


        });
    </script>

@endsection



