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
                        <div class="col-lg-8 mx-auto">
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
                                    <div class="text-center">
                                        <h5>Upload Case Study</h5>
                                        <h5 class="text-warning">(This link is open for 24 hr, you can change you decision
                                            while the link is available)</h5>
                                        <h5>Upload Your Case Study Here before :
                                        </h5>
                                        <h3 class="text-primary">
                                            {{ \Carbon\Carbon::parse($case_study->submission_date)->format('jS F Y') }}
                                            ,
                                            {{ \Carbon\Carbon::parse($case_study->submission_time)->format('g:i A') }}
                                        </h3>
                                        @if ($case_study->case_study)
                                        <div id="case_study_success">
                                            <h3 class="text-success">Case Study received!!</h3>
                                            <h3 class="text-success">Thank You</h3>
                                        </div>
                                        @else
                                            <form action="{{ route('store_case_study') }}" id="myForm" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="case_study_id"
                                                    value="{{ base64_encode($case_study->id) }}">
                                                <div class="row col-auto align-self-center mb-2 ">
                                                    <input type="hidden" name="job_applicant_id" class="job_applicant_id"
                                                        value="{{ base64_encode($job_applicant->id) }}">

                                                    <div class="form-group ">
                                                        <label class="form-label">Upload your Case Study
                                                            Material</label>

                                                        <input type="file" id="input-file-now-custom-2" name="case_study"
                                                            class="dropify" data-height="100" />


                                                        <span class="text-danger" id="case_study_error">
                                                            @error('case_study')
                                                                {{ $message }}
                                                            @enderror
                                                        </span>
                                                    </div>

                                                </div>
                                                <div class="col-auto align-self-center">
                                                    <span class="text-danger" id="action_error">
                                                        @error('action')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                    <br>
                                                    <button class="btn btn-primary text-white"
                                                        type="submit">Submit</button>
                                                </div>

                                            </form>
                                        @endif

                                    </div>
                                </div>
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
                        } else {
                            // Validation passed, you can close the modal or perform other actions
                            // $('#exampleModalLarge').modal('hide');
                            if (data.status) {
                                swal.fire(
                                    'Success!',
                                    data.Message,
                                    'success').then(function() {
                                        $success=$('#case_study_success').clone();
                                        $('#case_study_success').remove();
                                        debugger
                                        $form.replaceWith($success);
                                });

                            }
                        }
                    }
                });
            });
        })
    </script>
@endsection
