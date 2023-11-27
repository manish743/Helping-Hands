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
                            <h4 class="card-title">Applicant Review Stage {{ $applicant->stage_id }} :
                                {{ $job->vacant_position }}</h4>
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


                        </div><!-- end col -->
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
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Interviewer Name:</label>
                                        <div>
                                            {{ $feedback->created_user->first_name . ' ' . $feedback->created_user->last_name }}

                                        </div>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Action</label>
                                        <div>
                                            {{ $feedback->is_rejected ? 'Rejected' : 'Recommended' }}

                                        </div>

                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">Feedback/Reason</label>
                                        <div>
                                            @if ($feedback->is_rejected)
                                                {!! $feedback->reason !!}
                                            @else
                                                {!! $feedback->summary !!}
                                            @endif


                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                    </div> <!--end row-->
                    <form action="{{ route('applicant-review_proceed') }}" method="post">
                        @csrf
                        <input type="hidden" name="job_applicant_id" value="{{ base64_encode($applicant->id) }}">
                        <div class="row">

                            <label class="form-label">Choose what to do:</label>
                            <span class="text-danger">
                                @error('stage')
                                    {{ $message }}
                                @enderror
                            </span>
                            <div class="col-auto align-self-center">
                                <input type="radio" class="btn-check" name="stage" id="success-outlined"
                                    autocomplete="off" value="Hire">
                                <label class="btn btn-outline-success btn-sm" for="success-outlined">Hire</label>
                                @php
                                    $stage_status = json_decode($job->stages);
                                @endphp

                                @foreach ($stage_status as $stage)
                                    <input type="radio" class="btn-check " name="stage"
                                        id="danger-outlined{{ $stage }}" autocomplete="off"
                                        value="{{ $stage }}">
                                    <label
                                        class="btn btn-outline-primary btn-sm {{ $stage <= $applicant->stage_id ? 'd-none' : '' }}"
                                        for="danger-outlined{{ $stage }}">Stage {{ $stage }}</label>
                                @endforeach
                                {{-- <input type="radio" class="btn-check {{ 2>$applicant->stage_id?'':'d-none' }}" name="stage" id="danger-outlined" autocomplete="off" value="2">
                            <label class="btn btn-outline-primary btn-sm" for="danger-outlined">Stage 2</label>
                            <input type="radio" class="btn-check {{ 3>$applicant->stage_id?'':'d-none' }}" name="stage" id="danger-outlined3" autocomplete="off" value="3">
                            <label class="btn btn-outline-primary btn-sm" for="danger-outlined3">Stage 3</label>
                            <input type="radio" class="btn-check {{ 4>$applicant->stage_id?'':'d-none' }}" name="stage" id="danger-outlined4" autocomplete="off" value="4">
                            <label class="btn btn-outline-primary btn-sm" for="danger-outlined4">Stage 4</label>
                            <input type="radio" class="btn-check {{ 5>$applicant->stage_id?'':'d-none' }}" name="stage" id="danger-outlined5" autocomplete="off" value="5">
                            <label class="btn btn-outline-primary btn-sm" for="danger-outlined5">Stage 5</label> --}}
                                <input type="radio" class="btn-check" name="stage" id="danger-outlined6"
                                    autocomplete="off" value="reject">
                                <label class="btn btn-outline-danger btn-sm" for="danger-outlined6">Reject</label>


                            </div>


                        </div> <!--end row-->
                        <div class="row mt-3">
                            <div class="col-auto align-self-center">
                                <button class=" btn btn-sm btn-soft-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>

                </div><!-- end card-body -->

            </div> <!-- end card -->
        </div> <!-- end col -->

    </div>



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
    </script>
@endsection
