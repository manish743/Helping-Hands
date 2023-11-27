@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('css')
    <style>
        .question-suggestions option:hover {
            background-color: blue;
            color: white;
        }
    </style>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            HIM
        @endslot
        @slot('li_2')
            Job
        @endslot
        @slot('li_3')
            Create
        @endslot
        @slot('title')
            Job
        @endslot
    @endcomponent
    {{-- <input type="number" id="question-weight" class="weight d-none" placeholder="Score weight eg 15% only number"> --}}
    <span id="question-weight" class="mx-2" ><input required type="number" class="form-control question-weight"
        placeholder="Score weight eg 15% only number"/></span>
    <div id="repeat_temp" class="repeat d-none">
        <div class="repeat-list" data-repeater-list="hard[0][question]">
            <div class="repeat-item" data-repeater-item="hard[0][question]">

                <div class="form-group row ms-2 my-2 d-flex align-items-end">
                    <div class="col">
                        {{-- <label class="form-label">Question</label> --}}
                        <input required type="text" name="hard[0][question]"
                            placeholder="Question e.g : lorem ipsum a b c?" class="form-control question-input" />
                        <div class="question-suggestions"></div>

                    </div><!--end col-->
                    <div class="col-2 text-align-right">
                        <div data-repeater-delete="" class="btn btn-sm btn-outline-danger float-right">
                            <div class="far fa-trash-alt me-1">
                            </div>
                        </div>
                    </div><!--end col-->

                </div>

            </div><!--end col-->
        </div><!--end row-->
        <div class="row m-2 mx-3 align-items-center">
            <div class="col-7">

            </div><!--end col-->
            <div class="col-auto align-self-center">
                <span data-repeater-create="" data-repeater-list="" class="btn btn-sm btn-soft-primary">
                    <span class="fa fa-plus"></span> Add Question
                </span>
            </div>


            {{-- <a class=" btn btn-sm btn-soft-primary" href="{{ route('client-add') }}" role="button"><i
            class="fas fa-plus me-2"></i>New Client</a> --}}
        </div>

    </div>
    <!--end repeter-->
    <fieldset id="soft" class="field-set d-none" data-count="0">

        <div class="row">

            <div class="col-sm-11">

                <select name="soft[0][skill]" class="form-select">
                    <option value="">Select Skills</option>
                    @foreach ($soft as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                    @endforeach

                </select>
            </div><!--end col-->
            <div class="col text-align-right temp1">
                <div class="btn btn-sm btn-outline-danger float-right skill_delete">
                    <div class="far fa-trash-alt me-1"></div>
                </div>
            </div><!--end col-->
            <div class="repeat d-none">
                <div class="repeat-list" data-repeater-list="soft[0][question]">
                    <div class="repeat-item" data-repeater-item="soft[0][question]">

                        <div class="form-group row ms-2 my-2 d-flex align-items-end">
                            <div class="col">
                                {{-- <label class="form-label">Question</label> --}}
                                <input required type="text" name="soft[0][question]"
                                    placeholder="Question e.g : lorem ipsum a b c?" class="form-control question-input">
                                <div class="question-suggestions"></div>

                            </div><!--end col-->
                            <div class="col-2 text-align-right">
                                <div data-repeater-delete="" class="btn btn-sm btn-outline-danger float-right">
                                    <div class="far fa-trash-alt me-1">
                                    </div>
                                </div>
                            </div><!--end col-->

                        </div>

                    </div><!--end col-->
                </div><!--end row-->
                <div class="row m-2 mx-3 align-items-center">
                    <div class="col-7">

                    </div><!--end col-->
                    <div class="col-auto align-self-center">
                        <span data-repeater-create="" data-repeater-list="" class="btn btn-sm btn-soft-primary">
                            <span class="fa fa-plus"></span> Add Question
                        </span>
                    </div>


                    {{-- <a class=" btn btn-sm btn-soft-primary" href="{{ route('client-add') }}" role="button"><i
                    class="fas fa-plus me-2"></i>New Client</a> --}}
                </div>

            </div> <!--end repeter-->

        </div><!--end row-->
        <hr>
    </fieldset>
    <fieldset id="hard" class="field-set d-none " data-count="0">

        <div class="row">

            <div class="col-sm-11">

                <select name="hard[0][skill]" class="form-select">
                    <option value="">Select Skills</option>
                    @foreach ($hard as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                    @endforeach

                </select>
            </div><!--end col-->
            <div class="col text-align-right temp1">
                <div class="btn btn-sm btn-outline-danger float-right skill_delete">
                    <div class="far fa-trash-alt me-1"></div>
                </div>
            </div><!--end col-->


        </div><!--end row-->
        <hr>
    </fieldset><!--end fieldset-->

    <fieldset id="team" class="field-set d-none" data-count="0">

        <div class="row">

            <div class="col-sm-11">

                <select name="team[0][skill]" class="form-select">
                    <option value="">Select Skills</option>
                    @foreach ($team as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->name }}
                        </option>
                    @endforeach

                </select>
            </div><!--end col-->
            <div class="col text-align-right temp1">
                <div class="btn btn-sm btn-outline-danger float-right skill_delete">
                    <div class="far fa-trash-alt me-1"></div>
                </div>
            </div><!--end col-->


        </div><!--end row-->
        <hr>
    </fieldset><!--end fieldset-->

    <div id="stage4" class="card-body d-none">
        <div class="repeat">
            <div class="repeat-list" data-repeater-list="stage[4][question]">
                <div class="repeat-item" data-repeater-item="stage[4][question]">

                    <div class="form-group row ms-2 my-2 d-flex align-items-end">
                        <div class="col">

                            <input required type="text" name="stage[4][question][][question]" disabled
                                placeholder="Question e.g : lorem ipsum a b c?" class="form-control question-input">
                            <div class="question-suggestions"></div>

                        </div><!--end col-->
                        <div class="col-2 text-align-right">
                            <div data-repeater-delete="" class="btn btn-sm btn-outline-danger float-right">
                                <div class="far fa-trash-alt me-1">
                                </div>
                            </div>
                        </div><!--end col-->

                    </div>

                </div><!--end col-->
            </div><!--end row-->
            <div class="row m-2 mx-3 align-items-center">
                <div class="col-7">

                </div><!--end col-->
                <div class="col-auto align-self-center">
                    <span data-repeater-create="" data-repeater-list="" class="btn btn-sm btn-soft-primary">
                        <span class="fa fa-plus"></span> Add Question
                    </span>
                </div>

            </div>

        </div>
    </div>
    <div id="stage5" class="card-body d-none">
        <div id="" class="repeat">
            <div class="repeat-list" data-repeater-list="stage[5][question]">
                <div class="repeat-item" data-repeater-item="stage[5][question]">

                    <div class="form-group row ms-2 my-2 d-flex align-items-end">
                        <div class="col">

                            <input required type="text" name="stage[5][question][][question]" disabled
                                placeholder="Question e.g : lorem ipsum a b c?" class="form-control question-input">
                            <div class="question-suggestions"></div>

                        </div><!--end col-->
                        <div class="col-2 text-align-right">
                            <div data-repeater-delete="" class="btn btn-sm btn-outline-danger float-right">
                                <div class="far fa-trash-alt me-1">
                                </div>
                            </div>
                        </div><!--end col-->

                    </div>

                </div><!--end col-->
            </div><!--end row-->
            <div class="row m-2 mx-3 align-items-center">
                <div class="col-7">

                </div><!--end col-->
                <div class="col-auto align-self-center">
                    <span data-repeater-create="" data-repeater-list="" class="btn btn-sm btn-soft-primary">
                        <span class="fa fa-plus"></span> Add Question
                    </span>
                </div>

            </div>

        </div>
    </div>

    <div id="stage1_repeat" class="repeat d-none">
        <div class="repeat-list" data-repeater-list="stage[1][HR][question]">
            <div class="repeat-item" data-repeater-item="stage[1][HR][question]">

                <div class="form-group row ms-2 my-2 d-flex align-items-end">
                    <div class="col">

                        <input required type="text" disabled name="stage[1][HR][question][][question]"
                            placeholder="Question e.g : lorem ipsum a b c?" class="form-control question-input">
                        <div class="question-suggestions"></div>

                    </div><!--end col-->
                    <div class="col-2 text-align-right">
                        <div data-repeater-delete="" class="btn btn-sm btn-outline-danger float-right">
                            <div class="far fa-trash-alt me-1">
                            </div>
                        </div>
                    </div><!--end col-->

                </div>

            </div><!--end col-->
        </div><!--end row-->
        <div class="row m-2 mx-3 align-items-center">
            <div class="col-7">

            </div><!--end col-->
            <div class="col-auto align-self-center">
                <span data-repeater-create="" data-repeater-list="" class="btn btn-sm btn-soft-primary">
                    <span class="fa fa-plus"></span> Add Question
                </span>
            </div>

        </div>

    </div>
    <div id="stage1" class="card-body mb-2 d-none stage_id" data-stage="1">


        <div class="card JD_weight d-none">
            <div class="card-header d-flex">
                <div class="form-check form-check-inline d-flex">
                    <input class="form-check-input competency_check" type="checkbox" value="JD">
                    <h4 class="card-title">JD and skills comparison</h4>
                </div>
            </div>
            

        </div><!--end of card -->
        <div class="card ORG_weight d-none">
            <div class="card-header d-flex">
                <div class="form-check form-check-inline d-flex">
                    <input class="form-check-input competency_check" type="checkbox" value="ORG"/>
                    <h4 class="card-title">Fit to ORG culture </h4>
                </div>
            </div>
           

        </div><!--end of card -->
        <div class="card  hard_weight d-none">
            <div class="card-header d-flex">
                <div class="form-check form-check-inline d-flex">
                    <input class="form-check-input competency_check" type="checkbox" value="hard" />
                    <h4 class="card-title">Hard Skill </h4>
                </div>
            </div>
           

        </div><!--end of card -->
        <div class="card  soft_weight d-none">
            <div class="card-header d-flex">
                <div class="form-check form-check-inline d-flex">
                    <input class="form-check-input competency_check" type="checkbox" value="soft">
                    <h4 class="card-title">Soft Skill </h4>
                </div>
            </div>
            

        </div><!--end of card -->
        <div class="card  team_weight d-none">
            <div class="card-header d-flex">
                <div class="form-check form-check-inline d-flex">
                    <input class="form-check-input competency_check" type="checkbox" value="team">
                    <h4 class="card-title">Team Fit </h4>
                </div>
            </div>
           

        </div><!--end of card -->

    </div>



    <div class="row p-3">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Job Information</h4>
                    <p class="text-muted mb-0">Fill The Form below to create new JOb
                    </p>
                </div><!--end card-header-->
                <div class="card-body bootstrap-select-1">
                    <div class="row">
                        <div class="col-md-8">
                            <form action="{{ route('jobs-store') }}" id="myForm"
                                class="form-horizontal form-wizard-wrapper wizard_form" method="post"
                                enctype="multipart/form-data" novalidate>
                                @csrf
                                <h3>Job Information</h3>
                                <fieldset>

                                    @if ($auth_user->hasRole('SuperAdmin'))
                                        <div class="form-group">
                                            <label class="form-label">Company Name</label>
                                            <div>

                                                <select name="org_id" id="" class="select3 form-control mb-3t"
                                                    style="width: 100%; height:36px;">
                                                    <option value="">Select Client (only for admin)</option>
                                                    @foreach ($client_list as $client_item)
                                                        <option value="{{ $client_item->id }}">{{ $client_item->org_name }}
                                                        </option>
                                                    @endforeach

                                                </select>

                                            </div>
                                            <span class="text-danger">
                                                @error('org_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    @endif

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Project Number</label>

                                                <input type="number" name="project_number" class="form-control"
                                                    placeholder="Project Number" required
                                                    aria-required="Project Number is Required">


                                                <span class="text-danger project_number_error" id="project_number_error">
                                                    @error('project_number')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Vacant Position</label>

                                                <input required type="text" name="vacant_position"
                                                    class="form-control" placeholder="Vacant Position">


                                                <span class="text-danger vacant_position_error"
                                                    id="vacant_position_error">
                                                    @error('vacant_position')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Type of job</label>

                                                <select name="job_type" id="job_type" class="select3 form-control mb-3t"
                                                    style="width: 100%; height:36px;" required>
                                                    <option value="">Select type of job</option>
                                                    <option value="Full Time">Full Time</option>
                                                    <option value="Part Time">Part Time</option>
                                                    <option value="Intern">Intern</option>
                                                    <option value="Freelance">Freelance</option>
                                                </select>

                                                <span class="text-danger job_type_error" id="job_type_error">
                                                    @error('job_type')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Type of position</label>

                                                <select name="type_of_position" id="type_of_position" required
                                                    class="select3 form-control mb-3t" style="width: 100%; height:36px;">
                                                    <option value="">Select type of job</option>
                                                    <option value="Management">Management</option>
                                                    <option value="Non-Management">Non-Management</option>

                                                </select>

                                                <span class="text-danger type_of_position_error"
                                                    id="type_of_position_error">
                                                    @error('type_of_position')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">Project Owner</label>

                                                <input required type="text" name="project_owner" class="form-control"
                                                    placeholder="Project Owner">

                                                <span class="text-danger project_owner_error" id="project_owner_error">
                                                    @error('project_owner')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">HR incharge</label>

                                                <input required type="text" name="hr_incharge" class="form-control"
                                                    placeholder="HR incharge">

                                                <span class="text-danger project_owner_error" id="project_owner_error">
                                                    @error('project_owner')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Department / Business Unit</label>

                                        <select name="department_id" id="department_id"
                                            class="select3 form-control mb-3t" style="width: 100%; height:36px;" required>
                                            <option value="">Select Department</option>
                                            @foreach ($department_list as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach

                                            {{-- <option value="HR">HR</option>
                                            <option value="Finance">Finance</option>
                                            <option value="IT">IT</option>
                                            <option value="Legal">Legal</option>
                                            <option value="Admin">Admin</option>
                                            <option value="Marketing">Marketing</option>
                                            <option value="Sales">Sales</option>
                                            <option value="R&D">R&D</option>
                                            <option value="Other">Other</option> --}}

                                        </select>

                                        <span class="text-danger department_id_error" id="department_id_error">
                                            @error('department')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </fieldset>
                                <h3>Question Set up</h3>
                                <fieldset>

                                    <div class="col-12">


                                        <div class="card-body mb-2 stage_id" data-stage="1">


                                            <div class="card bg-soft-danger">
                                                <div class="card-header">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input competency_check2" type="checkbox">
                                                        <h4 class="card-title">JD and skills comparison</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body d-none skill-body" data-type="JD">

                                                </div>

                                            </div><!--end of card -->
                                            <div class="card bg-soft-success">
                                                <div class="card-header">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input competency_check2"
                                                            type="checkbox" />
                                                        <h4 class="card-title">Fit to ORG culture </h4>
                                                    </div>
                                                </div>
                                                <div class="card-body d-none skill-body" data-type="ORG">

                                                </div>

                                            </div><!--end of card -->



                                            <div class="card bg-soft-danger">
                                                <div class="card-header">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input competency_check" type="checkbox"
                                                            id="inlineCheckbox1" value="1">
                                                        <h4 class="card-title">Hard Skill</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body d-none">
                                                    <div class="skill-body" data-type="hard">

                                                    </div>
                                                    <div class="row mx-3 mb-3">
                                                        <div class="col-md-2 ">
                                                            <div id="cloneButton"
                                                                class="cloneButton btn btn-sm btn-outline-secondary">
                                                                Add Skill</div>
                                                        </div>
                                                    </div>
                                                </div><!--card-body-->

                                            </div><!--end of card -->

                                            <div class="card bg-soft-primary">
                                                <div class="card-header">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input competency_check" type="checkbox"
                                                            id="inlineCheckbox1" value="1">
                                                        <h4 class="card-title">Soft Skill</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body d-none">
                                                    <div class="skill-body" data-type="soft">

                                                    </div>
                                                    <div class="row mx-3 mb-3">
                                                        <div class="col-md-2 ">
                                                            <div id="cloneButton"
                                                                class="cloneButton btn btn-sm btn-outline-secondary">
                                                                Add Skill</div>
                                                        </div>
                                                    </div>
                                                </div><!--card-body-->
                                            </div><!--end of card -->

                                            <div class="card bg-soft-success">
                                                <div class="card-header">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input competency_check" type="checkbox"
                                                            id="inlineCheckbox1" value="1">
                                                        <h4 class="card-title">Team Fit</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body d-none">
                                                    <div class="skill-body" data-type="team">

                                                    </div>
                                                    <div class="row mx-3 mb-3">
                                                        <div class="col-md-2 ">
                                                            <div id="cloneButton"
                                                                class="cloneButton btn btn-sm btn-outline-secondary">
                                                                Add Skill</div>
                                                        </div>
                                                    </div>
                                                </div><!--card-body-->
                                            </div><!--end of card -->

                                        </div>
                                        <!--end /div-->

                                    </div><!--end col-->
                                </fieldset>
                                <h3>Stage Weight Setup</h3>
                                <fieldset>
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header d-flex">
    
                                                <div class="form-check form-check-inline d-flex">
                                                    <input class="form-check-input stage_check2" type="checkbox"
                                                        id="inlineCheckbox1" name=" stage_status[]" value="1" />
                                                    <h4 class="card-title">Stage 1</h4>
                                    
                                                </div>
                                                <div class="btn btn-sm btn-primary toggle-button pt-1" style="visibility:hidden;">
                                                    Hide</div>
                                                
                                            </div><!--end card-header-->
    
                                            
    
                                        </div><!--end card-->
                                        @for ($i = 2; $i < 4; $i++)
                                            <div class="card">
                                                <div class="card-header d-flex">
    
                                                    <div class="form-check form-check-inline d-flex">
                                                        <input class="form-check-input stage_check2" type="checkbox"
                                                            id="inlineCheckbox1" name=" stage_status[]"
                                                            value="{{ $i }}" />
                                                        <h4 class="card-title">Stage {{ $i }}</h4>
                                                    </div>
                                                    <div class="btn btn-sm btn-primary toggle-button"
                                                        style="visibility:hidden;">Hide</div>
                                                </div><!--end card-header-->
    
                                                <!--end /div-->
    
                                            </div><!--end card-->
                                        @endfor
    
                                        <div class="card">
                                            <div class="card-header d-flex">
    
                                                <div class="form-check form-check-inline d-flex">
                                                    <input class="form-check-input stage_check2" type="checkbox"
                                                        id="inlineCheckbox1" name=" stage_status[]" value="4">
                                                    <h4 class="card-title">Stage 4</h4>
                                                </div>
                                                <div class="btn btn-sm btn-primary toggle-button" style="visibility:hidden;">
                                                    Hide</div>
                                            </div><!--end card-header-->
    
                                            <!--end /div-->
    
                                        </div>
                                        <div class="card">
                                            <div class="card-header d-flex">
    
                                                <div class="form-check form-check-inline d-flex">
                                                    <input class="form-check-input stage_check2" type="checkbox"
                                                        id="inlineCheckbox1" name=" stage_status[]" value="5">
                                                    <h4 class="card-title">Stage 5</h4>
                                                </div>
                                                <div class="btn btn-sm btn-primary toggle-button" style="visibility:hidden;">
                                                    Hide</div>
                                            </div><!--end card-header-->
    
                                            <!--end /div-->
    
                                        </div>
    
                                    </div><!--end col-->
    
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="cim_candidate"
                                                value="1">
                                            <label class="form-check-label" for="inlineCheckbox3">Need CIM Candidates?
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div><!-- end col -->
                    </div><!-- end row -->
                    {{-- <button class="btn btn-primary text-white" type="submit">Create Job</button> --}}
                </div><!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>

@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var $tagsInput = $(".question-input");
            const stage4_body = $('#stage4-body');
            const stage5_body = $('#stage5-body');

            // $('.stage_check').on('change', show_stage_body);
            $('.stage_check2').on('change', show_stage_body2);
            $('.competency_check').on('change', show_competency_body);
            $('.competency_check2').on('change', show_competency_body2);

            function show_competency_body() {
   
                var checkbox = $(this);
                var card = $(this).closest('.card');
                var cardbody = card.find('.card-body');
                cardbody.removeClass('d-none');
                var cardbody = card.find('.btn-container');
                var isChecked = $(this).prop("checked");
                var stage_value = $(this).val();
               
               
                if (isChecked) {
             
                    var count = $(this).closest("fieldset").data("count");
                    var stage_id = $(this).closest('.stage_id').data('stage');                
                    cardbody.find(".cloneButton").click();
                    debugger
                    var cardheader = $(this).closest('.card-header');
                   
                    $(".cloneButton").off('click', add_skill);
                    $(".cloneButton").on('click', add_skill);

                } else {
                    var card = $(this).closest('.card');
                    swal.fire({
                        title: 'Are you sure?',
                        text: "All the changes will be lost!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then(function(result) {
                        if (result.value) {
                            cardbody.css('visibility', 'hidden');
                            card.find('.question-weight').remove();;
                            card.find('.card-body').empty();
                            $(".cloneButton").off('click', add_skill);
                            $(".cloneButton").on('click', add_skill);

                        } else {
                            swal.fire(
                                'Cancelled',
                                'Your changes are safe :)',
                                'error'
                            );

                            $('.competency_check').off('change', show_competency_body);
                            $('.competency_check').on('change', show_competency_body);
                            checkbox.prop('checked', true);
                        }
                    })

                }
            }

            // function show_stage_body() {
            //     var checkbox = $(this);
            //     var isChecked = $(this).prop("checked");
            //     var stage_value = $(this).val();
            //     if (isChecked) {
            //         var stageBody = $("#stage-body").clone();
            //         var question_weight = $("#question-weight").clone();
            //         question_weight.removeClass('d-none');
            //         question_weight.removeAttr('id');
            //         // $(document).find('input').attr('required', true);
            //         // $('#myForm')[0].checkValidity();
            //         var cardheader = $(this).closest('.card-header');
            //         stageBody.attr("id", "");
            //         stageBody.css("visibility", "visible");
            //         stageBody.css("max-height", "");
            //         stageBody.css("overflow-y", "auto");
            //         stageBody.data("stage", stage_value);
            //         cardheader.after(stageBody);
            //         var stage_id = $(this).closest('.card').find('.stage_id').data('stage');
            //         var skill_name = `stage[${stage_id}][weight]`;
            //         console.log(skill_name);
            //         question_weight.attr("name", skill_name);
            //         $(".cloneButton").off('click', add_skill);
            //         cardheader.find('.toggle-button').css('visibility', 'visible');
            //         cardheader.find('.form-check-inline').append(question_weight);
            //         // Bind the click event handler
            //         $(".cloneButton").on('click', add_skill);
            //     } else {
            //         var card = $(this).closest('.card');
            //         swal.fire({
            //             title: 'Are you sure?',
            //             text: "All the changes will be lost!",
            //             type: 'warning',
            //             showCancelButton: true,
            //             confirmButtonText: 'Yes, delete it!',
            //             cancelButtonText: 'No, cancel!',
            //             reverseButtons: true
            //         }).then(function(result) {
            //             if (result.value) {
            //                 card.find('.toggle-button').css('visibility', 'hidden');
            //                 card.find('.question-weight').remove();;
            //                 card.find('.card-body').remove();

            //             } else if (
            //                 // Read more about handling dismissals
            //                 result.dismiss === Swal.DismissReason.cancel
            //             ) {
            //                 swal.fire(
            //                     'Cancelled',
            //                     'Your changes are safe :)',
            //                     'error'
            //                 );
            //                 $('.stage_check').off('change', show_stage_body);
            //                 $('.stage_check').on('change', show_stage_body);
            //                 checkbox.prop('checked', true);
            //             } else {
            //                 $('.stage_check').off('change', show_stage_body);
            //                 $('.stage_check').on('change', show_stage_body);
            //                 checkbox.prop('checked', true);
            //             }
            //         })

            //     }

            //     $('.competency_check').off('change', show_competency_body);
            //     $('.competency_check').on('change', show_competency_body);
            // }

            function show_competency_body2() {
                var checkbox = $(this);
                var card = $(this).closest('.card');
                var isChecked = $(this).prop("checked");
                var stage_value = $(this).val();
                // var question_weight = $("#question-weight").clone();
                // question_weight.removeClass('d-none');
                // question_weight.removeAttr('id');

                if (isChecked) {
                    var skill_body = $(this).closest('.card').find('.skill-body')
                    var count = $(this).closest("fieldset").data("count");
                    var stage_id = $(this).closest('.stage_id').data('stage');
                    var type = skill_body.data("type");

                    var list_name = `${type}[question]`;
                    var skill_name = `${type}[question]`;
                    console.log(list_name, skill_name);
                    var stage1 = $('#stage1_repeat').clone();
                    stage1.removeClass('d-none');

                    list = stage1.find(".repeat-list");
                    list.attr("data-repeater-list", list_name);
                    list.attr("data-repeater-item", list_name);

                    stage1.find('input').attr("name", skill_name);
                    var cardbody = card.find('.card-body').first();
                    cardbody.removeClass('d-none');
                    cardbody.html(stage1);
                    cardbody.find('input').removeAttr('disabled');
                    cardbody.find(".repeat").repeater();
                    var skill_name = `stage[${stage_id}][${type}_weight]`;
                    console.log(skill_name);
                    // question_weight.attr("name", skill_name)

                    var cardheader = $(this).closest('.card-header');
                    // cardheader.find('.form-check-inline').append(question_weight);
                    card.find('.repeat').off("input", '.question-input', function() {
                        read_input2.call(this, type);
                    });
                    card.find('.repeat').on("input", '.question-input', function() {
                        read_input2.call(this, type);
                    });
                    // card.find('.repeat').on("blur", '.question-input', function() {
                    //     debugger;
                    //     $tagSuggestions = $(this).siblings(".question-suggestions");
                    //     $tagSuggestions.empty();
                    // });


                } else {
                    var card = $(this).closest('.card');
                    swal.fire({
                        title: 'Are you sure?',
                        text: "All the changes will be lost!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true
                    }).then(function(result) {
                        if (result.value) {
                            var cardbody = card.find('.card-body').first();
                            cardbody.empty();
                            cardbody.addClass('d-none');
                            card.find('.question-weight').remove();;
                            cardbody.find('input').attr('disabled');


                        } else {
                            swal.fire(
                                'Cancelled',
                                'Your changes are safe :)',
                                'error'
                            );

                            $('.competency_check2').off('change', show_competency_body2);
                            $('.competency_check2').on('change', show_competency_body2);
                            checkbox.prop('checked', true);
                        }
                    })

                }
            }

            function show_stage_body2(event) {
                event.preventDefault()
                var checkbox = $(this);
                var isChecked = $(this).prop("checked");
                var stage_value = $(this).val();
                console.log(stage_value);
                if (isChecked) {

                    var question_weight = $("#question-weight").clone();
                    question_weight.removeClass('d-none');
                    question_weight.removeAttr('id');

                    var card = $(this).closest('.card');
                    var cardheader = $(this).closest('.card-header');
                    var cardbody = card.find('.card-body').first();
                    cardbody.removeClass('d-none');
                    var stage_id = stage_value;
                    var skill_name = `stage[${stage_id}][weight]`;
                    question_weight.find('input').attr("name", skill_name);
                    question_weight.find('input').val('');
                    cardheader.find('.toggle-button').css('visibility', 'visible');
                    cardheader.find('.form-check-inline').append(question_weight);
                    // debugger
                    if (stage_value == 4 || stage_value == 5) {
                        var stage45 = $('#stage' + stage_value).clone();
                        stage45.removeAttr('id');
                        stage45.removeClass('d-none');
                        stage45.find('input').removeAttr('disabled');
                        stage45.find(".repeat").repeater();
                        cardheader.after(stage45);

                        var type = 'others'

                    }
                    if (stage_value == 1) {
                        var stage1 = $('#stage1').clone();
                        stage1.removeClass('d-none');
                        stage1.removeAttr('id');
                        card.append(stage1);
                        // $('#myForm')[0].checkValidity();
                        stage1.find('.competency_check2').off('change', show_competency_body2);
                        stage1.find('.competency_check2').on('change', show_competency_body2);
                        stage1.find('.competency_check').off('change', show_competency_body);
                        stage1.find('.competency_check').on('change', show_competency_body);
                    }
                    // var stage_id = stage_value;
                    // var skill_name = `stage[${stage_id}][weight]`;
                    // console.log(skill_name);
                    // debugger
                    // question_weight.find('input').attr("name", skill_name);
                    // cardheader.find('.toggle-button').css('visibility', 'visible');
                    // cardheader.find('.form-check-inline').append(question_weight);
                    card.find('.repeat').off("input", '.question-input', function() {
                        read_input2.call(this, type);
                    });
                    card.find('.repeat').on("input", '.question-input', function() {
                        read_input2.call(this, type);
                    });
               

                } else {
                    var card = $(this).closest('.card');
                    var cardheader = $(this).closest('.card-header');
                    var cardbody = card.find('.card-body').first();

                    swal.fire({
                        title: 'Are you sure?',
                        text: "All the changes will be lost!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!',
                        reverseButtons: true,
                    }).then(function(result) {
                        if (result.value) {
                            card.find('.toggle-button').css('visibility', 'hidden');
                            if (stage_value == 4 || stage_value == 5) {
                                cardbody.remove();
                            }
                            if (stage_value == 1) {
                                cardbody.remove();
                            }
                            cardbody.addClass('d-none');
                            card.find('.question-weight').remove();
                            $('.stage_check2').off('change', show_stage_body2);
                            $('.stage_check2').on('change', show_stage_body2);
                        } else if (
                            // Read more about handling dismissals
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swal.fire(
                                'Cancelled',
                                'Your changes are safe :)',
                                'error'
                            );
                            $('.stage_check2').off('change', show_stage_body2);
                            $('.stage_check2').on('change', show_stage_body2);
                            checkbox.prop('checked', true);
                        } else {
                            $('.stage_check2').off('change', show_stage_body2);
                            $('.stage_check2').on('change', show_stage_body2);
                            checkbox.prop('checked', true);
                        }
                    })

                }

                $('.competency_check2').off('change', show_competency_body2);
                $('.competency_check2').on('change', show_competency_body2);
            }

            var $tagSuggestions = $tagsInput.closest(".question-suggestions");
            var a = 0

            function add_skill() {

                console.log('ok');
                var skill_body = $(this).closest('.card').find('.skill-body');
                var stage_id = $(this).closest('.stage_id').data('stage');
                var count = skill_body.find("fieldset").last().data("count");
                if (!count) {
                    count = 0;
                }
                var type = skill_body.data("type");
                var clonedElement = $('#' + type).first().clone();
                clonedElement.removeClass('d-none');
                // skill_body.removeClass('d-none');

                var type = skill_body.data("type");
                // Clone the element
                count++;

                console.log(count);
                clonedElement.find('.repeat').remove();
                var skill_name = `${type}[${count}][skill]`;
                clonedElement.find("select").attr("name", skill_name);

                skill_body.append(clonedElement);

                skill_body.find("fieldset").last().data("count", count)

                clonedElement.find('.form-select').off('change', init_repeater);
                clonedElement.find('.form-select').on('change', init_repeater);
                clonedElement.find('.skill_delete').on('click', delete_skill);



            };

            $('.skill_delete').on('click', delete_skill);

            $(".toggle-button").click(function() {
                // Find the parent card element
                var card = $(this).closest(".card");

                // Find the card body within the parent card
                var cardBody = card.find(".card-body");

                if (cardBody.css("max-height") === "0px") {
                    cardBody.css("max-height", cardBody[0].scrollHeight + "px");
                    cardBody.css("visibility", "visible");
                    $(this).text('Hide')


                } else {
                    cardBody.css("max-height", "0px");

                    cardBody.css("visibility", "hidden");
                    $(this).text('Show')
                }
            });

            function delete_skill() {
                var fieldset = $(this).closest('fieldset');
                fieldset.remove();
            }

            function read_input(skill_id) {

                // Get the user's input
                $tagsInput = $(this);

                $tagSuggestions = $(this).siblings(".question-suggestions");
                $tagSuggestions.append("<option value=''>asa</option>");
                var allInput = $tagsInput.val();
                var userInput = $tagsInput.val();
                var commaIndex = userInput.lastIndexOf(",");
                var lastInput = "";

                if (commaIndex !== -1) {
                    // If there's a comma, only consider text after the last comma
                    userInput = allInput.substring(commaIndex + 1).trim();
                    lastInput = allInput.substring(0, commaIndex).trim();

                }

                // Make an AJAX request to fetch tag suggestions
                $.ajax({
                    method: "GET",
                    url: "{{ route('question_suggest') }}", // Replace with your Laravel API endpoint
                    data: {
                        input: userInput,
                        id: skill_id
                    },
                    success: function(suggestions) {
                        // Clear existing suggestions
                        $tagSuggestions.empty();
                        console.log(suggestions);
                        //  
                        // Append new suggestions to the list
                        if (suggestions.status) {

                            suggestions.result.forEach(function(suggestion) {
                                console.log(suggestion.question);
                                $tagSuggestions.append("<option class='px-2 p-2' value=" +
                                    suggestion
                                    .question + ">" + suggestion.question + "</option>");

                            });
                        } else {
                            console.log(suggestions.result);
                            $tagSuggestions.append("<option value=" + suggestions.result + ">" +
                                suggestions.result + "</option>");
                        }

                        $option = $tagSuggestions.find('option');
                        $option.on('click', selectoption);

                        function selectoption() {
                            allInput = $tagsInput.val()
                            var selectedOption = $(this).text();
                            console.log(selectedOption);
                            lastInput = allInput.substring(0, commaIndex).trim();
                            //  
                            if (lastInput !== "") {
                                $tagsInput.val(selectedOption);
                            } else {
                                $tagsInput.val(selectedOption);
                            }

                            $tagSuggestions.empty();

                        }

                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            };

            function read_input2(type) {

                // Get the user's input
                $tagsInput = $(this);

                $tagSuggestions = $(this).siblings(".question-suggestions");
                $tagSuggestions.append("<option value=''>asa</option>");
                var allInput = $tagsInput.val();
                var userInput = $tagsInput.val();
                var commaIndex = userInput.lastIndexOf(",");
                var lastInput = "";

                if (commaIndex !== -1) {
                    // If there's a comma, only consider text after the last comma
                    userInput = allInput.substring(commaIndex + 1).trim();
                    lastInput = allInput.substring(0, commaIndex).trim();

                }

                // Make an AJAX request to fetch tag suggestions
                $.ajax({
                    method: "GET",
                    url: "{{ route('question_suggest') }}", // Replace with your Laravel API endpoint
                    data: {
                        input: userInput,
                        type: type
                    },
                    success: function(suggestions) {
                        // Clear existing suggestions
                        $tagSuggestions.empty();
                        console.log(suggestions);
                        //  
                        // Append new suggestions to the list
                        if (suggestions.status) {

                            suggestions.result.forEach(function(suggestion) {
                                console.log(suggestion.question);
                                $tagSuggestions.append("<option class='px-2 p-2' value=" +
                                    suggestion
                                    .question + ">" + suggestion.question + "</option>");

                            });
                        } else {
                            console.log(suggestions.result);
                            $tagSuggestions.append("<option value=" + suggestions.result + ">" +
                                suggestions.result + "</option>");
                        }

                        $option = $tagSuggestions.find('option');
                        $option.on('click', selectoption);

                        function selectoption() {
                            allInput = $tagsInput.val()
                            var selectedOption = $(this).text();
                            console.log(selectedOption);
                            lastInput = allInput.substring(0, commaIndex).trim();
                            //  
                            if (lastInput !== "") {
                                $tagsInput.val(selectedOption);
                            } else {
                                $tagsInput.val(selectedOption);
                            }

                            clearSuggestions();

                        }

                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            };

            function init_repeater(e) {
                e.preventDefault();
                var row1 = $(this).closest('.row')
                var skill_id = $(this).val();
                var skill_body = $(this).closest('.card').find('.skill-body')
                var clonedElement1 = $('#repeat_temp').clone();
                var count = $(this).closest("fieldset").data("count");
                var stage_id = $(this).closest('.stage_id').data('stage');
                var type = skill_body.data("type");

                var skill_name = `${type}[${count}][skill]`;
                var list_name = `${type}[${count}][question]`;
                var input_name = `${type}[${count}][question]`;

                list = clonedElement1.find(".repeat-list");
                list.attr("data-repeater-list", list_name);
                list.attr("data-repeater-item", list_name);
                clonedElement1.find("select").attr("name", skill_name);
                list.find(".question-input").attr("name", input_name)

                console.log(list.find(".question-input").attr("name") + 1);

                row1.find('.repeat').remove();
                row1.find('.temp1').after(clonedElement1);

                // row1.find(".repeat").html(repeat_element);
                row1.find(".repeat").removeClass('d-none');
                row1.find(".repeat").repeater();
                row1.find('.repeat').on("input", '.question-input', function() {
                    read_input.call(this, skill_id);
                });
                // row1.find('.repeat').on("blur", '.question-input', function() {
                //         debugger;
                //         $tagSuggestions = $(this).siblings(".question-suggestions");
                //         $tagSuggestions.empty();
                //     });
            }

            function clearSuggestions() {
                $tagSuggestions.empty();
            }

            // Add a click event listener to the document
            $(document).on('click', function(event) {
                // Check if the clicked element is not within the suggestion box
                if (!$(event.target).closest($tagSuggestions).length) {
                    clearSuggestions();
                }
            });



        });
    </script>
    <script>
        function validateStage(index, stageData) {

            const hardWeight = parseInt(stageData.hard_weight);
            const softWeight = parseInt(stageData.soft_weight);
            const team_weight = parseInt(stageData.team_weight);
            const JD_weight = parseInt(stageData.JD_weight);
            const HR_weight = parseInt(stageData.HR_weight);
            const ORG_weight = parseInt(stageData.ORG_weight);
            console.log(index, stageData);
            console.log(hardWeight, softWeight, team_weight);
            let valid_flag = true
            var total = 0;
            if (index == 1) {


                if (!isNaN(hardWeight)) {
                    total += hardWeight
                    if (stageData.hard == undefined && stageData.hard == null) {

                        questionValidationError(index, stageData, 'Hard Skill');
                        valid_flag = false;
                    }

                }
                if (!isNaN(softWeight)) {
                    total += softWeight
                    if (stageData.soft == undefined && stageData.soft == null) {

                        questionValidationError(index, stageData, 'Soft Skill');
                        valid_flag = false;
                    }
                }
                if (!isNaN(team_weight)) {
                    total += team_weight
                    if (stageData.team == undefined && stageData.team == null) {

                        questionValidationError(index, stageData, 'Team Skill');
                        valid_flag = false;
                    }
                }
                if (!isNaN(JD_weight)) {
                    total += JD_weight
                    // var count = Object.keys(stageData.JD).length
                    if (stageData.JD == undefined && stageData.JD == null) {

                        questionValidationError(index, stageData, 'JD');
                        valid_flag = false;
                    }
                }
                if (!isNaN(HR_weight)) {
                    total += HR_weight
                    if (stageData.HR == undefined && stageData.HR == null) {

                        questionValidationError(index, stageData, 'HR');
                        valid_flag = false;
                    }
                }
                if (!isNaN(ORG_weight)) {
                    total += ORG_weight
                    if (stageData.ORG == undefined && stageData.ORG == null) {

                        questionValidationError(index, stageData, 'ORG');
                        valid_flag = false;
                    }
                }
                if (total === 100 && valid_flag) {

                    return true;
                } else {

                    return false;
                }
            } else {
                console.log(hardWeight);

                if (!isNaN(hardWeight)) {
                    total += hardWeight
                    console.log(stageData.hard);

                    if (stageData.hard != undefined && stageData.hard != null) {
                        console.log('okay');

                        $.each(stageData.hard, function(index2, value) {
                            console.log(value);

                            if (value.question == undefined && value.question == null) {
                                console.log('no question');

                                questionValidationError(index2, stageData, 'Hard Skill');
                                valid_flag = false;
                            }
                        });

                    }

                }
                if (!isNaN(softWeight)) {
                    total += softWeight
                    if (stageData.soft != undefined && stageData.soft != null) {
                        $.each(stageData.soft, function(index, value) {
                            if (value.question == undefined && value.question == null) {
                                debugger
                                questionValidationError(index, stageData, 'Soft Skill');
                                valid_flag = false;
                            }
                        });

                    }
                }
                if (!isNaN(team_weight)) {
                    total += team_weight
                    if (stageData.team != undefined && stageData.team != null) {
                        $.each(stageData.team, function(index, value) {
                            if (value.question == undefined && value.question == null) {

                                questionValidationError(index, stageData, 'Team Fit');
                                valid_flag = false;
                            }
                        });

                    }
                }
                if (total === 100 && valid_flag) {

                    return true;
                } else {

                    return false;
                }

            }

            console.log(total);

        }


        function questionValidationError(stageIndex, stageData, competency = null) {
            var toast = $('#toast-content').first().clone();
            toast.find('h5').text(
                `Stage ${stageIndex} ${competency}:: At least one question is required.`);
            toast.removeClass('d-none');
            toast.toast({
                autohide: true
            });
            var toastContainer = $('#warning-toast').find('.toast-container');
            toastContainer.children('.toast').hide();
            toastContainer.append(toast);
            toastContainer.children('.toast').removeClass('d-none');
            toastContainer.children('.toast').show({
                autohide: true
            });
        }

        function showValidationError(stageIndex, stageData) {
            var toast = $('#toast-content').first().clone();
            toast.find('h5').text(
                `Stage ${stageIndex}: Sum of weight must equal 100.`);
            toast.removeClass('d-none');
            toast.toast({
                autohide: true
            });
            var toastContainer = $('#warning-toast').find('.toast-container');
            toastContainer.children('.toast').hide();
            toastContainer.append(toast);
            toastContainer.children('.toast').removeClass('d-none');
            toastContainer.children('.toast').show({
                autohide: true
            });
        }

        function validateForm() {
            let isValid = true;
            const serializedData = $("#myForm").serializeArray();
            const formData = {};
            var toast = $('#warning-toast').find('.toast2').first().clone();
            var toastContainer = $('#warning-toast').find('.toast-container');
            toastContainer.empty();
            toastContainer.append(toast);
            $.each(serializedData, function(index, item) {
                const parts = item.name.split('[');
                let currentObject = formData;
                console.log(currentObject);
                for (let i = 0; i < parts.length; i++) {
                    const part = parts[i].replace(']', '');
                    if (!currentObject[part]) {
                        currentObject[part] = {};
                    }
                    if (i === parts.length - 1) {
                        currentObject[part] = item.value;
                    } else {
                        currentObject = currentObject[part];
                    }
                }
            });

            var totalWeight = 0
            for (const stageIndex in formData.stage) {
                if (formData.stage.hasOwnProperty(stageIndex)) {
                    const stageData = formData.stage[stageIndex];
                    totalWeight += parseInt(stageData.weight)
                }
            }
            if (totalWeight !== 100) {
                console.log(totalWeight);
                isValid = false;

                var toast = $('#toast-content').first().clone();
                toast.find('h5').text(
                    `Total weight of all stage must be 100`, );
                toast.removeClass('d-none');
                toast.toast({
                    autohide: true
                });
                var toastContainer = $('#warning-toast').find('.toast-container');
                toastContainer.children('.toast').hide();
                toastContainer.append(toast);
                toastContainer.children('.toast').removeClass('d-none');
                toastContainer.children('.toast').show({
                    autohide: true
                });

            }
            // Iterate through stages and validate them
            $.each(formData.stage, function(index, stageData) {
                if (index >= 1 && index <= 3) {
                    if (!validateStage(index, stageData)) {
                        isValid = false;
                        showValidationError(index, stageData);
                        console.log(
                            `Stage ${index}: Validation failed. 'hard_weight' + 'soft_weight' must equal 100.`
                        );
                    }
                }
            });


            if (isValid) {
                console.log("Form is valid.");
                // Perform form submission here
                $('#myForm').unbind('submit').submit();
                // return true;
            } else {
                console.log("Form validation failed. Please correct the errors.");
            }
        }
        $("#myForm").submit(function(event) {

            event.preventDefault(); // Prevent the default form submission
            let isValid = true;
            var toastContainer = $('#warning-toast').find('.toast-container');
            toastContainer.empty();
            var isFirstIteration = true;
            $(this).find('[required]').each(function() {


                if ($(this).val() === '') {
                    isValid = false; // If a required field is empty, set isValid to false
                    $(this).addClass('error'); // Optionally, add a CSS class for styling
                    // $(this).siblings('label').addClass('error'); 
                    $(this).siblings('.error-message').remove();
                    var name = $(this).siblings('label').text().trim(); // Get label text
                    if (!name) {
                        name = $(this).attr('name'); // If label text is empty, get the name attribute
                        var parts = name.split('[question]').filter(Boolean);

                        // Join the parts with spaces
                        var convertedName = parts.join('Question ');
                        convertedName = convertedName.replace(
                            /\[|\]|\_/g, ' ').trim();
                        name = convertedName;
                    }
                    $(this).before(' <span class="error-message error">*' + name + ' is required</span>');
                    if (isFirstIteration) {

                        isFirstIteration = false;
                        var errorPosition = $(this).siblings('.error-message').offset().top;
                        $('html, body').animate({
                            scrollTop: (errorPosition - 50)
                        }, 500);

                        $(this).css('border', '1px solid red');
                        $(this).focus();
                    }



                    var toast = $('#toast-content').first().clone();
                    toast.find('h5').text(
                        `${name} is required`, );
                    toast.removeClass('d-none');
                    toast.toast({
                        autohide: true
                    });
                    var toastContainer = $('#warning-toast').find('.toast-container');
                    toastContainer.children('.toast').hide();
                    toastContainer.append(toast);
                    toastContainer.children('.toast').removeClass('d-none');
                    toastContainer.children('.toast').show({
                        autohide: true
                    });


                } else {
                    $(this).removeClass('error'); // Optionally, add a CSS class for styling
                    $(this).siblings('label').removeClass('error');
                    $(this).siblings('.error-message').remove();
                    $(this).css('border', '').focus();
                }


            });

            // Call the validation function when the form is submitted
            if (isValid) {

                validateForm();
            } else {
                return false
            }
        });
    </script>
    <script>
        // var isNextStepAllowed = true;

        // $(".wizard_form").steps({
        //     headerTag: "h3",
        //     bodyTag: "fieldset",
        //     transitionEffect: "slide",
        //     // stepsOrientation: "horizental",
        //     onStepChanging: function(event, currentIndex, newIndex) {
        //         // Perform AJAX validation before moving to the next step
        //         var isValid = true;
        //         if (isValid) {
        //         var formData = $(".wizard_form").serializeArray();
        //         $form = $('.wizard_form').first();
        //         console.log(currentIndex, newIndex);

        //         var url = "{{ route('job_validate_step', ['step' => ':currentIndex']) }}";
        //         url = url.replace(':currentIndex', currentIndex);



        //         $.ajax({
        //             url: url,
        //             method: 'POST',
        //             data: formData,
        //             success: function(response) {
        //                 if (response.errors) {
        //                     console.log(response.errors);
        //                     // Display validation errors in the modal
        //                     $.each(response.errors, function(key, value) {
        //                         $form.find('#' + key + '_error').html(value[0]);

        //                     });
        //                 } else if (response.status) {
        //                     isValid = true;
        //                     console.log(isValid);                           
        //                 }
        //             },
        //             error: function(response) {
        //                 debugger
        //                 isValid = false;
        //                 console.log('inside error');
        //                 // Validation failed, display errors
        //                 // You can handle errors and prevent moving to the next step
        //             }
        //         });
        //         return false
        //     } else{
        //             return true
        //         }
        //         // console.log(isValid);
        //         // return isValid;
        //         // Return false to prevent automatic navigation

        //     }
        // });

        $(".wizard_form").steps({
            headerTag: "h3",
            bodyTag: "fieldset",
            transitionEffect: "slide",
            onStepChanging: function(event, currentIndex, newIndex) {
                // Perform validation only when moving to the next step
                if (newIndex > currentIndex) {
                    var fieldsetdata = $(".wizard_form fieldset:eq(" + currentIndex + ")");
                    // var isValid = validateRequiredField(fieldsetdata);
                    var isValid = true;

                    if (isValid) {
                        var formData = $(".wizard_form").serializeArray();
                        $form = $('.wizard_form').first();
                        console.log(currentIndex, newIndex);

                        var url = "{{ route('job_validate_step', ['step' => ':currentIndex']) }}";
                        url = url.replace(':currentIndex', currentIndex);

                        // Use synchronous AJAX request (async: false)
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: formData,
                            async: false, // Make the request synchronous
                            success: function(response) {
                                if (response.errors) {
                                    // console.log(response.errors);
                                    // Display validation errors in the modal
                                    console.log(typeof(response.errors));
                                    if (currentIndex==0) {
                                        $.each(response.errors, function(key, value) {
                                        
                                        var errorMessage = '<span class="error-message error">*' + value[0]+ ' </span>';
                                        $('[name="' + key + '"]').before(errorMessage);
                                    });
                                    } else if(currentIndex==1) {
                                        $.each(response.errors, function(key, value) {
                                        var originalString = key;

                                        // Replace dots with square brackets
                                        var convertedString = originalString.replace(/\./g,
                                            '][');

                                        // Enclose the entire string in double quotes
                                        // convertedString = '"' + convertedString + '"';
                                        var firstBracketIndex = convertedString.indexOf(
                                        "]");

                                        // Rearrange the string
                                        var convertedString1 = convertedString.substring(0,
                                                firstBracketIndex) + convertedString
                                            .substring(firstBracketIndex + 1) +
                                            convertedString[firstBracketIndex];
                                        console.log(convertedString1);
                                        var errorMessage = '<span class="error-message error">*' + value[0]+ ' </span>';
                                        $('[name="' + convertedString1 + '"]').before(errorMessage);
                                    });
                                    }
                                    
                                    isValid = false;
                                } else if (response.status) {
                                    isValid = true;
                                    console.log(isValid);
                                }
                            },
                            error: function(response) {
                                isValid = false;
                                console.log(response);
                               
                                // Validation failed, display errors
                                // You can handle errors and prevent moving to the next step
                            }
                        });

                        return isValid; // Return true or false based on validation
                    } else {
                        return isValid; // Continue to the next step if validation is not needed
                    }
                } else {
                    return true; // Allow moving to the previous step without validation
                }
            }
        });


        function validateRequiredField(fieldsetdata) {
            let isValid = true;
            var toastContainer = $('#warning-toast').find('.toast-container');
            toastContainer.empty();
            var isFirstIteration = true;
            fieldsetdata.find('[required]').each(function() {


                if ($(this).val() === '') {
                    isValid = false; // If a required field is empty, set isValid to false
                    $(this).addClass('error'); // Optionally, add a CSS class for styling
                    // $(this).siblings('label').addClass('error'); 
                    $(this).siblings('.error-message').remove();
                    var name = $(this).siblings('label').text().trim(); // Get label text
                    if (!name) {
                        name = $(this).attr('name'); // If label text is empty, get the name attribute
                        var parts = name.split('[question]').filter(Boolean);

                        // Join the parts with spaces
                        var convertedName = parts.join('Question ');
                        convertedName = convertedName.replace(
                            /\[|\]|\_/g, ' ').trim();
                        name = convertedName;
                    }
                    $(this).before(' <span class="error-message error">*' + name + ' is required</span>');
                    if (isFirstIteration) {

                        isFirstIteration = false;
                        var errorPosition = $(this).siblings('.error-message').offset().top;
                        $('html, body').animate({
                            scrollTop: (errorPosition - 50)
                        }, 500);

                        $(this).css('border', '1px solid red');
                        $(this).focus();
                    }
                    var toast = $('#toast-content').first().clone();
                    toast.find('h5').text(
                        `${name} is required`, );
                    toast.removeClass('d-none');
                    toast.toast({
                        autohide: true
                    });
                    var toastContainer = $('#warning-toast').find('.toast-container');
                    toastContainer.children('.toast').hide();
                    toastContainer.append(toast);
                    toastContainer.children('.toast').removeClass('d-none');
                    toastContainer.children('.toast').show({
                        autohide: true
                    });
                } else {
                    $(this).removeClass('error'); // Optionally, add a CSS class for styling
                    $(this).siblings('label').removeClass('error');
                    $(this).siblings('.error-message').remove();
                    $(this).css('border', '').focus();
                }


            });
            return isValid;
        }

        $(".select3").select2({
            width: '100%'
        });
    </script>
@endsection
