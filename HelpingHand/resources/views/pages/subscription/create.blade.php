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
            Subscription
        @endslot
        {{-- @slot('li_3')
            Analytics
        @endslot --}}
        @slot('title')
            Subscription
        @endslot
    @endcomponent
    <form action="{{ route('subscription-store') }}" method="post">
        @csrf
        <div class="row p-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Subcription Package Infromation</h4>
                        <p class="text-muted mb-0">Fill The Form below to create new Subscriptiojn Package
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body bootstrap-select-1">
                        <div class="row">
                            <div class="col-md-8">

                                <div class="form-group">
                                    <label class="form-label">Subscription Package Name</label>
                                    <div>
                                        <input type="text" name="name" class="form-control" parsley-type="text"
                                            placeholder="Enter a Subscription Package Name">

                                    </div>
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-4 my-1 form-label">Package Type:</label>

                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="package_type"
                                                id="inlineRadio1"
                                                value="Founding
                                                Subscriptions">
                                            <label class="form-check-label" for="inlineRadio1">Founding
                                                Subscriptions</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="package_type"
                                                id="inlineRadio2" value="Regular Subscription">
                                            <label class="form-check-label" for="inlineRadio2">Regular Subscription</label>
                                        </div>
                                        <span class="text-danger">
                                            @error('package_type')
                                                {{ $message }}
                                            @enderror
                                        </span>

                                    </div>
                                </div> <!--end row-->
                                


                            </div><!-- end col -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label class="mb-3 form-label">Subscription Duration</label>
                                        <select name="subscription_duration" class="select2 form-control mb-3 custom-select"
                                            style="width: 100%; height:36px;">
                                            <option value="">Select</option>
                                            @for ($i = 1; $i < 13; $i++)
                                                <option value="{{ $i }}">{{ $i }} month</option>
                                            @endfor
                                            <option value="18">18 month</option>
                                            <option value="24">24 month</option>
                                            <option value="36">36 month</option>
    
    
                                        </select>
                                        <span class="text-danger">
                                            @error('subscription_duration')
                                                {{ $message }}
                                            @enderror
                                        </span>
    
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="mb-3 form-label">Number of Users</label>
                                        <select name="no_of_users"class="select2 form-control mb-3 custom-select"
                                            style="width: 100%; height:36px;">
                                            <option value="">Select</option>
                                            @for ($i = 1; $i < 13; $i++)
                                                <option value="{{ $i }}">{{ $i }} user</option>
                                            @endfor
                                            <option value="18">18 user</option>
                                            <option value="24">24 user</option>
                                            <option value="36">36 user</option>

                                        </select>
                                        <span class="text-danger">
                                            @error('no_of_users')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="mb-3 form-label">Number of Vacancy Post per Month</label>
                                        <select name="no_of_vacancy" class="select2 form-control mb-3 custom-select"
                                            style="width: 100%; height:36px;">
                                            <option value="null">Select</option>
                                            @for ($i = 1; $i < 51; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor


                                        </select>
                                        <span class="text-danger">
                                            @error('no_of_vacancy')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-md-5 my-1 form-label">Can Client Generate Link to
                                                send?</label>

                                            <div class="col-md-9">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="can_generate_link"
                                                        id="inlineRadio1" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="can_generate_link" id="inlineRadio2" value="0">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <span class="text-danger">
                                                    @error('can_generate_link')
                                                        {{ $message }}
                                                    @enderror
                                                </span>

                                            </div>
                                        </div> <!--end row-->
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-md-5 my-1 form-label">Can Client ask for CIM
                                                Candidate?</label>

                                            <div class="col-md-9">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="can_ask_cim"
                                                        id="inlineRadio1" value="1">
                                                    <label class="form-check-label" for="inlineRadio1">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="can_ask_cim"
                                                        id="inlineRadio2" value="0">
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                                <span class="text-danger">
                                                    @error('can_ask_cim')
                                                        {{ $message }}
                                                    @enderror
                                                </span>

                                            </div>
                                        </div> <!--end row-->
                                    </div>
                                </div>


                            </div> <!-- end col -->
                        </div><!-- end row -->
                        <button class="btn btn-primary text-white" type="submit">Create Subscription Package</button>
                    </div><!-- end card-body -->

                </div> <!-- end card -->
            </div> <!-- end col -->

        </div>

    </form>
@endsection
@section('script')
    
@endsection
