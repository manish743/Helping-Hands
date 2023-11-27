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
    <form action="{{ route('subscription-update') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $subscription->id }}">
        <div class="row p-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Subcription Package Infromation</h4>
                        <p class="text-muted mb-0">Fill The Form below to Update new Subscriptiojn Package
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body bootstrap-select-1">
                        <div class="row">
                            <div class="col-md-8">

                                <div class="form-group">
                                    <label class="form-label">Subscription Package Name</label>
                                    <div>
                                        <input type="text" name="name" class="form-control" parsley-type="text"
                                            value="{{ $subscription->name }}">

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
                                        @if ($subscription->package_type=="Regular Subscription")
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="package_type"
                                                value="Founding Subscription">
                                            <label class="form-check-label" for="inlineRadio1">Founding Subscription</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="package_type"
                                                value="Regular Subscription" checked>
                                            <label class="form-check-label">Regular Subscription</label>
                                        </div>
                                        @else
                                            
                                        
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="package_type"
                                                value="Founding Subscription" checked>
                                            <label class="form-check-label" for="inlineRadio1">Founding Subscription</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="package_type"
                                                value="Regular Subscription" >
                                            <label class="form-check-label">Regular Subscription</label>
                                        </div>
                                        @endif
                                        <span class="text-danger">
                                            @error('package_type')
                                                {{ $message }}
                                            @enderror
                                        </span>

                                    </div>
                                </div> <!--end row-->
                                <div class="form-group">
                                    <label class="mb-3 form-label">Subscription Duration</label>
                                    <select name="subscription_duration" class="select2 form-control mb-3 custom-select"
                                        style="width: 100%; height:36px;">
                                        <option value="{{ $subscription->subscription_duration }}" selected>
                                            {{ $subscription->subscription_duration }}</option>
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


                            </div><!-- end col -->
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label class="mb-3 form-label">Number of Users</label>
                                        <select name="no_of_users"class="select2 form-control mb-3 custom-select"
                                            style="width: 100%; height:36px;">
                                            <option value="{{ $subscription->no_of_users }}" selected>
                                                {{ $subscription->no_of_users }}</option>
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
                                    <div class="form-group col-md-6">
                                        <label class="mb-3 form-label">Number of Vacancy Post per Month</label>
                                        <select name="no_of_vacancy" class="select2 form-control mb-3 custom-select"
                                            style="width: 100%; height:36px;">
                                            <option value="{{ $subscription->no_of_vacancy }}">
                                                {{ $subscription->no_of_vacancy }}</option>
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
                                                    <input class="form-check-input" type="radio"
                                                        name="can_generate_link" value="1"
                                                        {{ $subscription->can_generate_link ? 'checked' : '' }}>
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio"
                                                        name="can_generate_link" value="0"
                                                        {{ $subscription->can_generate_link ? '' : 'checked' }}>
                                                    <label class="form-check-label">No</label>
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
                                                        value="1" {{ $subscription->can_ask_cim ? 'checked' : '' }}>
                                                    <label class="form-check-label">Yes</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="can_ask_cim"
                                                        value="0" {{ $subscription->can_ask_cim ? '' : 'checked' }}>
                                                    <label class="form-check-label">No</label>
                                                </div>
                                                <span class="text-danger">
                                                    @error('can_ask_cim')
                                                        {{ $message }}
                                                    @enderror
                                                </span>

                                            </div>
                                        </div> <!--end row-->
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-md-5 my-1 form-label">Active Status</label>

                                            <div class="col-md-9">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_active"
                                                        value="1" {{ $subscription->is_active ? 'checked' : '' }}>
                                                    <label class="form-check-label">Active</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="is_active"
                                                        value="0" {{ $subscription->is_active ? '' : 'checked' }}>
                                                    <label class="form-check-label">Not Active</label>
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
                        <button class="btn btn-primary text-white" type="submit">Update Subscription Package</button>
                    </div><!-- end card-body -->

                </div> <!-- end card -->
            </div> <!-- end col -->

        </div>

    </form>
@endsection
@section('script')
 
@endsection
