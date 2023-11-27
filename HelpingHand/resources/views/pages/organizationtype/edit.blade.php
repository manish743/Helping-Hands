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
            Organization Type
        @endslot
        @slot('li_3')
            Edit
        @endslot
        @slot('title')
            Organization Type
        @endslot
    @endcomponent
    <form action="{{ route('organizationtype-update') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $organization_type->id }}">
        <div class="row p-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Organization Type</h4>
                        <p class="text-muted mb-0">Fill The Form below to Update new Client
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body bootstrap-select-1">
                        <div class="row">
                            <div class="col-md-8">

                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <div>
                                        <input type="text" name="name" class="form-control" parsley-type="text"
                                           value="{{ $organization_type->org_type }}">

                                    </div>
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                
                               
                                <div class="form-group">
                                    <label class="form-label">Specialization</label>
                                    <div>
                                        @if (count( $organization_type->specialization)> 0)
                                        <input type="text" name="specialization" class="form-control"
                                        parsley-type="text" id="tagInput" value="{{ $organization_type->specialization->pluck('name')->implode(', ') }}">
                                        @else
                                        <input type="text" name="specialization" class="form-control"
                                        parsley-type="text" id="tagInput" placeholder="enter specialization">
                                            @endif
                                            <div id="tag-suggestions"></div>

                                    </div>
                                    <span class="text-danger">
                                        @error('specialization')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                               
                            </div><!-- end col -->

                        </div><!-- end row -->
                        <button class="btn btn-primary text-white" type="submit">Update Organization Type</button>
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
            var $tagsInput = $("#tagInput");
            // var $tagsInput = $(".select2-search__field");

            var $tagSuggestions = $("#tag-suggestions");
            // var $tagSuggestions = $(".select2-results__options");

            // Event handler for key input
            $tagsInput.on("input", read_input)

            function read_input() {
                // Get the user's input
                var allInput = $tagsInput.val();
                var userInput = $tagsInput.val();
                var commaIndex = userInput.lastIndexOf(",");
                var lastInput = "";

                if (commaIndex !== -1) {
                    // If there's a comma, only consider text after the last comma
                    userInput = userInput.substring(commaIndex + 1).trim();
                    lastInput = userInput.substring(0, commaIndex).trim();

                }

                // Make an AJAX request to fetch tag suggestions
                $.ajax({
                    method: "GET",
                    url: "{{ route('organizationtype-specialization_suggest') }}", // Replace with your Laravel API endpoint
                    data: {
                        input: userInput
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
                        } else {
                            $tagSuggestions.append("<option value=" + userInput + ">" +
                                userInput + "</option>");
                        }

                        $option = $("#tag-suggestions").find('option');
                        $option.on('click', selectoption);

                        function selectoption() {
                            allInput = $("#tagInput").val()
                            var selectedOption = $(this).text();
                            lastInput = allInput.substring(0, commaIndex).trim();
                            debugger
                            if (lastInput !== "") {
                                $("#tagInput").val(lastInput + ", " + selectedOption + ", ");
                            } else {
                                $("#tagInput").val(selectedOption + ", ");
                            }

                            $tagSuggestions.empty();

                        }

                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            };


        });
    </script>
@endsection
