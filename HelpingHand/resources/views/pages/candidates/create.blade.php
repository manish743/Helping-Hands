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
    <form action="{{ route('candidates-store') }}" id="myForm" method="post" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="id" value="{{ $id }}">
        <div class="row p-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">candidates Information</h4>
                        <p class="text-muted mb-0">Fill The Form below to create new candidates
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body bootstrap-select-1">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">First Name</label>
                                            <div>
                                                <input required type="text" name="first_name" class="form-control"
                                                    parsley-type="text" placeholder="Enter First Name">

                                            </div>
                                            <span class="text-danger">
                                                @error('first_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Last Name</label>
                                            <div>
                                                <input required type="text" name="last_name" class="form-control"
                                                    parsley-type="text" placeholder="Enter Last Name">

                                            </div>
                                            <span class="text-danger">
                                                @error('last_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Email Address</label>
                                            <div>
                                                <input required type="email" name="email" class="form-control"
                                                    parsley-type="text" placeholder="Enter email">

                                            </div>
                                            <span class="text-danger">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Type of Employement</label>
                                            <div>
                                                <select name="job_type" class="select2 form-control mb-3 custom-select"
                                                    style="width: 100%; height:36px;">
                                                    <option value="">Select</option>


                                                    <option value="Contractual-Fulltime">Contractual-Fulltime</option>
                                                    <option value=" Permanent-Fulltime"> Permanent-Fulltime</option>
                                                    <option value=" Freelance"> Freelance</option>
                                                    <option value="Part-Time">Part-Time</option>


                                                </select>

                                            </div>
                                            <span class="text-danger">
                                                @error('job_type')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Area of Speciality</label>
                                            <div>
                                                <input name="area_of_speciality" class="form-control" parsley-type="text"
                                                    placeholder="Area of Speciality">
        
                                            </div>
                                            <span class="text-danger">
                                                @error('area_of_speciality')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Contact</label>
                                            <div>
                                                <input required type="text" name="contact" class="form-control"
                                                    parsley-type="text" placeholder="923 *** ****">

                                            </div>
                                            <span class="text-danger">
                                                @error('contact')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Password</label>
                                            <div>
                                                <input required type="password" name="password" class="form-control"
                                                    parsley-type="password" placeholder="password">

                                            </div>
                                            <span class="text-danger">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Confirm Password</label>
                                            <div>
                                                <input required type="password" name="password_confirmation" class="form-control"
                                                    parsley-type="password" placeholder="confirm password">

                                            </div>
                                            <span class="text-danger">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Current Salary</label>
                                            <div>
                                                <input type="number" name="current_salary" class="form-control"
                                                    parsley-type="current_salary" placeholder="Current Salary">

                                            </div>
                                            <span class="text-danger">
                                                @error('current_salary')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Expected Salary</label>
                                            <div>
                                                <input type="number" name="expected_salary" class="form-control"
                                                    parsley-type="expected_salary" placeholder="Expected Salary">

                                            </div>
                                            <span class="text-danger">
                                                @error('expected_salary')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                               
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Current Job Title</label>
                                            <div>
                                                <input type="text" name="current_job_title" class="form-control"
                                                    parsley-type="current_salary" placeholder="Current Job Title">

                                            </div>
                                            <span class="text-danger">
                                                @error('current_job_title')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Tenure in Job</label>
                                            <div>
                                                <input type="text" name="current_job_tenure" class="form-control"
                                                    parsley-type="current_job_tenure"
                                                    placeholder="How many years you have worked here">

                                            </div>
                                            <span class="text-danger">
                                                @error('current_job_tenure')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Current Company Name</label>
                                    <div>
                                        <input type="text" name="current_company_name" class="form-control"
                                            parsley-type="current_company_name" placeholder="Current Company Name">

                                    </div>
                                    <span class="text-danger">
                                        @error('current_company_name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Responsibilities</label>
                                    <div>
                                        <textarea rows="4" name="current_responsibility" class="form-control" parsley-type="current_responsibility"></textarea>

                                    </div>
                                    <span class="text-danger">
                                        @error('current_responsibility')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Achievements</label>
                                    <div>
                                        <textarea rows="4" name="current_achievement" class="form-control" parsley-type="current_achievement"></textarea>

                                    </div>
                                    <span class="text-danger">
                                        @error('current_achievement')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">skills developed</label>
                                    <div>
                                        <textarea rows="4" name="current_skills_developed" class="form-control" parsley-type="current_skills_developed"></textarea>

                                    </div>
                                    <span class="text-danger">
                                        @error('current_skills_developed')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Previous Job Title</label>
                                            <div>
                                                <input type="text" name="previous_job_title" class="form-control"
                                                    parsley-type="previous_salary" placeholder="Previous Job Title">

                                            </div>
                                            <span class="text-danger">
                                                @error('previous_job_title')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Tenure in Job</label>
                                            <div>
                                                <input type="text" name="previous_job_tenure" class="form-control"
                                                    parsley-type="previous_job_tenure"
                                                    placeholder="How many years you have worked here">

                                            </div>
                                            <span class="text-danger">
                                                @error('previous_job_tenure')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Previous Company Name</label>
                                    <div>
                                        <input type="text" name="previous_company_name" class="form-control"
                                            parsley-type="previous_company_name" placeholder="Previous Company Name">

                                    </div>
                                    <span class="text-danger">
                                        @error('previous_company_name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Responsibilities</label>
                                    <div>
                                        <textarea rows="4" name="previous_responsibility" class="form-control" parsley-type="previous_responsibility"></textarea>

                                    </div>
                                    <span class="text-danger">
                                        @error('previous_responsibility')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Achievements</label>
                                    <div>
                                        <textarea rows="4" name="previous_achievement" class="form-control" parsley-type="previous_achievement"></textarea>

                                    </div>
                                    <span class="text-danger">
                                        @error('previous_achievement')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">skills developed</label>
                                    <div>
                                        <textarea rows="4" name="previous_skills_developed" class="form-control" parsley-type="previous_skills_developed"></textarea>

                                    </div>
                                    <span class="text-danger">
                                        @error('previous_skills_developed')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>


                                <div class="form-group">
                                    <label class="form-label">Area of Interest</label>
                                    <div>
                                        <textarea rows="4" name="area_of_interest" class="form-control" parsley-type="area_of_interest"></textarea>

                                    </div>
                                    <span class="text-danger">
                                        @error('area_of_interest')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Hard Skills</label>

                                    <select id="hard_skill_select" name="hard_skill[]"
                                        class="select2 mb-3 select2-multiple" style="width: 100%" multiple="multiple"
                                        data-placeholder="Choose">
                                        <option value=""></option>
                                        @foreach ($hard_skill as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach

                                    </select>
                                    <span class="text-danger">
                                        @error('hard_skill')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Specify Skills detail</label>
                                    <div>
                                        <select id="skill_detail_select" name="skill_detail[]"
                                            class="select2 mb-3 select2-multiple" style="width: 100%" multiple="multiple"
                                            data-placeholder="Choose">
                                            <option value=""></option>

                                            @foreach ($skill_category as $key => $item)
                                                <optgroup data-hard="{{ $key }}">
                                                    @foreach ($item as $skill_cat)
                                                        <option value="{{ $skill_cat['id'] }}">{{ $skill_cat['name'] }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach

                                        </select>

                                    </div>
                                    <span class="text-danger">
                                        @error('skill_detail')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Upload your CV here</label>
                                    <div>
                                        <input type="file" id="input-file-now-custom-2" name="cv"
                                            class="dropify" data-height="100" />

                                    </div>
                                    <span class="text-danger">
                                        @error('cv')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                            </div><!-- end col -->
                            <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Photo</h4>
                                        <span class="text-danger">
                                            @error('image')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div><!--end card-header-->
                                    <div class="card-body">
                                        <input type="file" id="input-file-now-custom-2" name="image"
                                            class="dropify" data-height="200" />
                                    </div><!--end card-body-->
                                </div><!--end card-->
                            </div><!--end col-->
                        </div><!-- end row -->
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input required class="form-check-input" type="checkbox" name="true_box" value="3">
                                <label class="form-check-label" for="inlineCheckbox3">All the information's that i
                                    submitted here are correct </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input required class="form-check-input" type="checkbox" name="terms_agree" value="3">
                                <label class="form-check-label" for="inlineCheckbox3">I agree to all the terms and
                                    conditions </label>
                            </div>
                        </div>



                        <button class="btn btn-primary text-white" type="submit">Create candidates</button>
                    </div><!-- end card-body -->

                </div> <!-- end card -->
            </div> <!-- end col -->

        </div>

    </form>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            // Initialize Select2 for both selects
            $('#hard_skill_select').select2();
            $('#skill_detail_select').select2();

            // Add an event listener for the hard_skill select
            $('#hard_skill_select').on('change', function() {
                // Get the selected hard_skills
                const selectedHardSkills = $(this).val();

                // Clear and repopulate the skill_detail select
                $('#skill_detail_select').empty();

                // Iterate over skill categories
                @foreach ($skill_category as $key => $item)
                    if ($.inArray('{{ $key }}', selectedHardSkills) !== -1) {
                        @foreach ($item as $skill_cat)
                            $('#skill_detail_select').append($('<option>', {
                                value: '{{ $skill_cat['id'] }}',
                                text: '{{ $skill_cat['name'] }}'
                            }));
                        @endforeach
                    }
                @endforeach

                // Refresh the Select2 for the skill_detail select
                $('#skill_detail_select').trigger('change');
            });

            // Trigger the initial change event to set up the skill_detail select
            $('#hard_skill_select').trigger('change');
        });
    </script>
@endsection
