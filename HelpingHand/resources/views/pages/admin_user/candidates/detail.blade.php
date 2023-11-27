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
            Candidate
        @endslot
        @slot('li_3')
            Create
        @endslot
        @slot('title')
            candidates
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



                                    @if ($auth_user->hasRole('HIMSubUser'))
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label">Candidate Summary</label>
                                                <div>
                                                    @if (isset($candidate->summary[0]))
                                                        {!! $candidate->summary[0]->description !!}
                                                    @else
                                                        N/A
                                                    @endif


                                                </div>

                                            </div>
                                        </div>
                                        @include('pages.candidates.summary')
                                    @endif



                                </div>
                            @endif


                        </div><!-- end col -->

                    </div><!-- end row -->


                    <div class="row align-items-center">
                        <hr>
                        <div class="col">
                            @if ($auth_user->hasRole('HIMSubUser'))

                                @if ($candidate->is_screened == 1)
                                    <a class=" btn btn-sm btn-soft-success" id="show_jobs"><i
                                            class="fas fa-plus me-2"></i>Send
                                        Candidate To</a>
                                    <form action="{{ route('refer_candidate') }}" method="post" id="refer_form"
                                        class="m-2" style="display: none">
                                        @csrf
                                        <input type="hidden" name="candidate_id"
                                            value="{{ base64_encode($candidate->id) }}">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="mb-3">Select Organization</label>
                                                <select name="client_id" id="client_select" class="select2 mb-3 select2"
                                                    style="width: 100%" data-placeholder="Choose">
                                                    <option value="">
                                                        Select Organization
                                                    </option>
                                                    @foreach ($client_list as $item)
                                                        <option value="{{ $item->id }}">
                                                            {{ $item->org_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="mb-3">Select Job</label>
                                                <select name="job_id" id="job_select" class="select2 mb-3 select2"
                                                    style="width: 100%" data-placeholder="Choose">

                                                </select>
                                            </div>
                                            <div class="col-md-6 mt-2">

                                                <label for="">Tailored Summary</label>
                                                @if (isset($candidate->summary[0]))
                                                <textarea rows="4" name="summary" class="form-control" parsley-type="summary"> {!! $candidate->summary[0]->description !!}</textarea>
                                            @else
                                                <textarea rows="4" name="summary" class="form-control" parsley-type="summary"> </textarea>
                                            @endif


                                            </div>


                                        </div>
                                        <div class="row m-2">
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

    @if ($auth_user->hasRole('HIMSubUser'))
        @component('components.apply_list')
            @slot('applied', $applied)
        @endcomponent
    @endif

    <div class="modal fade" id="exampleModalLogin" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalDefaultLogin" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="exampleModalDefaultLogin">Select Date and Time For Interview</h6>
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
                                    <input type="hidden" name="candidate_id"
                                        value="{{ base64_encode($candidate->id) }}">
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
                                                            <input class="form-control timepicker"
                                                                name="interview[0][time]" id=""
                                                                placeholder="Check time">
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
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // $('#refer_form').hide();
            $('#show_jobs').on('click', function() {
                console.log('okay');
                $('#refer_form').toggle();

            });
            // $('#client_select').select2();
            $('#client_select').on('change', function() {
                // Get the selected hard_skills
                const selectedclient = $(this).val();
                debugger
                // Clear and repopulate the skill_detail select
                $('#job_select').empty();

                // Iterate over skill categories

                @foreach ($job_list as $key => $item)
                    console.log('{{ $key }}');
                    if ($.inArray('{{ $key }}', selectedclient) !== -1) {
                        $('#job_select').append($('<option>', {
                                value: '',
                                text: 'Select Job'
                            }));
                        @foreach ($item as $job)
                            $('#job_select').append($('<option>', {
                                value: '{{ $job['id'] }}',
                                text: '{{ $job['vacant_position'] }}'
                            }));
                        @endforeach
                    }
                @endforeach

                // Refresh the Select2 for the skill_detail select
                $('#skill_detail_select').trigger('change');
            });
        })
    </script>
@endsection
