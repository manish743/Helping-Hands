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
            Deparment
        @endslot
        @slot('li_3')
            Create
        @endslot
        @slot('title')
            Deparment
        @endslot
    @endcomponent
    <form action="{{ route('department-store') }}" id="myForm" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row p-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Deparment Information</h4>
                        <p class="text-muted mb-0">Fill The Form below to create new Deparment
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body bootstrap-select-1">
                        <div class="row">
                            <div class="col-md-8">

                                <div class="form-group">
                                    <label class="form-label">Deparment Name</label>
                                    <div>
                                        <input type="text" name="name" class="form-control" parsley-type="text"
                                            placeholder="Name">

                                    </div>
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                               
                              
                                
                            </div><!-- end col -->
                           
                        </div><!-- end row -->

                        <button class="btn btn-primary text-white" type="submit">Create Department</button>
                    </div><!-- end card-body -->

                </div> <!-- end card -->
            </div> <!-- end col -->

        </div>

    </form>
@endsection
@section('script')
    
    <script>
        $(document).ready(function() {
            // Reference to the input field and tag suggestions element
            var org_type = $("#org_type");
            // var $tagsInput = $(".select2-search__field");

            var $tagSuggestions = $("#tag-suggestions");
            // var $tagSuggestions = $(".select2-results__options");

            // Event handler for key input
            org_type.on("change", read_input)

            function read_input() {
                // Get the user's input
                var id = $(this).val();

                // Make an AJAX request to fetch tag suggestions
                $.ajax({
                    method: "GET",
                    url: "{{ route('get_organizationtype_specialization') }}", // Replace with your Laravel API endpoint
                    data: {
                        id: id
                    },
                    success: function(suggestions) {
                        // Clear existing suggestions
                        $tagSuggestions.empty();
                        // debugger
                        // Append new suggestions to the list
                        if (suggestions.length > 0) {

                            suggestions.forEach(function(suggestion) {
                                console.log(suggestion.name);
                                $tagSuggestions.append("<option value=" + suggestion
                                    .name + ">" + suggestion.name + "</option>");

                            });
                        }



                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            };

            $('#myForm').on('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting normally

                // Get the selected items as an array of strings
                var titlesArray = []; // Initialize an empty array to store titles

                // Select all elements with class 'select2-selection__choice' and read their 'title' attribute
                $('.select2-selection__choice').each(function() {
                    var title = $(this).attr('title'); // Get the 'title' attribute
                    if (title) {
                        titlesArray.push(title); // Add the title to the array
                    }
                });

                // Merge the titles into a comma-separated string
                var mergedTitles = titlesArray.join(', ');

                // Create an input element to hold the array of strings
                var input = $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'skills')
                    .val(titlesArray);

                // Append the input element to the form
                $(this).append(input);

                // Now, you can submit the form
                this.submit();
            });

        });
    </script>
@endsection
