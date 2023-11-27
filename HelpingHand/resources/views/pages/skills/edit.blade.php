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
            Skills
        @endslot
        @slot('li_3')
            Update
        @endslot
        @slot('title')
            Skills
        @endslot
    @endcomponent
    <form action="{{ route('skills-update') }}" method="post">
        @csrf
        <input type="hidden" name="id" value="{{ $skill->id }}">
        <div class="row p-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Skills</h4>
                        <p class="text-muted mb-0">Fill The Form below to Update new Skills
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body bootstrap-select-1">
                        <div class="row">
                            <div class="col-md-8">

                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <div>
                                        <input type="text" name="name" class="form-control" parsley-type="text"
                                            value="{{ old('name') ? old('name') : $skill->name }}">

                                    </div>
                                    <span class="text-danger">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="form-group">
                                    <label class="mb-3 form-label">Skills Category</label>
                                    <input type="text" name="skill_category" id="tagInput" class="form-control"
                                        parsley-type="text"
                                        value="{{ $skill->skill_category->pluck('name')->implode(', ') }}">
                                    <div id="tag-suggestions"></div>
                                    <span class="text-danger">
                                        @error('org_type')
                                            {{ $message }}
                                        @enderror
                                    </span>

                                </div>
                                <div class="row mb-3">
                                    <label class="col-md-3 my-1 form-label">Competencies</label>
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="competency" checked
                                                id="inlineRadio1" value="Hard Skill">
                                            <label class="form-check-label" for="inlineRadio1">Hard Skill</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="competency"
                                                id="inlineRadio2" value="Soft Skill">
                                            <label class="form-check-label" for="inlineRadio2">Soft Skill</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="competency"
                                                id="inlineRadio3" value="Team Fit">
                                            <label class="form-check-label" for="inlineRadio3">Team Fit</label>
                                        </div>
                                        <span class="text-danger">
                                            @error('competency')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                    </div>
                                </div>




                            </div><!-- end col -->

                        </div><!-- end row -->
                        <button class="btn btn-primary text-white" type="submit">Update Skills</button>
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
            var competenceValue = "{{ $skill->competency }}"; // Replace with $skill->competence

            // Check the radio option based on the value
            $('input[name="competency"]').filter('[value="' + competenceValue + '"]').prop('checked', true);

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
                    userInput = allInput.substring(commaIndex + 1).trim();
                    lastInput = allInput.substring(0, commaIndex).trim();

                }

                // Make an AJAX request to fetch tag suggestions
                $.ajax({
                    method: "GET",
                    url: "{{ route('skill-category_suggest') }}", // Replace with your Laravel API endpoint
                    data: {
                        input: userInput
                    },
                    success: function(suggestions) {
                        // Clear existing suggestions
                        $tagSuggestions.empty();
                        // debugger
                        // Append new suggestions to the list
                        if (suggestions.status) {

                            suggestions.result.forEach(function(suggestion) {
                                console.log(suggestion.name);
                                $tagSuggestions.append("<option value=" + suggestion
                                    .name + ">" + suggestion.name + "</option>");

                            });
                        } else {
                            console.log(suggestions.result);
                            $tagSuggestions.append("<option value=" + suggestions.result + ">" +
                                suggestions.result + "</option>");
                        }

                        $option = $("#tag-suggestions").find('option');
                        $option.on('click', selectoption);

                        function selectoption() {
                            allInput = $("#tagInput").val()
                            var selectedOption = $(this).text();
                            console.log(selectedOption);
                            lastInput = allInput.substring(0, commaIndex).trim();
                            // debugger
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
