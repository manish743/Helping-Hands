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
                                    <form action="{{ route('interview_option_confirm') }}" id="myForm" method="post" enctype="multipart/form-data">
                                        @csrf
                                        {{-- <input type="hidden" name="id" value="{{ $id }}"> --}}
                                        <div class="row p-3">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Please select a Interview Time</h4>
                                                        <p class="text-muted mb-0">
                                                        </p>
                                                    </div><!--end card-header-->
                                                    <div class="card-body bootstrap-select-1">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                @foreach ($interview_option as $item)
                                                                            
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" required name="interview_option" id="exampleRadios{{$loop->iteration }}" value="{{base64_encode( $item->id) }}">
                                                                    <label class="form-check-label" for="inlineRadio{{$loop->iteration }}">{{$loop->iteration }}.
                                                                        <div class="btn btn-outline-primary "  >{{ $item->interview_date}}<i class="ms-1 fas fa-calendar-alt"></i></div>
                                                                        <div class="btn btn-outline-primary">{{ $item->interview_time}}<i class="ms-1 fas fa-clock"></i></div>
                                                                    </label>
                                                                </div>
                                                          
                                                                @endforeach
                                                                
                                                            </div>
                                                            {{-- <div class="col-md-8">
                                                               
                                                                
                                                                <div class="form-group">
                                                                    <label class="form-label">Interview Time</label>
                                
                                                                    <select id="hard_skill_select" name="interview_date"
                                                                        class="select2 mb-3" style="width: 100%"
                                                                        data-placeholder="Choose">
                                                                        <option value=""></option>
                                                                        @foreach ($interview_option as $item)
                                                                            <option value="{{ $item->id }}">{{ $item->interview_date ." " .$item->interview_time}}</option>
                                                                        @endforeach
                                
                                                                    </select>
                                                                    <span class="text-danger">
                                                                        @error('hard_skill')
                                                                            {{ $message }}
                                                                        @enderror
                                                                    </span>
                                                                </div>
                                                               
                                                            </div><!-- end col --> --}}
                                                           
                                                        </div><!-- end row -->
                                                     
                                
                                
                                
                                                        <button class="btn btn-primary text-white" type="submit">Confirm Date</button>
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
   
@endsection
