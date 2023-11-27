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
            User
        @endslot
        @slot('li_3')
            Create
        @endslot
        @slot('title')
            User
        @endslot
    @endcomponent
    <form action="{{ route('sub_user_store') }}" id="myForm" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="row p-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">User Information</h4>
                        <p class="text-muted mb-0">Fill The Form below to create new User
                        </p>
                    </div><!--end card-header-->
                    <div class="card-body bootstrap-select-1">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">First Name</label>
                                           
                                                <input required type="text" name="first_name" class="form-control"
                                                    parsley-type="text" placeholder="Enter a Subscription Package Name">

                                            
                                            <span class="text-danger">
                                                @error('first_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Last Name</label>
                                            
                                                <input required type="text" name="last_name" class="form-control"
                                                    parsley-type="text" placeholder="Enter a Subscription Package Name">

                                            
                                            <span class="text-danger">
                                                @error('last_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Email Address</label>
                                    
                                        <input required type="email" name="email" class="form-control"
                                            parsley-type="text" placeholder="Enter a Subscription Package Name">

                                    
                                    <span class="text-danger">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Password</label>
                                          
                                                <input required type="password" name="password" class="form-control"
                                                    parsley-type="password" placeholder="password">

                                            
                                            <span class="text-danger">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">Confirm Password</label>
                                          
                                                <input required type="password" name="password_confirmation"
                                                    class="form-control" parsley-type="password"
                                                    placeholder="confirm password">

                                          
                                            <span class="text-danger">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label">Contact</label>
                                    
                                        <input required type="text" name="contact" class="form-control"
                                            parsley-type="text" placeholder="923 *** ****">

                                    
                                    <span class="text-danger">
                                        @error('contact')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3  form-label">Stages</label>
                                  

                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="stage[]" value="1">
                                            <label class="form-check-label" for="inlineCheckbox1">Stage 1</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="stage[]" value="2">
                                            <label class="form-check-label" for="inlineCheckbox2">Stage 2</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="stage[]" value="3">
                                            <label class="form-check-label" for="inlineCheckbox3">Stage 3</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="stage[]" value="4">
                                            <label class="form-check-label" for="inlineCheckbox4">Stage 4</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" name="stage[]" value="5">
                                            <label class="form-check-label" for="inlineCheckbox5">Stage 5</label>
                                        </div>
                                   
                                    <span class="text-danger">
                                        @error('stage')
                                            {{ $message }}
                                        @enderror
                                    </span>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="HR" value="1">
                                        <label class="form-check-label" for="inlineCheckbox5">HR Manager</label>
                                    </div>
                                </div><!--end row-->



                            </div><!-- end col -->
                            {{-- <div class="col">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">File Upload 3</h4>
                                        <p class="text-muted mb-0">You can set the height</p>
                                    </div><!--end card-header-->
                                    <div class="card-body">
                                        <input type="file" id="input-file-now-custom-2" name="image"
                                            class="dropify" data-height="500" />
                                    </div><!--end card-body-->
                                </div><!--end card-->
                            </div><!--end col--> --}}
                        </div><!-- end row -->

                        <button class="btn btn-primary text-white" type="submit">Create User</button>
                    </div><!-- end card-body -->

                </div> <!-- end card -->
            </div> <!-- end col -->

        </div>

    </form>
@endsection
@section('script')
    <script>
        $("#myForm").submit(function(event) {

            event.preventDefault(); // Prevent the default form submission
            let isValid = true;
            var toastContainer = $('#warning-toast').find('.toast-container');
            toastContainer.empty();
            var isFirstIteration = true;
            $(this).find('[required]').each(function() {


                if ($(this).val() === '') {
                    isValid = false; // If a required field is empty, set isValid to false
                    $(this).addClass('error'); // Optionally, add a CSS class for styling
                    // $(this).siblings('label').addClass('error'); // Optionally, add a CSS class for styling
                    $(this).siblings('.error-message').remove();
                    var name = $(this).siblings('label').text().trim(); // Get label text
                    if (!name) {
                        name = $(this).attr('name'); // If label text is empty, get the name attribute
                    }
                    $(this).before(' <span class="error-message error">*' + name + ' is required</span>');
                    var toast = $('#toast-content').first().clone();
                    toast.find('h5').text(
                        `${name} is required`, );
                    toast.removeClass('d-none');
                    toast.toast({
                        autohide: true
                    });
                    var toastContainer = $('#warning-toast').find('.toast-container');
                    toastContainer.children('.toast').hide();
                    toastContainer.append(toast);
                    toastContainer.children('.toast').removeClass('d-none');
                    toastContainer.children('.toast').show({
                        autohide: true
                    });
                    $(this).css('border', '1px solid red').focus();

                }else{
                    $(this).removeClass('error'); // Optionally, add a CSS class for styling
                    $(this).siblings('label').removeClass('error');
                    $(this).siblings('.error-message').remove();
                    $(this).css('border', '').focus();
                }


            });

            // Call the validation function when the form is submitted
            if (isValid) {

                $('#myForm').unbind('submit').submit();
            } else {
                return false
            }
        });
    </script>
@endsection
