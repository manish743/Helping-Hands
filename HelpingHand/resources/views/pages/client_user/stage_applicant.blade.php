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

    <div class="modal fade" id="exampleModalLogin" tabindex="-1" role="dialog" aria-labelledby="exampleModalDefaultLogin"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="exampleModalDefaultLogin">Select Date and Time for Interview </h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->
                <div class="modal-body">

                    <div class="card-body p-0">

                        <!-- Tab panes -->
                        <div>
                            <div class="">
                                <form class="form-horizontal auth-form" action="{{ route('create_interview') }}"
                                    method="post">
                                    @csrf
                                    <input type="hidden" name="candidate_id" value="{{ base64_encode($candidate->id) }}">
                                    <input type="hidden" name="job_applicant_id"
                                        value="{{ base64_encode($applicant->id) }}">
                                    <input type="hidden" name="stage_id" value="{{ base64_encode($applicant->stage_id) }}">

                                    <fieldset>
                                        <div class="repeater-default">
                                            <div data-repeater-list="interview">
                                                <div data-repeater-item="">
                                                    <div class="form-group row d-flex align-items-end">

                                                        <div class="col-sm-5">
                                                            <label class="form-label">Date</label>
                                                            <input type="date" required name="interview[0][date]"
                                                                class="form-select">
                                                            {{-- <input type="text" required name="interview[0][date]" class="form-control mdate" placeholder="2017-06-04"> --}}

                                                        </div><!--end col-->

                                                        <div class="col-sm-3">
                                                            <label class="form-label">Time</label>
                                                            {{-- <input type="time" required name="interview[0][time]"
                                                                    class="form-control"> --}}
                                                            <input class="form-control timepicker" name="interview[0][time]"
                                                                id="" placeholder="Check time">
                                                        </div><!--end col-->



                                                        <div class="col-sm-1">
                                                            <span data-repeater-delete=""
                                                                class="btn btn-sm btn-outline-danger">
                                                                <span class="far fa-trash-alt me-1"></span> Delete
                                                            </span>
                                                        </div><!--end col-->
                                                    </div><!--end row-->
                                                </div><!--end /div-->
                                            </div><!--end repet-list-->
                                            <div class="form-group mb-2 row">
                                                <div class="col-sm-12">
                                                    <span data-repeater-create="" class="btn btn-outline-secondary">
                                                        <span class="fas fa-plus"></span> Add
                                                    </span>

                                                </div><!--end col-->
                                            </div><!--end row-->
                                        </div> <!--end repeter-->
                                    </fieldset><!--end fieldset-->

                                    <div class="form-group mb-0 row">
                                        <div class="col-12">
                                            <input type="submit" value="Submit" class="btn btn-outline-primary">
                                        </div><!--end col-->
                                    </div> <!--end form-group-->
                                </form><!--end form-->
                            </div>

                        </div>
                    </div><!--end card-body-->

                </div><!--end modal-body-->

            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div><!--end modal-->
    {{-- <input type="hidden" name="id" value="{{ $id }}"> --}}
    <div class="row p-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">


                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Applicant Stage {{ $applicant->stage_id }} : {{ $job->vacant_position }}</h4>
                        </div><!--end col-->
                        <div class="col-auto align-self-center">
                            
                            @if ($auth_user->hasRole('StageUser'))
                                @if ($screening_date)
                                    Screening date:
                                    {{ $screening_date->interview_date }}
                                    {{ $screening_date->interview_time }}
                                @elseif (count($screening_option) > 0)
                                    @if ($applicant->stage_id==4)
                                    <a class=" btn btn-sm btn-soft-warning mb-2">Confirmed Panels {{ $applicant->panel_confirmed()->where('confirmed', 1)->count() }}/
                                        {{ $applicant->panels->count() }}</a>
                                    <a class=" btn btn-sm btn-soft-primary mb-2" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalLogin">Schedule Interview again</a>
                                    @else
                                    <a class=" btn btn-sm btn-soft-warning mb-2">Waiting For Candidate </a>
                                    <a class=" btn btn-sm btn-soft-primary mb-2" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalLogin">Schedule Interview again</a>
                                    @endif
                                    
                               
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
    @if ($auth_user->hasRole('StageUser') && $applicant->stage_complete ==0)
        {{-- @if (!$applicant->stage_complete) --}}
         
                @component('pages.client_user.stage_score.score')
                    @slot('stages_question', $stages_question)
                    @slot('stages', $stages)
                    @slot('applicant', $applicant)
                    @slot('candidate', $candidate)
                    @slot('job_stage_weight', $job_stage_weight)
                @endcomponent
          

        {{-- @endif --}}

    @endif


    {{-- @if ($auth_user->hasRole('HIMSubUser')) --}}
    {{-- @component('components.apply_list')
        @slot('applied', $applied)
    @endcomponent --}}
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
                                    'Deleted!',
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
                            debugger
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
                            'Faulure!',
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
        $('.modal_form').on('submit', function(event) {
                event.preventDefault();
                let isValid = true;
                var $form = $(this);
                $form.find('.error-container').empty();
                var isFirstIteration = true;
                $(this).find('[required]').each(function() {


                    if ($(this).val() === '') {
                        isValid = false; // If a required field is empty, set isValid to false
                        $(this).addClass('error'); // Optionally, add a CSS class for styling
                        // $(this).siblings('label').addClass('error'); 
                        $(this).siblings('.error-message').remove();
                        var name = $(this).siblings('label').text().trim(); // Get label text
                        if (!name) {
                            name = $(this).attr(
                                'name'); // If label text is empty, get the name attribute
                            var parts = name.split('[question]').filter(Boolean);

                            // Join the parts with spaces
                            var convertedName = parts.join('Question ');
                            convertedName = convertedName.replace(
                                /\[|\]|\_/g, ' ').trim();
                            name = convertedName;
                        }
                        $(this).before(' <span class="error-message error">*' + name +
                            ' is required</span>');
                        if (isFirstIteration) {

                            isFirstIteration = false;
                            $(this).css('border', '1px solid red');
                            // $(this).focus();
                        }






                    } else {
                        $(this).removeClass('error'); // Optionally, add a CSS class for styling
                        $(this).siblings('label').removeClass('error');
                        $(this).siblings('.error-message').remove();
                        $(this).css('border', '');
                        if ($(this).attr('type') === 'email' && !isValidEmail($(this).val())) {
                            var name = $(this).siblings('label').text().trim(); // Get label text
                            if (!name) {
                                name = $(this).attr(
                                    'name'); // If label text is empty, get the name attribute
                                var parts = name.split('[question]').filter(Boolean);

                                // Join the parts with spaces
                                var convertedName = parts.join('Question ');
                                convertedName = convertedName.replace(
                                    /\[|\]|\_/g, ' ').trim();
                                name = convertedName;
                            }

                            name += ' Invalid email';
                            isValid = false;
                            $(this).before(' <span class="error-message error">*' + name +
                                '</span>');
                            if (isFirstIteration) {

                                isFirstIteration = false;
                                var errorPosition = $(this).siblings('.error-message').offset().top;
                                $('html, body').animate({
                                    scrollTop: (errorPosition - 50)
                                }, 500);

                                $(this).css('border', '1px solid red');
                                $(this).focus();
                            }

                        }
                    }


                });

                // Call the validation function when the form is submitted
                if (isValid) {

                    var $modal = $form.closest('.modal');
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: new FormData(this),
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            // Check if validation failed
                            if (data.errors) {
                                // Display validation errors in the modal
                                $.each(data.errors, function(key, value) {
                                    $('#' + key + '_error').html(value[0]);
                                });
                            } else {
                                // Validation passed, you can close the modal or perform other actions
                                // $('#exampleModalLarge').modal('hide');
                                if (data.status) {
                                    swal.fire(
                                        'Success!',
                                        data.Message,
                                        'success').then(function() {

                                        $form.find(':input:not([name="_token"])').val(
                                            '');;
                                        $modal.modal('hide');
                                        debugger
                                    });

                                }
                            }
                        }
                    });
                } else {
                    return false
                }



            });

            function isValidEmail(email) {
                // Use a regular expression to check for a valid email format
                var emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i;
                return emailRegex.test(email);
            }
    </script>
@endsection
