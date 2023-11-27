@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('css')
@endsection
@section('create_button')
    <li class="creat-btn">
        <div class="nav-link">
            <a class=" btn btn-sm btn-soft-primary" href="{{ route('jobs-add') }}" role="button"><i
                    class="fas fa-plus me-2"></i>New Jobs</a>
        </div>
    </li>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            HIM
        @endslot
        @slot('li_2')
            Dashboard
        @endslot
        {{-- @slot('li_3')
            Analytics
        @endslot --}}
        @slot('title')
            Dashboard
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card m-2">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">OnGoing Jobs</h4>
                        </div><!--end col-->
                        <div class="col-auto align-self-center">

                            {{-- <a class=" btn btn-sm btn-soft-primary" href="#" role="button"><i class="fas fa-plus me-2"></i>New Task</a> --}}
                        </div>
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive browser_users">
                        <table id="datatable"class="table mb-0">
                            <thead class="table-light">

                                <tr>
                                    <th class="border-top-0">Posted date</th>
                                    @if ($auth_user->hasRole('SuperAdmin'))
                                        <th class="border-top-0">Company</th>
                                    @endif

                                    <th class="border-top-0">Vacant Position</th>
                                    <th class="border-top-0">Type Of Job</th>
                                    <th class="border-top-0">Need CIM Candidate</th>
                                    @if ($auth_user->hasRole('ClientAdmin'))
                                        <th class="border-top-0">Applicant</th>
                                    @endif
                                    <th class="border-top-0">Stages</th>
                                    <th class="border-top-0">Status</th>
                                    <th class="border-top-0">Action</th>
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                @foreach ($job_list as $item)
                                    <tr data-id="{{ $item->id }}">
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        @if ($auth_user->hasRole('SuperAdmin'))
                                            <td> {{ $item->client->org_name }}</td>
                                        @endif
                                        <td> {{ $item->vacant_position }}</td>
                                        <td> {{ isset($item->job_type) ? $item->job_type : 'N/A' }}</td>
                                        <td> {{ $item->cim_candidate ? 'Yes' : 'No' }}</td>
                                        @if ($auth_user->hasRole('ClientAdmin'))
                                            <td class="border-top-0">
                                                <a href="{{ route('jobs-applicants', base64_encode($item->id)) }}">
                                                    {{ count($item->candidates) > 0 ? count($item->candidates) : 'N/A' }}
                                                </a>
                                            </td>
                                        @endif
                                        <td>
                                            {{ implode(', ', json_decode($item->stages)) }}</td>
                                        <td> <span
                                                class="badge badge-soft-{{ $item->status ? 'warning' : 'primary' }}">{{ $item->status ? 'Open' : 'Completed' }}</span>
                                        </td>
                                        <td>

                                            {{-- <a href="{{ route('jobs-edit', $item->id) }}"
                                        class="btn btn-sm btn-primary text-wgite"><i
                                            class="fas fa-pencil-alt me-1"></i> Edit</a>
                                    <a class="jobs-delete btn btn-sm btn-danger text-white"><i
                                            class="far fa-trash-alt me-1"></i>Delete</a>
                                            @if ($item->status)
                                            <a class="jobs-complete btn btn-sm btn-success text-white"><i
                                                class="fas fa-check me-1"></i>Complete</a>
                                            @endif --}}
                                            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user"
                                                data-bs-toggle="dropdown" href="#" role="button"
                                                aria-haspopup="false" aria-expanded="false">
                                                <span class="ms-1 nav-user-name hidden-sm">
                                                    Action</span>
                                                <i data-feather="more-vertical"
                                                    class="align-self-center icon-xs icon-dual me-1"data-toggle="tooltip"
                                                    title="Action"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item"
                                                    href="{{ route('jobs-edit', base64_encode($item->id)) }}"><i
                                                        data-feather="edit-2"
                                                        class="align-self-center icon-xs icon-dual me-1"></i> Edit</a>
                                                @if ($auth_user->hasRole('ClientAdmin'))
                                                    <a class="dropdown-item"
                                                        href="{{ route('jobs-applicants', base64_encode($item->id)) }}"><i
                                                            data-feather="users"
                                                            class="align-self-center icon-xs icon-dual me-1"></i>
                                                        Applicants</a>
                                                @endif
                                                <a class="dropdown-item jobs-delete" href="#"><i
                                                        data-feather="trash-2"
                                                        class="align-self-center icon-xs icon-dual me-1"></i> Delete</a>
                                                <div class="dropdown-divider mb-0"></div>
                                                @if ($item->status)
                                                    <a class="dropdown-item jobs-complete" href="javascript:void();"><i
                                                            data-feather="check"
                                                            class="align-self-center icon-xs icon-dual me-1"></i> <span
                                                            key="t-logout">Complete</span></a>
                                                @endif


                                            </div>
                                            {{-- <div class="dropdown">
                                                <a class="btn btn-sm btn-primary m-2 text-white nav-link dropdown-toggle waves-effect waves-light nav-user" data-bs-toggle="dropdown"
                                                    href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                   option
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="{{ route('jobs-edit', $item->id) }}"><i
                                                        class="fas fa-pencil-alt me-1"></i> Edit</a>
                                                   
                                                    <div class="dropdown-divider mb-0"></div>
                                                    <a class="dropdown-item jobs-delete"><i
                                                        class="far fa-trash-alt me-1"></i> <span
                                                            key="t-logout">Delete</span></a>
                                                    <a class="dropdown-item jobs-complete"><i
                                                                class="fas fa-check me-1"></i>Complete</a>
                                                           
                                                    
                                                </div>
                                            </div> --}}

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
        $('.jobs-delete').click(function(e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var id = row.data('id');
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",

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
                        url: "{{ route('jobs-delete') }}",
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
        $('.jobs-complete').click(function(e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var btn = $(this).closest('a');
            var id = row.data('id');
            swal.fire({
                title: 'Are you sure?',
                text: "You want to cmplete this job!",

                showCancelButton: true,
                confirmButtonText: 'Yes, Complete it!',
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
                        url: "{{ route('jobs-complete') }}",
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
                                    'Success!',
                                    result.Message,
                                    'success').then(function() {
                                    btn.remove();
                                });
                            } else {
                                swal.fire(
                                    'Faulure!',
                                    result.Message,
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
                        'Job is still Open :)',
                        'error'
                    )
                }
            })
        });
    </script>
@endsection
