@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('css')
    
    <style>
        #tag-suggestions option:hover {
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
        Skill Category
        @endslot
        @slot('li_3')
            Create
        @endslot
        @slot('title')
        Skill Category
        @endslot
    @endcomponent
    <form action="{{ route('skill_category-store') }}" method="post">
        @csrf
        <div class="row p-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Skill Category</h4>
                        <p class="text-muted mb-0">Fill The Form below to create new Skill Category
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body bootstrap-select-1">
                        <div class="row">
                            <div class="col-md-8">

                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <div>
                                        <input type="text" name="name" class="form-control" parsley-type="text"
                                            placeholder="Enter a  Name">

                                    </div>
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>


                            

                            </div><!-- end col -->

                        </div><!-- end row -->
                        <button class="btn btn-primary text-white" type="submit">Create Skill Category</button>
                    </div><!-- end card-body -->

                </div> <!-- end card -->
            </div> <!-- end col -->

        </div>

    </form>
@endsection
@section('script')
    
   
@endsection
