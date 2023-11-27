@extends('layouts.master-without_nav')
@section('title')
    Register
@endsection
@section('content')

    <body class="account-body accountbg">


        <div class="container">
            <div class="row vh-100 d-flex justify-content-center">
                <div class="col-12 align-self-center">
                    <div class="row">
                        <div class="col-lg-10 mx-auto">
                            <div class="card" style="border:none;">
                                <div class="text-center">


                                </div>

                                @if (Session::has('success'))
                                    <div class="alert alert-success text-center">
                                        {{ Session::get('success') }}
                                    </div>
                                @endif
                                @if (session('warning'))
                                    <div class="alert alert-danger center">
                                        {{ session('warning') }}
                                    </div>
                                @endif

                                <div class="card-body">
                                    <div class="text-center">
                                        <a href="index" class="logo logo-admin">

                                            <img src="{{ URL::asset('assets/images/CIM_Logo.svg') }}" height="120"
                                                alt="logo" class="auth-logo">

                                        </a>

                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <form action="{{ route('candidates-store') }}" id="myForm" method="post"
                                        enctype="multipart/form-data" novalidate>
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $id }}">
                                        <div class="row p-3">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">candidates Information</h4>
                                                        <p class="text-muted mb-0">Fill The Form below to create new
                                                            candidates
                                                        </p>
                                                    </div><!--end card-header-->
                                                    <div class="card-body bootstrap-select-1">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label">First Name</label>
                                                                       
                                                                                <input required type="text"
                                                                                    name="first_name" class="form-control"
                                                                                    parsley-type="text"
                                                                                    placeholder="Enter First Name">

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
                                                                          
                                                                                <input required type="text"
                                                                                    name="last_name" class="form-control"
                                                                                    parsley-type="text"
                                                                                    placeholder="Enter Last Name">

                                                                          
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
                                                                          
                                                                                <input required type="email"
                                                                                    name="email" class="form-control"
                                                                                    parsley-type="text"
                                                                                    placeholder="Enter email">

                                                                         
                                                                            <span class="text-danger">
                                                                                @error('email')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Type of
                                                                                Employement</label>
                                                                       
                                                                                <select name="job_type"
                                                                                    class="select2 form-control mb-3 custom-select"
                                                                                    style="width: 100%; height:36px;">
                                                                                    <option value="">Select</option>


                                                                                    <option value="Contractual-Fulltime">
                                                                                        Contractual-Fulltime</option>
                                                                                    <option value=" Permanent-Fulltime">
                                                                                        Permanent-Fulltime</option>
                                                                                    <option value=" Freelance"> Freelance
                                                                                    </option>
                                                                                    <option value="Part-Time">Part-Time
                                                                                    </option>


                                                                                </select>

                                                                            <span class="text-danger">
                                                                                @error('job_type')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Area of
                                                                                Speciality</label>
                                                                           
                                                                                <input name="area_of_speciality"
                                                                                    class="form-control" parsley-type="text"
                                                                                    placeholder="Area of Speciality">

                                                                          
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
                                                                           
                                                                                <input required type="text"
                                                                                    name="contact" class="form-control"
                                                                                    parsley-type="text"
                                                                                    placeholder="923 *** ****">

                                                                          
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
                                                                           
                                                                                <input required type="password"
                                                                                    name="password" class="form-control"
                                                                                    parsley-type="password"
                                                                                    placeholder="password">

                                                                            
                                                                            <span class="text-danger">
                                                                                @error('password')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Confirm
                                                                                Password</label>
                                                                            
                                                                                <input required type="password"
                                                                                    name="password_confirmation"
                                                                                    class="form-control"
                                                                                    parsley-type="password"
                                                                                    placeholder="confirm password">

                                                                            
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
                                                                            <label class="form-label">Current
                                                                                Salary</label>
                                                                            
                                                                                <input type="number"
                                                                                    name="current_salary"
                                                                                    class="form-control"
                                                                                    parsley-type="current_salary"
                                                                                    placeholder="Current Salary">

                                                                            
                                                                            <span class="text-danger">
                                                                                @error('current_salary')
                                                                                    {{ $message }}
                                                                                @enderror
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-group">
                                                                            <label class="form-label">Expected
                                                                                Salary</label>
                                                                            
                                                                                <input type="number"
                                                                                    name="expected_salary"
                                                                                    class="form-control"
                                                                                    parsley-type="expected_salary"
                                                                                    placeholder="Expected Salary">

                                                                            
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
                                                                            <label class="form-label">Current Job
                                                                                Title</label>
                                                                           
                                                                                <input type="text"
                                                                                    name="current_job_title"
                                                                                    class="form-control"
                                                                                    parsley-type="current_salary"
                                                                                    placeholder="Current Job Title">

                                                                           
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
                                                                           
                                                                                <input type="text"
                                                                                    name="current_job_tenure"
                                                                                    class="form-control"
                                                                                    parsley-type="current_job_tenure"
                                                                                    placeholder="How many years you have worked here">

                                                                           
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
                                                                   
                                                                        <input type="text" name="current_company_name"
                                                                            class="form-control"
                                                                            parsley-type="current_company_name"
                                                                            placeholder="Current Company Name">

                                                                   
                                                                    <span class="text-danger">
                                                                        @error('current_company_name')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Responsibilities</label>
                                                                   
                                                                        <textarea rows="4" name="current_responsibility" class="form-control" parsley-type="current_responsibility"></textarea>

                                                                    
                                                                    <span class="text-danger">
                                                                        @error('current_responsibility')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Achievements</label>
                                                                   
                                                                        <textarea rows="4" name="current_achievement" class="form-control" parsley-type="current_achievement"></textarea>

                                                                   
                                                                    <span class="text-danger">
                                                                        @error('current_achievement')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">skills developed</label>
                                                                    
                                                                        <textarea rows="4" name="current_skills_developed" class="form-control"
                                                                            parsley-type="current_skills_developed"></textarea>

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
                                                                            <label class="form-label">Previous Job
                                                                                Title</label>
                                                                          
                                                                                <input type="text"
                                                                                    name="previous_job_title"
                                                                                    class="form-control"
                                                                                    parsley-type="previous_salary"
                                                                                    placeholder="Previous Job Title">

                                                                            
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
                                                                            
                                                                                <input type="text"
                                                                                    name="previous_job_tenure"
                                                                                    class="form-control"
                                                                                    parsley-type="previous_job_tenure"
                                                                                    placeholder="How many years you have worked here">

                                                                            
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
                                                                    
                                                                        <input type="text" name="previous_company_name"
                                                                            class="form-control"
                                                                            parsley-type="previous_company_name"
                                                                            placeholder="Previous Company Name">

                                                                    
                                                                    <span class="text-danger">
                                                                        @error('previous_company_name')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Responsibilities</label>
                                                                    
                                                                        <textarea rows="4" name="previous_responsibility" class="form-control" parsley-type="previous_responsibility"></textarea>

                                                                   
                                                                    <span class="text-danger">
                                                                        @error('previous_responsibility')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Achievements</label>
                                                                   
                                                                        <textarea rows="4" name="previous_achievement" class="form-control" parsley-type="previous_achievement"></textarea>

                                                                   
                                                                    <span class="text-danger">
                                                                        @error('previous_achievement')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">skills developed</label>
                                                                    
                                                                        <textarea rows="4" name="previous_skills_developed" class="form-control"
                                                                            parsley-type="previous_skills_developed"></textarea>

                                                                   
                                                                    <span class="text-danger">
                                                                        @error('previous_skills_developed')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>


                                                                <div class="form-group">
                                                                    <label class="form-label">Area of Interest</label>
                                                                    
                                                                        <textarea rows="4" name="area_of_interest" class="form-control" parsley-type="area_of_interest"></textarea>

                                                                    
                                                                    <span class="text-danger">
                                                                        @error('area_of_interest')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Hard Skills</label>

                                                                    <select id="hard_skill_select" name="hard_skill[]"
                                                                        class="select2 mb-3 select2-multiple"
                                                                        style="width: 100%" multiple="multiple"
                                                                        data-placeholder="Choose">
                                                                        <option value=""></option>
                                                                        @foreach ($hard_skill as $item)
                                                                            <option value="{{ $item->id }}">
                                                                                {{ $item->name }}</option>
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
                                                                    
                                                                        <select id="skill_detail_select"
                                                                            name="skill_detail[]"
                                                                            class="select2 mb-3 select2-multiple"
                                                                            style="width: 100%" multiple="multiple"
                                                                            data-placeholder="Choose">
                                                                            <option value=""></option>

                                                                            @foreach ($skill_category as $key => $item)
                                                                                <optgroup data-hard="{{ $key }}">
                                                                                    @foreach ($item as $skill_cat)
                                                                                        <option
                                                                                            value="{{ $skill_cat['id'] }}">
                                                                                            {{ $skill_cat['name'] }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </optgroup>
                                                                            @endforeach

                                                                        </select>

                                                                    
                                                                    <span class="text-danger">
                                                                        @error('skill_detail')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="form-label">Upload your CV here</label>
                                                                    
                                                                        <input type="file" id="input-file-now-custom-2"
                                                                            name="cv" class="dropify"
                                                                            data-height="100" />

                                                                   
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
                                                                        <input type="file" id="input-file-now-custom-2"
                                                                            name="image" class="dropify"
                                                                            data-height="200" />
                                                                    </div><!--end card-body-->
                                                                </div><!--end card-->
                                                            </div><!--end col-->
                                                        </div><!-- end row -->
                                                        <div class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input required class="form-check-input" type="checkbox"
                                                                    name="true_box" value="3">
                                                                <label class="form-check-label" for="inlineCheckbox3">All
                                                                    the information's that i
                                                                    submitted here are correct </label>

                                                            </div>
                                                            <span class="text-danger">
                                                                @error('true_box')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="form-check form-check-inline">
                                                                <input required class="form-check-input" type="checkbox"
                                                                    name="terms_agree" value="3">
                                                                <label class="form-check-label" for="inlineCheckbox3">I
                                                                    agree to all the terms and
                                                                    conditions </label>

                                                            </div>
                                                            <span class="text-danger">
                                                                @error('terms_agree')
                                                                    {{ $message }}
                                                                @enderror
                                                            </span>
                                                        </div>



                                                        <button class="btn btn-primary text-white" type="submit">Create
                                                            candidates</button>
                                                    </div><!-- end card-body -->

                                                </div> <!-- end card -->
                                            </div> <!-- end col -->

                                        </div>

                                    </form>
                                </div>

                                <div class="card-body bg-light-alt text-center">
                                    <span class="text-muted d-none d-sm-inline-block">
                                        &copy; 2023 Careers In Motions


                                        {{-- Mannatthemes ©
                                        <script>
                                            document.write(new Date().getFullYear())
                                        </script> --}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
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

            $('#myForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting normally



                let isValid = true;
                var toastContainer = $('#warning-toast').find('.toast-container');
                toastContainer.empty();
                var isFirstIteration = true;
                $(this).find('[required]').each(function() {
                    $(this).siblings('.error-message').remove();

                    if ($(this).val() === '') {
                        isValid = false; // If a required field is empty, set isValid to false
                        $(this).addClass('error'); // Optionally, add a CSS class for styling
                        // $(this).siblings('label').addClass('error'); // Optionally, add a CSS class for styling
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
                        // $(this).css('border', '1px solid yellow');

                    } else {
                        $(this).removeClass('error'); // Optionally, add a CSS class for styling
                        $(this).siblings('label').removeClass('error');
                        $(this).siblings('.error-message').remove();
                        $(this).css('border', '').focus();
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

                    $('#myForm').unbind('submit').submit();
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
