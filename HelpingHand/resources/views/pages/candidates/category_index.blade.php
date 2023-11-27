@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('css')
@endsection
@section('create_button')
   
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            HIM
        @endslot
        @slot('li_2')
            Candidates
        @endslot
        {{-- @slot('li_3')
            Analytics
        @endslot --}}
        @slot('title')
            Candidates
        @endslot
    @endcomponent
    <div class="modal fade bd-example-modal-lg" id="exampleModalLarge" tabindex="-1" role="dialog"
        aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title m-0" id="myLargeModalLabel">Large Modal</h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div><!--end modal-header-->
                <div class="modal-body">
                    <form action="{{ route('send_registration_link') }}" method="POST">
                        @csrf
                        <fieldset>
                            <div class="repeater-default">
                                <div data-repeater-list="candidate">
                                    <div data-repeater-item="">
                                        <div class="form-group row d-flex align-items-end">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">First Name</label>
                                                        <div>
                                                            <input type="text" name="candidate[0][first_name]"
                                                                class="form-control" parsley-type="text"
                                                                placeholder="Enter First Name">

                                                        </div>
                                                        {{-- <span class="text-danger">
                                                            @error('first_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span> --}}
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">Last Name</label>
                                                        <div>
                                                            <input type="text" name="candidate[0][last_name]"
                                                                class="form-control" parsley-type="text"
                                                                placeholder="Enter Last Name">

                                                        </div>
                                                        {{-- <span class="text-danger">
                                                            @error('last_name')
                                                                {{ $message }}
                                                            @enderror
                                                        </span> --}}
                                                    </div>
                                                </div>
                                                <div class="col-10">
                                                    <div class="form-group">
                                                        <label class="form-label">Email</label>
                                                        <div>
                                                            <input type="email" name="candidate[0][email]"
                                                                class="form-control" parsley-type="text"
                                                                placeholder="Enter Email">

                                                        </div>
                                                        {{-- <span class="text-danger">
                                                            @error('email')
                                                                {{ $message }}
                                                            @enderror
                                                        </span> --}}
                                                    </div>
                                                </div>

                                                <div class="col-sm-1">
                                                    <span data-repeater-delete="" class="btn btn-sm btn-outline-danger">
                                                        <span class="far fa-trash-alt me-1"></span> Delete
                                                    </span>
                                                </div><!--end col-->
                                            </div><!--end row-->
                                        </div><!--end form group-->
                                    </div><!--end /div-->

                                </div><!--end repet-list-->
                                <div class="form-group mb-2 row">
                                    <div class="col-sm-12">
                                        <span data-repeater-create="" class="btn btn-outline-secondary">
                                            <span class="fas fa-plus"></span> Add
                                        </span>

                                    </div><!--end col-->
                                </div><!--end row-->
                            </div> <!--end repeter-->
                        </fieldset>

                        <button class="btn btn-primary text-white" type="submit">Send Links</button>
                    </form>
                </div><!--end modal-body-->

            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div><!--end modal-->
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-2">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Candidate List</h4>
                        </div><!--end col-->
                        <div class="col-auto align-self-center">

                            <a class=" btn btn-sm btn-soft-primary" href="#" role="button"><i
                                    class="fas fa-plus me-2"></i>New Task</a>
                        </div>
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive browser_users">
                        <table id="datatable"class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-top-0">Posted date</th>
                                    <th class="border-top-0">Candidate Name</th>
                                    <th class="border-top-0">Email</th>
                                    <th class="border-top-0">Type Of Job</th>
                                    <th class="border-top-0">CurrentJob</th>
                                    <th class="border-top-0">Tenure In Job</th>
                                    <th class="border-top-0">Action</th>
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                @foreach ($candidate as $item)
                                    @php
                                        $id = base64_encode($item->id);
                                    @endphp
                                    <tr data-id="{{ $id }}">
                                        <td class="border-top-0">{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td class="border-top-0">{{ $item->first_name . ' ' . $item->last_name }}</td>
                                        <td class="border-top-0">{{ $item->email }}</td>
                                        <td class="border-top-0">{{ $item->job_type }}</td>
                                        <td class="border-top-0">
                                            {{ $item->current_job ? $item->current_job->job_title : 'N/A' }}</td>
                                        <td class="border-top-0">
                                            {{ $item->current_job ? $item->current_job->job_tenure : 'N/A' }}</td>
                                        <td> <a href="{{ route('candidates-view', $id) }}"
                                                class="btn btn-sm btn-success text-wgite"><i class="fas fa-eye me-1"></i>
                                                view</a>
                                            {{-- <a class="candidate-delete btn btn-sm btn-danger text-white"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a> --}}
                                        </td>
                                    </tr><!--end tr-->
                                @endforeach



                            </tbody>
                        </table> <!--end table-->
                    </div><!--end /div-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.candidate-delete').click(function(e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var id = row.data('id');
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('candidates-delete') }}",
                        type: "POST",
                        data: {

                            id: id,

                        },
                        dataType: "JSON",

                        // data: row.serialize(),
                        success: function(result) {
                            // debugger
                            console.log(result);
                            if (result.status) {
                                swal.fire(
                                    'Deleted!',
                                    result.message,
                                    'success').then(function() {
                                    row.remove();
                                });
                            } else {
                                swal.fire(
                                    'Faulure!',
                                    result.message,
                                    'warning'
                                );
                            }


                        },
                    }).fail((message) => {
                        console.log(typeof message);
                        message = JSON.parse(message.responseText);
                        for (var key in message.errors) {
                            console.log(key + " - " + message.errors[key]);
                            messages.show(message.errors[key], {
                                title: "Error,",
                            });
                        }
                        swal.fire(
                            'Faulure!',
                            message.message,
                            'warning'
                        );
                    });


                } else if (
                    // Read more about handling dismissals
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swal.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            })
        });
    </script>
@endsection
