@extends('layouts.master-without_nav')

@section('title')
    Login
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
                                        <h5>Access Denied <i class="mdi mdi-lock-clock fs-5"></i> </h5>
                                        <div class="countdown">
                                            <p class="demo"></p>
                                        </div>
                                        <h5 class="text-warning">You can access this page on {{ $opening_date }}</h5>
                                        <h5>Upload Your Case Study Here before :
                                        </h5>
                                        {{-- <h3 class="text-primary">
                                            {{ \Carbon\Carbon::parse($case_study->submission_date)->format('jS F Y') }}
                                            ,
                                            {{ \Carbon\Carbon::parse($case_study->submission_time)->format('g:i A') }}
                                        </h3> --}}
                                        {{-- @if ($case_study->case_study) --}}
                                        <div id="case_study_success">
                                            <h3 class="text-success">Case Study received!!</h3>
                                            <h3 class="text-success">Thank You</h3>
                                        </div>


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

        <div class="modal fade bd-example-modal-lg" id="extend_submission_date" tabindex="-1" role="dialog"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="text-white">Access Denied</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div><!--end modal-header-->
                    <div class="modal-body">
                        <div class="text-center">
                            <i class="mdi mdi-lock-clock" style="font-size: 9rem"></i>
                            <h5>Access Denied </h5>

                            <h5 class="text-warning">You can access this page on {{ $opening_date }}</h5>


                        </div>
                        <div class="countdown">
                            <p class="demo"></p>
                        </div>
                    </div><!--end modal-body-->

                </div><!--end modal-content-->
            </div><!--end modal-dialog-->
        </div><!--end modal-->
    </body>
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            var countDownDate = new Date();
            countDownDate.setMinutes(countDownDate.getMinutes() + {{ $minutesDifference }});
            var x = setInterval(function() {
                var now = new Date().getTime();
                var distance = countDownDate - now;
                var hours = Math.floor(distance / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                $(".demo").text(hours + "h " + minutes + "m " + seconds + "s ");

                if (distance < 0) {
                    clearInterval(x);
                    $(".demo").text("EXPIRED");
                }
            }, 1000);
            var $modal = $('.modal');
            $modal.modal('show');



        });
    </script>
    <script></script>
@endsection
