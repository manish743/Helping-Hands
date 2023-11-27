@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('css')
    
@endsection
@section('create_button')
    <li class="creat-btn">
        <div class="nav-link">
            <a class=" btn btn-sm btn-soft-primary" href="{{ route('sub_user_add') }}" role="button"><i
                    class="fas fa-plus me-2"></i> Add Stage Interviewer</a>
        </div>
    </li>
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            HIM
        @endslot
        @slot('li_2')
            Client Management
        @endslot
        @slot('li_3')
            Show All Clients
        @endslot
        @slot('title')
            Client Management
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card m-2">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">List Of Clients</h4>
                        </div><!--end col-->
                        <div class="col-auto align-self-center">

                            {{-- <a class=" btn btn-sm btn-soft-primary" href="{{ route('client-add') }}" role="button"><i
                                    class="fas fa-plus me-2"></i>New Client</a> --}}
                        </div>
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-top-0">Created Date</th>
                                    <th class="border-top-0">Full Name</th>
                                    <th class="border-top-0">Email Address</th>
                                    <th class="border-top-0">Last Time Active</th>
                                    <th class="border-top-0">Stages</th>
                                    <th class="border-top-0">Action</th>
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                @foreach ($user_list as $item)
                                    <tr data-id="{{ $item->id }}">
                                        <td>
                                            

                                            {{ $item->created_at->format('d-m-Y') }}
                                        </td>
                                        <td> {{ $item->first_name . $item->last_name }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->last_used_at}}</td>

                                        
                                        <td>
                                            {{ implode(', ', $item->permissions->pluck('name')->toArray()) }}                                     
                                            {{-- {{ implode(', ', $item->roles->first()->permissions->pluck('name')->toArray()) }}                                      --}}
                                        
                                        </td>
                                        <td>
                                            <form id="deleteform" action="{{ route('client-delete') }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                            </form> <a href="{{ route('sub_user_edit', base64_encode($item->id)) }}"
                                                class="btn btn-sm btn-primary text-white"><i
                                                    class="fas fa-pencil-alt me-1"></i> Edit</a>
                                            <a class="client-delete btn btn-sm btn-danger text-white"><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>

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
        $('.sub_user_delete').click(function(e) {
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
                        url: "{{ route('sub_user_delete') }}",
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
