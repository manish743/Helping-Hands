@extends('layouts.master-without_nav')
@section('title')
    Dashboard
@endsection
@section('css')
@endsection

@section('content')


    <body class="account-body accountbg">


        <div class="container">
            @if (Session::has('success'))
                <div class="alert alert-success text-center">
                    {{ Session::get('success') }}
                </div>
            @endif

            <div class="row p-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">


                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Applicant Stage {{ $applicant->stage_id }} :
                                        {{ $job->vacant_position }}
                                    </h4>
                                </div><!--end col-->

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

            {{-- @if (!$applicant->stage_complete) --}}

            <div class="row p-3">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Scoring/ Practical Evaluation</h4>
                                </div><!--end col-->

                            </div>
                        </div><!--end card-header-->
                        <div class="card-body bootstrap-select-1">
                            @if (isset($applicant->panel_interview_option[0]))
                                <div class="row">
                                    <h4 class="card-title text-success mb-1">
                                        {{-- Panlels Scheduled:
                                        {{ $applicant->panel_interview_option[0]->interview_date . ' at ' . $applicant->panel_interview_option[0]->interview_time }} --}}
                                        <div class="countdown">
                                            Page Expires in:
                                            <span class="demo"></span>
                                        </div>
                                    </h4>



                                </div> <!--end row-->
                            @endif
                            @if ($panel_score)
                                <div id="case_study_success">
                                    <h3 class="text-success">Score received!!</h3>
                                    <h3 class="text-success">Thank You</h3>
                                </div>
                            @else
                                <form action="{{ route('jobs-applicants-panel_score_submit') }}" id="myForm"
                                    method="post">
                                    @csrf

                                    <input type="hidden" name="job_applicant_id"
                                        value={{ base64_encode($applicant->id) }}>
                                    <input type="hidden" name="panel_id" value={{ base64_encode($panel_id) }}>
                                    <input type="hidden" name="job_id" value={{ base64_encode($applicant->job_id) }}>
                                    <input type="hidden" name="stage_id"
                                        value={{ base64_encode($applicant->stage_id) }}>

                                    <div class="row">
                                        <div class="col-12">


                                            @php
                                                if (isset($job_stage_weight[4])) {
                                                    $stage1_stage = $job_stage_weight[4]->pluck('stage_weight', 'stage_id')->unique();
                                                    $stage1 = $job_stage_weight[4]->pluck('competency_weight', 'competency');
                                                }
                                            @endphp
                                            <h4 class="card-title">Stage 4</h4>



                                            @if (in_array(4, $stages))

                                                @if ($stages_question->has(4))
                                                    @foreach ($stages_question[4] as $competency => $question)
                                                        <fieldset id="hard" class="field-set "
                                                            data-count="{{ $loop->iteration }}">
                                                            <div class="row">
                                                                <div class="">
                                                                    <div class="repeat-list">
                                                                        <div
                                                                            class="form-group row ms-2 my-2 d-flex align-items-end">
                                                                            <div class="col-lg-6">
                                                                                <div class="">
                                                                                    <h6 class="">
                                                                                        {{ $question->question }}
                                                                                    </h6>
                                                                                    <input type="text"
                                                                                        name="stage[4][{{ $question->question }}]"
                                                                                        class="range_selector">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div><!--end row-->
                                                                </div>
                                                            </div><!--end row-->
                                                        </fieldset>
                                                    @endforeach
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-6 m-2">
                                                        <label for="">Feedback</label>
                                                        <span class="text-danger">
                                                            @error('feedback')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                        <textarea rows="4" name="feedback" required class="form-control" parsley-type="reason"></textarea>
                                                    </div>
                                                </div>

                                            @endif
                                            <!--end /div-->

                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                    <div class="row align-items-center">
                                        <hr>
                                        <div class="col">
                                            @if ($applicant->is_rejected == 0)
                                                <button class=" btn btn-sm btn-soft-primary" type="submit">Submit Your
                                                    Scoring</button>

                                                {{-- <a class=" btn btn-sm btn-soft-danger" id="show_jobs">Reject</a> --}}
                                            @endif
                                        </div><!--end col-->
                                    </div>

                                </form>
                            @endif


                        </div> <!-- end card -->
                    </div> <!-- end col -->

                </div>


            </div>
            <div id="case_study_success" class='d-none'>
                <h3 class="text-success">Score received!!</h3>
                <h3 class="text-success">Thank You</h3>
            </div>
    </body>


    {{-- @if ($auth_user->hasRole('HIMSubUser')) --}}
    {{-- @component('components.apply_list')
        @slot('applied', $applied)
    @endcomponent --}}
    {{-- @endif --}}
@endsection


@section('script')
    <script>
        $(document).ready(function() {
            $('#myForm').on('submit', function(event) {
                event.preventDefault();

                var $form = $(this);
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
                            swal.fire(
                                'Error!',
                                'Error in submitting form',
                                'error');
                        } else {

                            if (data.status) {
                                swal.fire(
                                    'Success!',
                                    data.Message,
                                    'success').then(function() {
                                    $success = $('#case_study_success').clone();
                                    $('#case_study_success').remove();
                                    $success.removeClass('d-none');
                                    $form.replaceWith($success);
                                });

                            }
                        }
                    }
                });
            });
        })
    </script>
    <script>
        // Set the date we're counting down to
        var countDownDate = new Date();
        countDownDate.setMinutes(countDownDate.getMinutes() + {{ $minutesDifference }});

        // Update the countdown every 1 second
        var x = setInterval(function() {

            // Get the current date and time
            var now = new Date().getTime();

            // Calculate the remaining time
            var distance = countDownDate - now;

            // Calculate minutes and seconds
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the countdown
            $(".demo").text(minutes + "m " + seconds + "s ");

            // If the countdown is over, display a message
            if (distance < 0) {
                clearInterval(x);
                $(".demo").text("EXPIRED");
            }
        }, 1000);
    </script>
@endsection
