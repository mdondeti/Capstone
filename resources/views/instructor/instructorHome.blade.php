@extends('layouts.app')

@section('content')
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <div class="container">
        <div class="row">
            <h3 style="text-align: center"><img src="logos\LogoInstructor.png" width="4%"> Instructor Dashboard <img src="logos\LogoInstructor.png" width="4%"></h3>
        </div>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default" style="margin-bottom: 0;padding-bottom: 0">
                    <div class="panel-heading" style="background-color: #5DADE2; padding-bottom: 0">
                        <h4 style="margin-top: 0">Submitted For Review</h4>
                    </div>
                    <div class="panel-body" style="margin-bottom: 0;padding-bottom: 0">
                        @if($modules_for_review)
                            @foreach($modules_for_review as $module)
                                <div class="panel panel-default">
                                    <div class="panel-heading" style="background-color: grey; padding-bottom: 0">
                                        <h4 id="savedModuleName" style="margin-top: 0">{{$module}}</h4>
                                    </div>

                                    <div class="panel-body">
                                        @if($for_review_patients)
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                <tr class="bg-info">
                                                    <th>Patient Name</th>
                                                    <th>Visit Date</th>
                                                    <th>Submitted By</th>
                                                    <th>Submitted On</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                {{--{{$for_review_patients}}--}}
                                                @foreach($for_review_patients as $for_review_patient)
                                                    @if($for_review_patient->patient->module)
                                                        @if($for_review_patient->patient_record_status_id === 2 && $for_review_patient->patient->module->module_name === $module)
                                                            <tr>
                                                                <td>
                                                                    <p id="patientName">
                                                                        <?php echo $for_review_patient->patient->first_name.' '.$for_review_patient->patient->last_name; ?>
                                                                    </p>
                                                                </td>
                                                                <td><p id="visitDate">{{$for_review_patient->patient->visit_date}}</p></td>
                                                                <td><p id="submittedBy">{{$for_review_patient->patient->user->firstname." ".$for_review_patient->patient->user->lastname}}</p></td>

                                                                @if($for_review_patient->updated_at != null)
                                                                    <td><p id="submittedOn">{{($for_review_patient->updated_at)->format('Y-m-d')}}</p></td>
                                                                @else
                                                                    <td><p id="submittedOn"></p></td>
                                                                @endif
                                                                <td style="text-align: right">
                                                                    <a href="{{ route( 'patient_preview', ['patient_id' => $for_review_patient->patient_id ] ) }}" class="btn btn-primary" id="preview">
                                                                        <i class="fa fa-file-text" aria-hidden="true"></i> Preview
                                                                    </a>
                                                                    <a href="{{ route( 'pdf_generate', ['patient_id' => $for_review_patient->patient_id ] ) }}" class="btn btn-success" id="generate_report">
                                                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Generate PDF
                                                                    </a>
                                                                    <a href="{{ route( 'patient.reviewed', ['patient_id' => $for_review_patient->patient_id]) }}" class="btn btn-info confirmation" id="mark_reviewed">
                                                                        <i class="fa fa-check-square-o" aria-hidden="true"></i> Mark Reviewed
                                                                    </a>
                                                                </td>

                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p>{{$for_review_message}}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default" style="margin-bottom: 0;padding-bottom: 0">
                    <div class="panel-heading" style="background-color: #5DADE2; padding-bottom: 0">
                        <h4 style="margin-top: 0">Reviewed Patients</h4>
                    </div>
                    <div class="panel-body" style="margin-bottom: 0;padding-bottom: 0">
                            @if(!empty($reviewed_patients))
                                @foreach($modules_reviewed as $module)
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="background-color: grey; padding-bottom: 0">
                                            <h4 id="savedModuleName" style="margin-top: 0">{{$module}}</h4>
                                        </div>
                                        <div class="panel-body">
                                            @if($reviewed_patients)
                                                <table class="table table-striped table-bordered table-hover">
                                                    <thead>
                                                    <tr class="bg-info">
                                                        <th>Patient Name</th>
                                                        <th>Visit Date</th>
                                                        <th>Submitted By</th>
                                                        <th>Reviewed On</th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($reviewed_patients as $reviewed_patient)
                                                        <!-- To check the patient records with "Saved" status -->
                                                        @if($reviewed_patient->patient->module)
                                                            @if($reviewed_patient->patient_record_status_id === 3 && $reviewed_patient->patient->module->module_name === $module)
                                                                <tr>
                                                                    <td>
                                                                        <p id="patientName">
                                                                            <?php echo $reviewed_patient->patient->first_name.' '.$reviewed_patient->patient->last_name; ?>
                                                                        </p>
                                                                    </td>

                                                                    <td><p id="visitDate">{{$reviewed_patient->patient->visit_date}}</p></td>
                                                                    <td><p id="submittedBy">{{$reviewed_patient->patient->user->firstname." ".$reviewed_patient->patient->user->lastname}}</p></td>
                                                                    @if($reviewed_patient->updated_at != null)
                                                                        <td><p id="reviewedOn">{{($reviewed_patient->updated_at)->format('Y-m-d')}}</p></td>
                                                                    @else
                                                                        <td><p id="reviewedOn"></p></td>
                                                                    @endif
                                                                    <td style="text-align: right">
                                                                        <a href="{{ route( 'patient_preview', ['patient_id' => $reviewed_patient->patient_id ] ) }}" class="btn btn-primary" id="preview">
                                                                            <i class="fa fa-file-text" aria-hidden="true"></i> Preview
                                                                        </a>
                                                                        <a href="{{ route( 'pdf_generate', ['patient_id' => $reviewed_patient->patient_id ] ) }}" class="btn btn-success" id="generate_report">
                                                                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Generate PDF
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                            @else
                                <p>{{$reviewed_message}}</p>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('.confirmation').on('click', function () {
            return confirm('Patient will be marked as reviewed. Are you sure?');
        });
    </script>
@endsection