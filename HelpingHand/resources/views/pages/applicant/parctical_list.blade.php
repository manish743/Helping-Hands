@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"
        type="text/css" />
    <link href="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap5.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css') }}" rel="stylesheet">
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            HIM
        @endslot
        @slot('li_2')
            Dashboard
        @endslot
        {{-- @slot('li_3')
            Analytics
        @endslot --}}
        @slot('title')
            Dashboard
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card m-2">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Practical Evaluation List</h4>
                        </div><!--end col-->
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive browser_users">
                        <table id="datatable"class=" table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-top-0">Applicant Name</th>
                                    <th class="border-top-0">Email</th>
                                    <th class="border-top-0">Job Vacant Position</th>

                                    <th class="border-top-0">Case Study Material</th>
                                    <th class="border-top-0">Case Study Submission Date</th>
                                    <th class="border-top-0">Case Study</th>
                                    <th class="border-top-0">Panel Confirmation</th>
                                    <th class="border-top-0">Action</th>
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                @foreach ($job_applicant_list as $item)
                                    @php
                                        $id = base64_encode($item->id);
                                    @endphp
                                    <tr data-id="{{ $id }}">
                                        <td class="border-top-0">
                                            {{ $item->candidate->first_name . ' ' . $item->candidate->last_name }}</td>
                                        <td class="border-top-0">{{ $item->candidate->email }}</td>
                                        <td class="border-top-0">{{ $item->job->vacant_position }}</td>

                                        <td class="border-top-0">
                                            @if ($item->case_study)
                                                Sent
                                            @else
                                                Not Sent
                                            @endif
                                        </td>
                                        <td class="border-top-0">
                                            @if ($item->case_study)
                                                {{ $item->case_study->submission_date }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="border-top-0">
                                            @if ($item->case_study)
                                                @if ($item->case_study->case_study)
                                                    <div class="btn btn-sm btn-soft-primary">Received</div>
                                                @else
                                                    <div class="btn btn-sm btn-soft-warning">Not received</div>
                                                @endif
                                            @else
                                                <div class="btn btn-sm btn-soft-warning">N/A</div>
                                            @endif
                                        </td>
                                        <td class="border-top-0">
                                            {{ $item->panel_confirmed()->where('confirmed', 1)->count() }}/
                                            {{ $item->panels->count() }}
                                        </td>
                                        <td>

                                            {{-- <a href="{{ route('applicant-stage_review', $id) }}"
                                                class="btn btn-sm btn-success text-wgite"><i class="fas fa-eye me-1"></i>
                                                view</a> --}}

                                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user"
                                                data-bs-toggle="dropdown" href="#" role="button"
                                                aria-haspopup="false" aria-expanded="false">
                                                <span class="ms-1 nav-user-name hidden-sm">
                                                </span>
                                                <i data-feather="more-vertical"
                                                    class="align-self-center icon-xs icon-dual me-1"data-toggle="tooltip"
                                                    title="Action"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item"
                                                    href="{{ route('applicant-stage_view', base64_encode($item->id)) }}"><i
                                                        data-feather="edit-2"
                                                        class="align-self-center icon-xs icon-dual me-1"></i> View
                                                    Applicant</a>
                                                {{-- <a class="dropdown-item"
                                                    href="{{ route('jobs-applicants-panel_scoring', base64_encode($item->id)) }}"><i
                                                        data-feather="edit-2"
                                                        class="align-self-center icon-xs icon-dual me-1"></i> Panel Scoring</a> --}}

                                                @if ($item->case_study)
                                                    <a class="dropdown-item extend_submission_date" href="#"
                                                        data-bs-toggle="modal" data-bs-target="#extend_submission_date"
                                                        data-job_applicant_id="{{ base64_encode($item->id) }}"><i
                                                            data-feather="edit-2"
                                                            class="align-self-center icon-xs icon-dual me-1"></i> Extend
                                                        Submission date</a>

                                                    @if ($item->case_study->case_study)
                                                        @if ($item->panels->count() < 1)
                                                            <a class="dropdown-item schedule_panel" href="#"
                                                                data-bs-toggle="modal" data-bs-target="#send_schedule_panel"
                                                                data-job_applicant_id="{{ base64_encode($item->id) }}"><i
                                                                    data-feather="trash-2"
                                                                    class="align-self-center icon-xs icon-dual me-1"></i>
                                                                Send
                                                                Schedule to Panel</a>
                                                        @else
                                                            <a class="dropdown-item reschedule_panel" href="#" data-bs-toggle="modal"
                                                                data-bs-target="#reschedule_panel"
                                                                data-job_applicant_id="{{ base64_encode($item->id) }}"><i
                                                                    data-feather="trash-2"
                                                                    class="align-self-center icon-xs icon-dual me-1"></i>
                                                                Reschedule Panel</a>
                                                        @endif

                                                        <div class="dropdown-divider mb-0"></div>

                                                        <a class="dropdown-item schedule_applicant" href="#"
                                                            data-bs-toggle="modal" data-bs-target="#send_schedule_applicant"
                                                            data-job_applicant_id="{{base64_encode($item->id)}}">
                                                            <i data-feather="check"
                                                                class="align-self-center icon-xs icon-dual me-1"></i>
                                                            <span key="t-logout">Schedule Presentation with
                                                                {{ $item->panel_confirmed()->where('confirmed', 1)->count() }}
                                                                Panel </span>
                                                        </a>
                                                    @else
                                                        <a class="dropdown-item schedule_panel disabled" href="#"
                                                            data-bs-toggle="modal" data-bs-target="#send_schedule_panel"
                                                            data-job_applicant_id="{{ base64_encode($item->id) }}"><i
                                                                data-feather="trash-2"
                                                                class="align-self-center icon-xs icon-dual me-1"></i>
                                                            Send
                                                            Schedule to Panel</a>
                                                        <div class="dropdown-divider mb-0"></div>
                                                        <a class="dropdown-item disabled"
                                                            href="{{ route('add_case_study', base64_encode($item->id)) }}">
                                                            <i data-feather="check"
                                                                class="align-self-center icon-xs icon-dual me-1"></i>
                                                            <span key="t-logout">Schedule Presentation with

                                                                Panel </span>
                                                        </a>
                                                    @endif
                                                @else
                                                    <a class="dropdown-item send_material" href="#"
                                                        data-bs-toggle="modal" data-bs-target="#send_material"
                                                        data-job_applicant_id="{{ base64_encode($item->id) }}"><i
                                                            data-feather="edit-2"
                                                            class="align-self-center icon-xs icon-dual me-1"></i> Send
                                                        Study
                                                        Material</a>
                                                    <a class="dropdown-item schedule_panel disabled" href="#"
                                                        data-bs-toggle="modal" data-bs-target="#send_schedule_panel"
                                                        data-job_applicant_id="{{ base64_encode($item->id) }}"><i
                                                            data-feather="trash-2"
                                                            class="align-self-center icon-xs icon-dual me-1"></i>
                                                        Send
                                                        Schedule to Panel</a>
                                                    <div class="dropdown-divider mb-0"></div>
                                                    <a class="dropdown-item disabled"
                                                        href="{{ route('add_case_study', base64_encode($item->id)) }}">
                                                        <i data-feather="check"
                                                            class="align-self-center icon-xs icon-dual me-1"></i>
                                                        <span key="t-logout">Schedule Presentation with

                                                            Panel </span>
                                                    </a>
                                                @endif



                                            </div>

                                        </td>
                                    </tr><!--end tr-->
                                @endforeach



                            </tbody>
                        </table> <!--end table-->
                    </div><!--end /div-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="send_schedule_applicant" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-white">Send Schedule to Applicant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->
                <div class="modal-body">
                    <form action="{{ route('applicant_schedule_applicant') }}" class="modal_form" method="post"
                        id="schedule_applicant_form" enctype="multipart/form-data" novalidate>
                        @csrf
                        <input type="hidden" name="job_applicant_id" class="job_applicant_id" value="">
                        <input type="hidden" name="interview_option_id" class="interview_option_id" value="">
                        <fieldset>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row d-flex align-items-end">

                                        <div class="col-lg-6 col-md-12">
                                            <label class="form-label">Date</label>
                                            <input required type="date" required name="interview_date"
                                                class="form-select">
                                            {{-- <input type="text" required name="interview[0][date]" class="form-control mdate" placeholder="2017-06-04"> --}}
                                            <span class="text-danger error-container" id="">
                                                @error('date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div><!--end col-->

                                        <div class="col-lg-6 col-md-12">
                                            <label class="form-label">Time</label>
                                            {{-- <input type="time" required name="interview[0][time]"
                                                    class="form-control"> --}}
                                            <input required type="time" class="form-control " name="interview_time"
                                                id="" placeholder="Check time">

                                            <span class="text-danger error-container" id="">
                                                @error('time')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div><!--end col-->
                                        <div class="col-lg-6 col-md-12 mt-2">
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                    <input required class="form-check-input" type="checkbox"
                                                        name="send_case_study" value="1">
                                                    <label class="form-check-label" for="inlineCheckbox3">Send Case Study
                                                        File To Panels </label>

                                                </div>
                                                <span class="text-danger">
                                                    @error('terms_agree')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div><!--end col-->
                                    </div>
                                </div>

                                <div class="col-2">
                                    <button class="btn btn-sm btn-outline-primary" type="submit"> Submit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>


                </div><!--end modal-body-->

            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div><!--end modal-->
    <div class="modal fade bd-example-modal-lg" id="send_schedule_panel" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-white">Send Schedule to Pannel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->
                <div class="modal-body">
                    <form action="{{ route('applicant_schedule_panel') }}" class="modal_form" method="post"
                        id="schedule_panel_form" enctype="multipart/form-data" novalidate>
                        @csrf
                        <input type="hidden" name="job_applicant_id" class="job_applicant_id" value="">
                        <fieldset>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row d-flex align-items-end">

                                        <div class="col-lg-6 col-md-12">
                                            <label class="form-label">Date</label>
                                            <span class="text-danger error-container" id="interview_date_error">
                                                @error('date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            <input required type="date" required name="interview_date"
                                                class="form-select">
                                            {{-- <input type="text" required name="interview[0][date]" class="form-control mdate" placeholder="2017-06-04"> --}}

                                        </div><!--end col-->

                                        <div class="col-lg-6 col-md-12">
                                            <label class="form-label">Time</label>
                                            {{-- <input type="time" required name="interview[0][time]"
                                                    class="form-control"> --}}
                                            <span class="text-danger error-container" id="interview_time_error">
                                                @error('time')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            <input required class="form-control timepicker" name="interview_time"
                                                id="" placeholder="Check time">


                                        </div><!--end col-->
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row d-flex align-items-end">
                                        <fieldset>
                                            <div class="repeater-default">
                                                <div data-repeater-list="panel">
                                                    <div data-repeater-item="">
                                                        <div class="form-group row d-flex align-items-end">
                                                            <div class="col-sm-5">
                                                                <label class="form-label">Panel Name</label>
                                                                <input required type="text" required
                                                                    name="panel[0][name]" class="form-control"
                                                                    placeholder="Panel Name">
                                                                <span class="text-danger error-container" id="name_error">
                                                                    @error('name')
                                                                        {{ $message }}
                                                                    @enderror
                                                                </span>

                                                            </div><!--end col-->

                                                            <div class="col-sm-5">
                                                                <label class="form-label">Panel Email</label>

                                                                <input required type="email" class="form-control"
                                                                    name="panel[0][email]" id=""
                                                                    placeholder="Panel Email">

                                                                <span class="text-danger error-container"
                                                                    id="email_error">
                                                                    @error('email')
                                                                        {{ $message }}
                                                                    @enderror
                                                                </span>
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
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-sm btn-outline-primary" type="submit"> Submit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>


                </div><!--end modal-body-->

            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div><!--end modal-->
    <div class="modal fade bd-example-modal-lg" id="reschedule_panel" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-white">Reschedule Presentation Date</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->
                <div class="modal-body">
                    <form action="{{ route('applicant_reschedule_panel') }}" class="modal_form" method="post"
                        id="reschedule_panel_form" enctype="multipart/form-data" novalidate>
                        @csrf
                        <input type="hidden" name="job_applicant_id" class="job_applicant_id" value="">
                        <fieldset>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group row d-flex align-items-end">

                                        <div class="col-lg-6 col-md-12">
                                            <label class="form-label">Date</label>
                                            <span class="text-danger error-container" id="interview_date_error">
                                                @error('date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            <input required type="date" required name="interview_date"
                                                class="form-select">
                                            {{-- <input type="text" required name="interview[0][date]" class="form-control mdate" placeholder="2017-06-04"> --}}

                                        </div><!--end col-->

                                        <div class="col-lg-6 col-md-12">
                                            <label class="form-label">Time</label>
                                            {{-- <input type="time" required name="interview[0][time]"
                                                    class="form-control"> --}}
                                            <span class="text-danger error-container" id="interview_time_error">
                                                @error('time')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            <input required class="form-control timepicker" name="interview_time"
                                                id="" placeholder="Check time">


                                        </div><!--end col-->
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="form-group row d-flex align-items-end">
                                        <fieldset>
                                            <div class="repeater-default">
                                                <div data-repeater-list="panel">
                                                    <div data-repeater-item="">
                                                        <div class="form-group row d-flex align-items-end">
                                                            <div class="col-sm-5">
                                                                <label class="form-label">Panel Name</label>
                                                                <input required type="text" required
                                                                    name="panel[0][name]" class="form-control"
                                                                    placeholder="Panel Name">
                                                                <span class="text-danger error-container" id="name_error">
                                                                    @error('name')
                                                                        {{ $message }}
                                                                    @enderror
                                                                </span>

                                                            </div><!--end col-->

                                                            <div class="col-sm-5">
                                                                <label class="form-label">Panel Email</label>

                                                                <input required type="email" class="form-control"
                                                                    name="panel[0][email]" id=""
                                                                    placeholder="Panel Email">

                                                                <span class="text-danger error-container"
                                                                    id="email_error">
                                                                    @error('email')
                                                                        {{ $message }}
                                                                    @enderror
                                                                </span>
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
                                    </div>
                                </div> --}}
                                <div class="col-2">
                                    <button class="btn btn-sm btn-outline-primary" type="submit"> Submit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>


                </div><!--end modal-body-->

            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div><!--end modal-->
    <div class="modal fade bd-example-modal-lg" id="send_material" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-white">Send Case Study Material</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->
                <div class="modal-body">
                    <form action="{{ route('applicant_add_study_material') }}" class="modal_form" method="post"
                        id="send_material_form" enctype="multipart/form-data" novalidate>
                        @csrf
                        <input type="hidden" name="job_applicant_id" class="job_applicant_id" value="">
                        <fieldset>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">Upload your Case Study Material</label>

                                        <input type="file" id="input-file-now-custom-2" name="case_study_material"
                                            class="dropify" data-height="100" />


                                        <span class="text-danger error-container" id="case_study_material_error">
                                            @error('case_study_material')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>
                                <div class="col-12">

                                    <div class="form-group row d-flex align-items-end">

                                        <div class="col-lg-6 col-md-12">
                                            <label class="form-label">Date</label>
                                            <input type="date" required name="date" class="form-select">
                                            {{-- <input type="text" required name="interview[0][date]" class="form-control mdate" placeholder="2017-06-04"> --}}
                                            <span class="text-danger error-container" id="date_error">
                                                @error('date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div><!--end col-->

                                        <div class="col-lg-6 col-md-12">
                                            <label class="form-label">Time</label>
                                            {{-- <input type="time" required name="interview[0][time]"
                                                    class="form-control"> --}}
                                            <input class="form-control timepicker" name="time" id=""
                                                placeholder="Check time">

                                            <span class="text-danger error-container" id="time_error">
                                                @error('time')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div><!--end col-->




                                    </div>

                                </div>
                                <div class="col-2">
                                    <button class="btn btn-sm btn-outline-primary" type="submit"> Submit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>


                </div><!--end modal-body-->

            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div><!--end modal-->
    <div class="modal fade bd-example-modal-lg" id="extend_submission_date" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="text-white">Extend Submission Date</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->
                <div class="modal-body">
                    <form action="{{ route('applicant_extend_submission_date') }}" class="modal_form" method="post"
                        id="extend_submission_date_form" enctype="multipart/form-data" novalidate>
                        @csrf
                        <input type="hidden" name="job_applicant_id" class="job_applicant_id" value="">
                        <input type="hidden" name="case_study_id" class="case_study_id" value="">
                        <fieldset>
                            <div class="row">

                                <div class="col-12">

                                    <div class="form-group row d-flex align-items-end">
                                        <div class="col-lg-6 col-md-12">
                                            <label class="form-label">Date</label>
                                            <input required type="date" required name="submission_date"
                                                class="form-select">
                                            {{-- <input type="text" required name="interview[0][date]" class="form-control mdate" placeholder="2017-06-04"> --}}
                                            <span class="text-danger error-container" id="submission_date_error">
                                                @error('date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div><!--end col-->

                                        <div class="col-lg-6 col-md-12">
                                            <label class="form-label">Time</label>
                                            {{-- <input type="time" required name="interview[0][time]"
                                                    class="form-control"> --}}
                                            <input required type="time" class="form-control " name="submission_time"
                                                id="" placeholder="Check time">

                                            <span class="text-danger error-container" id="submission_time_error">
                                                @error('time')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div><!--end col-->
                                        <div class="col-lg-6 col-md-12">
                                            <label class="form-label">Add Days</label>
                                            <input type="number" required name="add_day" class="form-control">
                                            {{-- <input type="text" required name="interview[0][date]" class="form-control mdate" placeholder="2017-06-04"> --}}
                                            <span class="text-danger error-container" id="add_day_error">
                                                @error('add_day')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div><!--end col-->
                                    </div>

                                </div>
                                <div class="col-2">
                                    <button class="btn btn-sm btn-outline-primary" type="submit"> Submit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>


                </div><!--end modal-body-->

            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div><!--end modal-->
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // Function to open the modal and set hidden input values
            $('.send_material').click(function() {
                // Replace 'item.id' and 'item.candidate.name' with actual values
                var form = $('#send_material_form');
                form.find('.error-container').empty();
                var applicantId = $(this).data('job_applicant_id'); // Example: item.id

                form.find('.job_applicant_id').val(applicantId)
                debugger

            });
            $('.schedule_panel').click(function() {
                // Replace 'item.id' and 'item.candidate.name' with actual values
                var form = $('#schedule_panel_form');
                form.find('.error-container').empty();
                var applicantId = $(this).data('job_applicant_id'); // Example: item.id

                form.find('.job_applicant_id').val(applicantId)
                debugger

            });
            $('.reschedule_panel').click(function() {
                // Replace 'item.id' and 'item.candidate.name' with actual values
                var form = $('#reschedule_panel_form');
                form.find('.error-container').empty();
                var applicantId = $(this).data('job_applicant_id'); // Example: item.id

                form.find('.job_applicant_id').val(applicantId)
               

            });
            $('.extend_submission_date').click(function() {
                // Replace 'item.id' and 'item.candidate.name' with actual values
                var applicantList = @json($job_applicant_list);
                var form = $('#extend_submission_date_form');
                form.find('.error-container').empty();
                var applicantId = $(this).data('job_applicant_id'); // Example: item.id
                var decoded_applicant_id= atob(applicantId);
                var applicant = applicantList.find(function(item) {
                    // console.log(item);
                    return item.id == decoded_applicant_id;
                });
                console.log(applicant.case_study);
                if (applicant.case_study) {
                    console.log(applicant.case_study.submission_date);
                    console.log(applicant.case_study.submission_time);
                    form.find('input[name="submission_date"]').val(applicant.case_study
                        .submission_date)
                    form.find('input[name="submission_date"]').prop('readonly', true);
                    form.find('input[name="submission_time"]').val(applicant.case_study
                        .submission_time)
                    form.find('input[name="submission_time"]').prop('readonly', true);
                    form.find('.case_study_id').val(btoa(applicant.case_study.id));
                    // interview_option_id
                }
                form.find('.job_applicant_id').val(applicantId)
                debugger

            });
            $('.schedule_applicant').click(function() {
                // Replace 'item.id' and 'item.candidate.name' with actual values
                var applicantList = @json($job_applicant_list);
                console.log(applicantList);
                var form = $('#schedule_applicant_form');
                form.find('.error-container').empty();
                var applicantId = $(this).data('job_applicant_id'); // Example: item.id
                var applicant = applicantList.find(function(item) {
                    // console.log(item);
                    return item.id == atob(applicantId);
                });
                console.log(applicant.panel_interview_option);
                if (applicant.panel_interview_option[0]) {
                    console.log(applicant.panel_interview_option[0].interview_date);
                    console.log(applicant.panel_interview_option[0].interview_time);
                    form.find('input[name="interview_date"]').val(applicant.panel_interview_option[0]
                        .interview_date)
                    form.find('input[name="interview_date"]').prop('readonly', true);
                    form.find('input[name="interview_time"]').val(applicant.panel_interview_option[0]
                        .interview_time)
                    form.find('input[name="interview_time"]').prop('readonly', true);
                    form.find('.interview_option_id').val(btoa(applicant.panel_interview_option[0].id));
                    // interview_option_id
                }
                console.log(applicant.panel_interview_option.length);
                form.find('.job_applicant_id').val(applicantId)
                debugger

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
                                    $form.find('#' + key + '_error').html(value[0]);
                                    debugger
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
                    }).fail((message) => {
                        console.log(typeof message);
                        console.log(message);
                        message = JSON.parse(message.responseText);
                        for (var key in message.errors) {
                            console.log(key + " - " + message.errors[key]);
                            swal.fire(
                                'Cancelled',
                                'Job is still Open :)',
                                'error'
                            )
                        }
                        
                            console.log(key + " - " + message.message);
                            swal.fire(
                                'Error',
                                message.message,
                                'error'
                            )
                        
                    });;
                } else {
                    return false
                }



            });

            function isValidEmail(email) {
                // Use a regular expression to check for a valid email format
                var emailRegex = /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i;
                return emailRegex.test(email);
            }
        });
    </script>
@endsection
