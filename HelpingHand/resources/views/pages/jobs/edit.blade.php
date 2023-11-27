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
            Update
        @endslot
        @slot('title')
            Job
        @endslot
    @endcomponent
    <div id="repeat_temp" class="repeat d-none">
        <div class="repeat-list" data-repeater-list="hard[0][question]">
            <div class="repeat-item" data-repeater-item="hard[0][question]">

                <div class="form-group row ms-2 my-2 d-flex align-items-end">
                    <div class="col">
                        {{-- <label class="form-label">Question</label> --}}
                        <input type="text" name="hard[0][question]" placeholder="Question e.g : lorem ipsum a b c?"
                            class="form-control question-input" required>
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

                <select name="soft[0][skill]" class="form-select" required>
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
                                <input type="text" name="soft[0][question]"
                                    placeholder="Question e.g : lorem ipsum a b c?" class="form-control question-input"
                                    required>
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
    <fieldset id="hard" class="field-set d-none" data-count="0">

        <div class="row">

            <div class="col-sm-11">

                <select name="hard[0][skill]" class="form-select" required>
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

                <select name="team[0][skill]" class="form-select" required>
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

    <div id="stage-body" class="card-body mb-2 stage_id" style="max-height:0px;visibility: hidden;overflow-y: auto;"
        data-stage="1">
        <label class="form-label">Hard Skills</label>
        <div class="card bg-soft-danger">
            <div class="card-body skill-body" data-type="hard">
            </div><!--skill-body-->
            <div class="row mx-3 mb-3">
                <div class="col-md-2">
                    <div id="cloneButton" class="cloneButton btn btn-sm btn-outline-secondary">
                        Add Skill</div>
                </div>
            </div>
        </div><!--end of card -->
        <label class="form-label">Soft Skills</label>
        <div class="card bg-soft-primary">
            <div class="card-body skill-body" data-type="soft">

            </div><!--skill-body-->
            <div class="row mx-3 mb-3">
                <div class="col-md-2">
                    <div id="cloneButton" class="cloneButton btn btn-sm btn-outline-secondary">
                        Add Skill</div>
                </div>
            </div>
        </div><!--end of card -->
        <label class="form-label">Team Fit</label>
        <div class="card bg-soft-success">
            <div class="card-body skill-body" data-type="team">


            </div><!--skill-body-->
            <div class="row mx-3 mb-3">
                <div class="col-md-2">
                    <div id="cloneButton" class="cloneButton btn btn-sm btn-outline-secondary">
                        Add Skill</div>
                </div>
            </div>
        </div><!--end of card -->

    </div><!--end of card body -->
    {{-- @foreach ($stages_question as $stageId => $stageQuestions)
        <h2>Stage ID: {{ $stageId }}</h2>

        @foreach ($stageQuestions->groupBy('competency') as $competency => $competencyQuestions)
            <h3>Competency: {{ $competency }}</h3>

            @foreach ($competencyQuestions->groupBy('skill_id') as $skillId => $skillQuestions)
                <h4>Skill ID: {{ $skillId }}</h4>

                <ul>
                    @foreach ($skillQuestions as $question)
                        <li>
                            Question: {{ $question->question }}<br>
                            <!-- You can access other attributes here as well -->
                        </li>
                    @endforeach
                </ul>
            @endforeach
        @endforeach
    @endforeach --}}

    <form action="{{ route('jobs-update') }}" id="myForm" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $job->id }}">
        <div class="row p-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Job Information</h4>
                        <p class="text-muted mb-0">Fill The Form below to Update new JOb
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body bootstrap-select-1">
                        <div class="row">
                            <div class="col-md-8">
                                @if ($auth_user->hasRole('SuperAdmin'))
                                    <div class="form-group">
                                        <label class="form-label">Company Name</label>


                                        <select name="org_id" id="" class="select2 form-control mb-3t"
                                            style="width: 100%; height:36px;">
                                            <option value="">Select Client (only for admin)</option>
                                            @foreach ($client as $client_item)
                                                <option value="{{ $client_item->id }}"
                                                    {{ $client_item->id == $job->org_id ? 'selected' : '' }}>
                                                    {{ $client_item->org_name }}
                                                </option>
                                            @endforeach

                                        </select>

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
                                            <div>
                                                <input type="number" name="project_number" class="form-control"
                                                    parsley-type="text" value="{{ $job->project_number }}">

                                            </div>
                                            <span class="text-danger">
                                                @error('project_number')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Vacant Position</label>
                                            <div>
                                                <input type="text" name="vacant_position" class="form-control"
                                                    parsley-type="text" value="{{ $job->vacant_position }}">

                                            </div>
                                            <span class="text-danger">
                                                @error('vacant_position')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Type of job</label>
                                            <div>
                                                <select name="type_of_job" id="type_of_job"
                                                    class="select2 form-control mb-3t" style="width: 100%; height:36px;">
                                                    <option value="">Select type of job</option>
                                                    <option value="1" {{ $job->type_of_job ? 'selected' : '' }}>Full
                                                        Time
                                                    </option>
                                                    <option value="0"{{ $job->type_of_job ? '' : 'selected' }}>Part
                                                        Time
                                                    </option>
                                                </select>
                                            </div>
                                            <span class="text-danger">
                                                @error('type_of_job')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Type of position</label>
                                            <div>
                                                <input type="text" name="type_of_position" class="form-control"
                                                    parsley-type="text" value="{{ $job->type_of_position }}">
                                            </div>
                                            <span class="text-danger">
                                                @error('type_of_position')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">
                                    <label class="form-label">Department / Business Unit</label>
                                    <div>
                                        <input type="text" name="department" class="form-control" parsley-type="text"
                                            value="{{ $job->department }}">

                                    </div>
                                    <span class="text-danger">
                                        @error('department')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">

                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input stage_check2" type="checkbox"
                                                    id="inlineCheckbox1" name=" stage_status[]" value="1"
                                                    {{ in_array(1, $stages) ? 'checked' : '' }}>
                                                <h4 class="card-title">Stage 1</h4>
                                            </div>
                                            <div class="btn btn-sm btn-primary toggle-button" style="visibility:hidden;">
                                                Hide</div>
                                        </div><!--end card-header-->
                                        <div class="card-body mb-2 d-none stage_id" style="overflow-y: auto;"
                                            data-stage="1">
                                            <label class="form-label">JD and skills comparison</label>

                                            <div class="card bg-soft-danger">
                                                <div class="card-header">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input competency_check2" type="checkbox"
                                                            id="inlineCheckbox1" value="1">
                                                        <h4 class="card-title">JD and skills comparison</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body d-none skill-body" data-type="JD">

                                                </div>

                                            </div><!--end of card -->
                                            <label class="form-label">HR Screning interview</label>
                                            <div class="card bg-soft-primary">
                                                <div class="card-header">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input competency_check2" type="checkbox"
                                                            id="inlineCheckbox1" value="1">
                                                        <h4 class="card-title">HR Screning interview</h4>
                                                    </div>
                                                </div>
                                                <div class="card-body d-none skill-body" data-type="HR">
                                                    <div id="" class="repeat">
                                                        <div class="repeat-list"
                                                            data-repeater-list="stage[1][HR][question]">
                                                            <div class="repeat-item"
                                                                data-repeater-item="stage[1][HR][question]">

                                                                <div
                                                                    class="form-group row ms-2 my-2 d-flex align-items-end">
                                                                    <div class="col">

                                                                        <input type="text" disabled
                                                                            name="stage[1][HR][question][][question]"
                                                                            placeholder="Question e.g : lorem ipsum a b c?"
                                                                            class="form-control question-input">
                                                                        <div class="question-suggestions"></div>

                                                                    </div><!--end col-->
                                                                    <div class="col-2 text-align-right">
                                                                        <div data-repeater-delete=""
                                                                            class="btn btn-sm btn-outline-danger float-right">
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
                                                                <span data-repeater-create="" data-repeater-list=""
                                                                    class="btn btn-sm btn-soft-primary">
                                                                    <span class="fa fa-plus"></span> Add Question
                                                                </span>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div><!--end of card -->
                                            <label class="form-label">Fit to ORG culture </label>
                                            <div class="card bg-soft-success">
                                                <div class="card-header">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input competency_check2" type="checkbox"
                                                            id="inlineCheckbox1" value="1">
                                                        <h4 class="card-title">Fit to ORG culture </h4>
                                                    </div>
                                                </div>
                                                <div class="card-body d-none skill-body" data-type="ORG">
                                                    <div id="" class="repeat">
                                                        <div class="repeat-list"
                                                            data-repeater-list="stage[1][ORG][question]">
                                                            <div class="repeat-item"
                                                                data-repeater-item="stage[1][ORG][question]">

                                                                <div
                                                                    class="form-group row ms-2 my-2 d-flex align-items-end">
                                                                    <div class="col">

                                                                        <input type="text" disabled
                                                                            name="stage[1][ORG][question][][question]"
                                                                            placeholder="Question e.g : lorem ipsum a b c?"
                                                                            class="form-control question-input">
                                                                        <div class="question-suggestions"></div>

                                                                    </div><!--end col-->
                                                                    <div class="col-2 text-align-right">
                                                                        <div data-repeater-delete=""
                                                                            class="btn btn-sm btn-outline-danger float-right">
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
                                                                <span data-repeater-create="" data-repeater-list=""
                                                                    class="btn btn-sm btn-soft-primary">
                                                                    <span class="fa fa-plus"></span> Add Question
                                                                </span>
                                                            </div>

                                                        </div>

                                                    </div>
                                                </div>

                                            </div><!--end of card -->

                                        </div><!--end of card body -->
                                        <!--end /div-->

                                    </div>
                                    @for ($i = 2; $i < 4; $i++)
                                        <div class="card">
                                            <div class="card-header">

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input stage_check" type="checkbox"
                                                        id="inlineCheckbox1" value="{{ $i }}"
                                                        {{ in_array($i, $stages) ? 'checked' : '' }}>
                                                    <h4 class="card-title">Stage {{ $i }}</h4>
                                                </div>
                                                <div class="btn btn-sm btn-primary toggle-button">Toggle</div>
                                            </div><!--end card-header-->
                                            @if (in_array($i, $stages))
                                                <div class="card-body mb-2 stage_id"
                                                    style="max-height:0px; overflow-y:auto; visibility:hidden;"
                                                    data-stage="{{ $i }}">
                                                    <label class="form-label">Hard Skills</label>
                                                    <div class="card  bg-soft-danger">
                                                        <div class="card-body skill-body" data-type="hard">
                                                            @if ($stages_question->has($i))
                                                                @foreach ($stages_question[$i]->where('competency', 'Hard Skill')->groupBy('competency') as $competency => $competencyQuestions)
                                                                    @foreach ($competencyQuestions->groupBy('skill_id') as $skillId => $skillQuestions)
                                                                        <fieldset id="hard" class="field-set"
                                                                            data-count="{{ $loop->iteration }}">

                                                                            <div class="row">

                                                                                <div class="col-sm-11">
                                                                                    {{-- {{ $loop->iteration }} --}}
                                                                                    @php
                                                                                        $hard_count = $loop->iteration;
                                                                                    @endphp

                                                                                    <select
                                                                                        name="stage[{{ $i }}][hard][{{ $loop->iteration }}][skill]"
                                                                                        class="form-select" required>
                                                                                        <option value="">Select
                                                                                            Skills
                                                                                        </option>
                                                                                        @foreach ($hard as $item)
                                                                                            <option
                                                                                                value="{{ $item->id }}"
                                                                                                {{ $item->id == $skillId ? 'selected' : '' }}>
                                                                                                {{ $item->name }}
                                                                                            </option>
                                                                                        @endforeach

                                                                                    </select>
                                                                                </div><!--end col-->
                                                                                <div class="col text-align-right temp1">
                                                                                    <div
                                                                                        class="btn btn-sm btn-outline-danger float-right skill_delete">
                                                                                        <div class="far fa-trash-alt me-1">
                                                                                        </div>
                                                                                    </div>
                                                                                </div><!--end col-->
                                                                                <div class="repeater-default  repeat">



                                                                                    <div class="repeat-list"
                                                                                        data-repeater-list="stage[{{ $i }}][hard][{{ $hard_count }}][question]">

                                                                                        @foreach ($skillQuestions as $question)
                                                                                            <div class="repeat-item"
                                                                                                data-repeater-item="stage[{{ $i }}][hard][{{ $hard_count }}][question]">

                                                                                                <div
                                                                                                    class="form-group row ms-2 my-2 d-flex align-items-end">
                                                                                                    <div class="col">
                                                                                                        {{-- <label class="form-label">Question</label> --}}
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            name="stage[{{ $i }}][hard][{{ $hard_count }}][question]"
                                                                                                            value="{{ $question->question }}"
                                                                                                            placeholder="Question eg: lorem ipsum a b c?"
                                                                                                            class="form-control question-input"
                                                                                                            required>
                                                                                                        <div
                                                                                                            class="question-suggestions">
                                                                                                        </div>

                                                                                                    </div><!--end col-->
                                                                                                    <div
                                                                                                        class="col-2 text-align-right">
                                                                                                        <div data-repeater-delete=""
                                                                                                            class="btn btn-sm btn-outline-danger float-right">
                                                                                                            <div
                                                                                                                class="far fa-trash-alt me-1">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div><!--end col-->

                                                                                                </div>

                                                                                            </div><!--end col-->
                                                                                        @endforeach

                                                                                    </div><!--end row-->
                                                                                    <div
                                                                                        class="row m-2 mx-3 align-items-center">
                                                                                        <div class="col-7">

                                                                                        </div><!--end col-->
                                                                                        <div
                                                                                            class="col-auto align-self-center">
                                                                                            <span data-repeater-create=""
                                                                                                data-repeater-list=""
                                                                                                class="btn btn-sm btn-soft-primary">
                                                                                                <span
                                                                                                    class="fa fa-plus"></span>
                                                                                                Add Question
                                                                                            </span>
                                                                                        </div>


                                                                                    </div>

                                                                                </div>

                                                                            </div><!--end row-->
                                                                            <hr>
                                                                        </fieldset>

                                                                        <ul>

                                                                        </ul>
                                                                    @endforeach
                                                                @endforeach
                                                            @endif

                                                        </div><!--skill-body-->
                                                        <div class="row mx-3 mb-3">
                                                            <div class="col-md-2">
                                                                <div id="cloneButton"
                                                                    class="cloneButton btn btn-sm btn-outline-secondary">
                                                                    Add Skill</div>
                                                            </div>
                                                        </div>
                                                    </div><!--end of card -->
                                                    <label class="form-label">Soft Skills</label>
                                                    <div class="card bg-soft-primary">
                                                        <div class="card-body skill-body" data-type="soft">
                                                            @if ($stages_question->has($i))
                                                                @foreach ($stages_question[$i]->where('competency', 'Soft Skill')->groupBy('competency') as $competency => $competencyQuestions)
                                                                    @foreach ($competencyQuestions->groupBy('skill_id') as $skillId => $skillQuestions)
                                                                        <fieldset id="soft" class="field-set"
                                                                            data-count="{{ $loop->iteration }}">

                                                                            <div class="row">

                                                                                <div class="col-sm-11">

                                                                                    <select
                                                                                        name="stage[{{ $i }}][soft][{{ $loop->iteration }}][skill]"
                                                                                        class="form-select" required>
                                                                                        <option value="">Select
                                                                                            Skills
                                                                                        </option>
                                                                                        @foreach ($soft as $item)
                                                                                            <option
                                                                                                value="{{ $item->id }}"
                                                                                                {{ $item->id == $skillId ? 'selected' : '' }}>
                                                                                                {{ $item->name }}
                                                                                            </option>
                                                                                        @endforeach

                                                                                    </select>
                                                                                </div><!--end col-->
                                                                                <div class="col text-align-right temp1">
                                                                                    <div
                                                                                        class="btn btn-sm btn-outline-danger float-right skill_delete">
                                                                                        <div class="far fa-trash-alt me-1">
                                                                                        </div>
                                                                                    </div>
                                                                                </div><!--end col-->
                                                                                <div class="repeater-default  repeat">
                                                                                    @php
                                                                                        $soft_count = $loop->iteration;
                                                                                    @endphp


                                                                                    <div class="repeat-list"
                                                                                        data-repeater-list="stage[{{ $i }}][soft][{{ $soft_count }}][question]">

                                                                                        @foreach ($skillQuestions as $question)
                                                                                            <div class="repeat-item"
                                                                                                data-repeater-item="stage[{{ $i }}][soft][{{ $soft_count }}][question]">

                                                                                                <div
                                                                                                    class="form-group row ms-2 my-2 d-flex align-items-end">
                                                                                                    <div class="col">
                                                                                                        {{-- <label class="form-label">Question</label> --}}
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            name="stage[{{ $i }}][soft][{{ $soft_count }}][question]"
                                                                                                            value="{{ $question->question }}"
                                                                                                            placeholder="Question eg: lorem ipsum a b c?"
                                                                                                            class="form-control question-input"
                                                                                                            required>
                                                                                                        <div
                                                                                                            class="question-suggestions">
                                                                                                        </div>

                                                                                                    </div><!--end col-->
                                                                                                    <div
                                                                                                        class="col-2 text-align-right">
                                                                                                        <div data-repeater-delete=""
                                                                                                            class="btn btn-sm btn-outline-danger float-right">
                                                                                                            <div
                                                                                                                class="far fa-trash-alt me-1">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div><!--end col-->

                                                                                                </div>

                                                                                            </div><!--end col-->
                                                                                        @endforeach

                                                                                    </div><!--end row-->
                                                                                    <div
                                                                                        class="row m-2 mx-3 align-items-center">
                                                                                        <div class="col-7">

                                                                                        </div><!--end col-->
                                                                                        <div
                                                                                            class="col-auto align-self-center">
                                                                                            <span data-repeater-create=""
                                                                                                data-repeater-list=""
                                                                                                class="btn btn-sm btn-soft-primary">
                                                                                                <span
                                                                                                    class="fa fa-plus"></span>
                                                                                                Add Question
                                                                                            </span>
                                                                                        </div>
                                                                                    </div>

                                                                                </div>

                                                                            </div><!--end row-->
                                                                            <hr>
                                                                        </fieldset>

                                                                        <ul>

                                                                        </ul>
                                                                    @endforeach
                                                                @endforeach
                                                            @endif
                                                        </div><!--skill-body-->
                                                        <div class="row mx-3 mb-3">
                                                            <div class="col-md-2">
                                                                <div id="cloneButton"
                                                                    class="cloneButton btn btn-sm btn-outline-secondary">
                                                                    Add Skill</div>
                                                            </div>
                                                        </div>
                                                    </div><!--end of card -->
                                                    <label class="form-label">Team Fit</label>
                                                    <div class="card bg-soft-success">
                                                        <div class="card-body skill-body" data-type="team">
                                                            @if ($stages_question->has($i))
                                                                @foreach ($stages_question[$i]->where('competency', 'Team Fit')->groupBy('competency') as $competency => $competencyQuestions)
                                                                    @foreach ($competencyQuestions->groupBy('skill_id') as $skillId => $skillQuestions)
                                                                        <fieldset id="team" class="field-set"
                                                                            data-count="{{ $loop->iteration }}">

                                                                            <div class="row">

                                                                                <div class="col-sm-11">

                                                                                    <select
                                                                                        name="stage[{{ $i }}][team][{{ $loop->iteration }}][skill]"
                                                                                        class="form-select" required>
                                                                                        <option value="">Select
                                                                                            Skills
                                                                                        </option>
                                                                                        @foreach ($team as $item)
                                                                                            <option
                                                                                                value="{{ $item->id }}"
                                                                                                {{ $item->id == $skillId ? 'selected' : '' }}>
                                                                                                {{ $item->name }}
                                                                                            </option>
                                                                                        @endforeach

                                                                                    </select>
                                                                                </div><!--end col-->
                                                                                <div class="col text-align-right temp1">
                                                                                    <div
                                                                                        class="btn btn-sm btn-outline-danger float-right skill_delete">
                                                                                        <div class="far fa-trash-alt me-1">
                                                                                        </div>
                                                                                    </div>
                                                                                </div><!--end col-->
                                                                                <div class="repeater-default  repeat">
                                                                                    @php
                                                                                        $team_count = $loop->iteration;
                                                                                    @endphp


                                                                                    <div class="repeat-list"
                                                                                        data-repeater-list="stage[{{ $i }}][team][{{ $team_count }}][question]">

                                                                                        @foreach ($skillQuestions as $question)
                                                                                            <div class="repeat-item"
                                                                                                data-repeater-item="stage[1][team][{{ $team_count }}][question]">

                                                                                                <div
                                                                                                    class="form-group row ms-2 my-2 d-flex align-items-end">
                                                                                                    <div class="col">
                                                                                                        {{-- <label class="form-label">Question</label> --}}
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            name="stage[{{ $i }}][team][{{ $team_count }}][question]"
                                                                                                            value="{{ $question->question }}"
                                                                                                            placeholder="Question eg: lorem ipsum a b c?"
                                                                                                            class="form-control question-input"
                                                                                                            required>
                                                                                                        <div
                                                                                                            class="question-suggestions">
                                                                                                        </div>

                                                                                                    </div><!--end col-->
                                                                                                    <div
                                                                                                        class="col-2 text-align-right">
                                                                                                        <div data-repeater-delete=""
                                                                                                            class="btn btn-sm btn-outline-danger float-right">
                                                                                                            <div
                                                                                                                class="far fa-trash-alt me-1">
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div><!--end col-->

                                                                                                </div>

                                                                                            </div><!--end col-->
                                                                                        @endforeach

                                                                                    </div><!--end row-->
                                                                                    <div
                                                                                        class="row m-2 mx-3 align-items-center">
                                                                                        <div class="col-7">

                                                                                        </div><!--end col-->
                                                                                        <div
                                                                                            class="col-auto align-self-center">
                                                                                            <span data-repeater-create=""
                                                                                                data-repeater-list=""
                                                                                                class="btn btn-sm btn-soft-primary">
                                                                                                <span
                                                                                                    class="fa fa-plus"></span>
                                                                                                Add Question
                                                                                            </span>
                                                                                        </div>

                                                                                    </div>

                                                                                </div>

                                                                            </div><!--end row-->
                                                                            <hr>
                                                                        </fieldset>

                                                                        <ul>

                                                                        </ul>
                                                                    @endforeach
                                                                @endforeach
                                                            @endif

                                                        </div><!--skill-body-->
                                                        <div class="row mx-3 mb-3">
                                                            <div class="col-md-2">
                                                                <div id="cloneButton"
                                                                    class="cloneButton btn btn-sm btn-outline-secondary">
                                                                    Add Skill</div>
                                                            </div>
                                                        </div>
                                                    </div><!--end of card -->

                                                </div><!--end of card body -->
                                            @endif

                                            <!--end /div-->

                                        </div><!--end card-->
                                    @endfor

                                </div><!--end col-->
                            </div><!-- end col -->
                        </div><!-- end row -->
                        <button class="btn btn-primary text-white" type="submit">Update Job</button>
                    </div><!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
    </form>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            var $tagsInput = $(".question-input");
            $('.stage_check:checked').each(function() {
                var stage_value = $(this).val();
                var stageBody = $(this).siblings('.stage_id');
                var cardheader = $(this).closest('.card-header');
                stageBody.css("visibility", "visible");
                stageBody.css("max-height", "");
                stageBody.data("stage", stage_value);

                // $(".cloneButton").on('click', add_skill);
            });



            // $(".repeat").repeater();
            $('.repeat').on("input", '.question-input', function() {
                var row2 = $(this).closest('fieldset');
                var skill_id = row2.find('select').val();
                read_input.call(this, skill_id);
            });
            $('.stage_check').on('change', show_stage_body);

            function show_stage_body() {
                var checkbox = $(this);
                var isChecked = $(this).prop("checked");
                var stage_value = $(this).val();
                if (isChecked) {
                    var stageBody = $("#stage-body").clone();
                    var cardheader = $(this).closest('.card-header');
                    stageBody.css("visibility", "visible");
                    stageBody.css("max-height", "");
                    stageBody.data("stage", stage_value);
                    cardheader.after(stageBody);
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


                            card.find('.toggle-button').css('visibility', 'hidden');
                            card.find('.card-body').remove();

                        } else if (
                            // Read more about handling dismissals
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            swal.fire(
                                'Cancelled',
                                'Your changes are safe :)',
                                'error'
                            );
                            $('.stage_check').off('change', show_stage_body);
                            $('.stage_check').on('change', show_stage_body);
                            checkbox.prop('checked', true);
                        }
                    })

                }




            }

            var $tagSuggestions = $tagsInput.closest(".question-suggestions");
            $('.form-select').on('change', init_repeater);



            var a = 0
            // const Element = $(".field-set").first()clone();
            $(".cloneButton").on('click', add_skill);

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
                var type = skill_body.data("type");
                // Clone the element
                count++;
                console.log(count);
                clonedElement.find('.repeat').remove();
                var skill_name = `stage[${stage_id}][${type}][${count}][skill]`;
                clonedElement.find("select").attr("name", skill_name);
                skill_body.append(clonedElement);
                skill_body.find("fieldset").last().data("count", count);
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


                } else {
                    cardBody.css("max-height", "0px");

                    cardBody.css("visibility", "hidden");
                }
            });

            function delete_skill() {
                var fieldset = $(this).closest('fieldset');
                fieldset.remove();
            }

            function read_input(skill_id) {

                // Get the user's input
                $tagsInput = $(this);
                console.log(skill_id);
                debugger

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
                        // debugger
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
                            // debugger
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

            function init_repeater() {
                var row1 = $(this).closest('.row')
                var skill_id = $(this).val();
                var skill_body = $(this).closest('.card').find('.skill-body')
                var clonedElement1 = $('#repeat_temp').clone();
                var count = $(this).closest("fieldset").data("count");
                var stage_id = $(this).closest('.stage_id').data('stage');
                var type = skill_body.data("type");
                console.log(type);
                // Clone the element

                // count++;
                console.log(count);

                // debugger
                // Modify the data-repeater-list attribute
                // skill_name = type + "[" + count + "][skill]";
                // list_name = type + "[" + count + "][question]";
                // input_name = type + "[" + count + "][question]";
                // console.log(input_name);

                var skill_name = `stage[${stage_id}][${type}][${count}][skill]`;
                var list_name = `stage[${stage_id}][${type}][${count}][question]`;
                var input_name = `stage[${stage_id}][${type}][${count}][question]`;


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
            }

        });
    </script>
@endsection
