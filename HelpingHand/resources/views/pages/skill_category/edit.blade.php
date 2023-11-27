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
@section('create_button')
    <li class="creat-btn">
        <div class="nav-link">
            <a class=" btn btn-sm btn-soft-primary" href="{{ route('skill_category-add') }}" role="button"><i
                    class="fas fa-plus me-2"></i>New Skill Category</a>
        </div>
    </li>
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
            Edit
        @endslot
        @slot('title')
            Skill Category
        @endslot
    @endcomponent
    <form action="{{ route('skill_category-update') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $skill_category->id }}">
        <div class="row p-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Skill Category</h4>
                        <p class="text-muted mb-0">Fill The Form below to Edit Skill Category
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body bootstrap-select-1">
                        <div class="row">
                            <div class="col-md-8">

                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <div>
                                        <input type="text" name="name" class="form-control" parsley-type="text"
                                            value="{{ $skill_category->name }}">

                                    </div>
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>




                            </div><!-- end col -->

                        </div><!-- end row -->
                        <button class="btn btn-primary text-white" type="submit">Update Skill Category</button>
                    </div><!-- end card-body -->

                </div> <!-- end card -->
            </div> <!-- end col -->

        </div>

    </form>
@endsection
@section('script')
   
@endsection
