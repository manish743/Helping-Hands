@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('css')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            HIM
        @endslot
        @slot('li_2')
            Applicant
        @endslot
        @slot('li_3')
            Detail
        @endslot
        @slot('title')
            Applicant
        @endslot
    @endcomponent


    {{-- <input type="hidden" name="id" value="{{ $id }}"> --}}
    <div class="row p-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">


                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Candidate Information</h4>
                        </div><!--end col-->
                        <div class="col-auto align-self-center">
                            @if ($auth_user->hasRole('HIMSubUser'))
                                @if ($screening_date)
                                    Screening date:
                                    {{ $screening_date->interview_date }}
                                    {{ $screening_date->interview_time }}
                                @elseif (count($screening_option) > 0)
                                    <a class=" btn btn-sm btn-soft-warning mb-2">Waiting For Candidate </a>
                                    <a class=" btn btn-sm btn-soft-primary mb-2" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalLogin">Schedule Interview again</a>
                                @elseif ($candidate->is_screened)
                                    <a class=" btn btn-sm btn-soft-primary mb-2" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalLogin">Schedule Followup Screening Interview</a>
                                @else
                                    <a class=" btn btn-sm btn-soft-primary mb-2" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalLogin">Schedule Screening Interview</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div><!--end card-header-->
                <div class="card-body bootstrap-select-1">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">First Name</label>
                                        <div>
                                            {{ $candidate->first_name }}

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Last Name</label>
                                        <div>
                                            {{ $candidate->last_name }}

                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <div>
                                            {{ $candidate->email }}

                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Mobile Number</label>
                                        <div>
                                            {{ $candidate->contact }}

                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Type Of Employement</label>
                                        <div>
                                            {{ $candidate->job_type }}

                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label">Expected Monthly Salary</label>
                                        <div>
                                            {{ $candidate->expected_salary }}

                                        </div>

                                    </div>
                                </div>

                            </div>
                            @if (isset($current_job))
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Current Job Title</label>
                                            <div>
                                                {{ $current_job->job_title }}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Tenure In Job</label>
                                            <div>
                                                {{ $current_job->job_tenure }}

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Current Company Name</label>
                                            <div>
                                                {{ $current_job->company_name }}

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Responsibilities</label>
                                            <div>
                                                {!! $current_job->responsibility !!}

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Achievements</label>
                                            <div>
                                                {!! $current_job->achievement !!}

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Skills Developed</label>
                                            <div>
                                                {!! $current_job->skills_developed !!}


                                            </div>

                                        </div>
                                    </div>

                                </div>
                            @endif
                            @if (isset($previous_job))
                                <div class="row">
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">previous Job Title</label>
                                            <div>
                                                {{ $previous_job->job_title }}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">Tenure In Job</label>
                                            <div>
                                                {{ $previous_job->job_tenure }}

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-3 col-sm-4">
                                        <div class="form-group">
                                            <label class="form-label">previous Company Name</label>
                                            <div>
                                                {{ $previous_job->company_name }}

                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Responsibilities</label>
                                            <div>
                                                {!! $previous_job->responsibility !!}

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Achievements</label>
                                            <div>
                                                {!! $previous_job->achievement !!}

                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Skills Developed</label>
                                            <div>
                                                {!! $previous_job->skills_developed !!}


                                            </div>

                                        </div>
                                    </div>



                                    
                                       
                             

                                    

                                </div>
                            @endif
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Candidate Summary</label>
                                    <div>
                                        @if ($applicant->summary)
                                        {!! $applicant->summary !!}
                                        @else
                                        {!! $candidate->summary !!}
                                        @endif
                                       

                                    </div>

                                </div>
                            </div>

                        </div><!-- end col -->

                    </div><!-- end row -->


                    <div class="row align-items-center">
                        <hr>
                        <div class="col">
                           
                            @if ($auth_user->hasRole('ClientAdmin')&& $applicant->stage_id==0)
                                
                       
                                @if ($applicant->is_rejected == 0)
                                    <a class=" btn btn-sm btn-soft-primary screen_pass" >Screening passed</a>
                                    <a class=" btn btn-sm btn-soft-danger" id="show_jobs">Reject</a>
                                    <form action="{{ route('applicant-reject') }}" method="post" id="refer_form" class="m-2">
                                        @csrf
                                        <input type="hidden" name="applicant_id"
                                            value="{{ base64_encode($applicant->id) }}">
                                        <div class="row">
                                            
                                            <div class="col-md-6 mt-2">
                                              
                                                    <label for="">Reson For rejection</label>
                                                    <textarea rows="4" name="reason" required class="form-control" parsley-type="summary"></textarea>

                                                
                                            </div>


                                        </div>
                                        <div class="row ">
                                            <div class="col-md-2">
                                                <button class="btn btn-sm btn-primary" type="submit"> Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                                @endif
                         
                        </div><!--end col-->
                        <div class="col-auto align-self-center">
                            @if (isset($pdfPath))
                                <a href="{{ asset($pdfPath) }}" target="_blank" rel="noopener noreferrer"><button
                                        class="btn btn-primary text-white" type="">View CV</button></a>
                                {{-- <a href="{{ $signedPdfPath}}" target="_blank" rel="noopener noreferrer"><button class="btn btn-success text-white" type="">View CV</button></a> --}}
                            @endif
                        </div>
                    </div>



                </div><!-- end card-body -->

            </div> <!-- end card -->
        </div> <!-- end col -->

    </div>

    {{-- @if ($auth_user->hasRole('HIMSubUser')) --}}
        @component('components.apply_list')
            @slot('applied', $applied)
        @endcomponent
    {{-- @endif --}}
@endsection
@section('script')
<script>
    $(document).ready(function() {
        $('#refer_form').hide();
        $('#show_jobs').on('click', function() {
            console.log('okay');
            $('#refer_form').toggle();
            
        });
      
    })
</script>
<script>
    $('.screen_pass').click(function(e) {
        e.preventDefault();
        var row = $(this).closest('.col');
        var id = '{{ base64_encode($applicant->id) }}';
        debugger
        swal.fire({
            title: 'Are you sure?',
            text: "Confirm Your Action!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, proceedit!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then(function(result) {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('applicant_screen_pass') }}",
                    type: "POST",
                    data: {

                        id: id,

                    },
                    dataType: "JSON",

                    // data: row.serialize(),
                    success: function(result) {
                        // debugger
                        console.log(result);
                        if (result.status) {
                            swal.fire(
                                'Screening Passed!',
                                result.message,
                                'success').then(function() {
                                row.remove();
                            });
                        } else {
                            swal.fire(
                                'Faulure!',
                                result.message,
                                'warning'
                            );
                        }


                    },
                }).fail((message) => {
                    console.log(typeof message);
                        debugger
                        if (typeof message == 'object') {
                            message = message.responseText;
                            console.log(message);
                            
                        } else {
                            try {
                                message = JSON.parse(message.responseText);
                            
                            } catch (error) {
                                console.error('Error parsing JSON:', error);
                            }
                        }
                    for (var key in message.errors) {
                        console.log(key + " - " + message.errors[key]);
                        messages.show(message.errors[key], {
                            title: "Error,",
                        });
                    }
                    swal.fire(
                        'Failure!',
                        message.message,
                        'warning'
                    );
                });


            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swal.fire(
                    'Cancelled',
                    'Your imaginary file is safe :)',
                    'error'
                )
            }
        })
    });
</script>
@endsection
