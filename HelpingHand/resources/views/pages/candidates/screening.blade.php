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
            Interview
        @endslot
        {{-- @slot('li_3')
            Analytics
        @endslot --}}
        @slot('title')
            Interview
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card m-2">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Interview List</h4>
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
                                    <th class="border-top-0">Interview date</th>
                                    <th class="border-top-0">Interview time</th>
                                    <th class="border-top-0">Candidate Name</th>
                                    <th class="border-top-0">Email</th>
                                    @if ($auth_user->hasRole('StageUser'))
                                        <th class="border-top-0">Job</th>
                                        <th class="border-top-0">Stage</th>
                                    @endif


                                    <th class="border-top-0">Action</th>
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                @foreach ($interview_dates as $item)
                                    @php

                                        $date_id = base64_encode($item->id);
                                    @endphp
                                    <tr data-id="{{ $date_id }}">
                                        <td class="border-top-0">
                                            {{ \carbon\Carbon::parse($item->interview_date)->format('d-m-Y') }}</td>
                                        <td class="border-top-0">
                                            {{ \carbon\Carbon::parse($item->interview_time)->format('H:i:s') }}</td>

                                        <td class="border-top-0">
                                            {{ $item->candidate->first_name . ' ' . $item->candidate->last_name }}</td>
                                        <td class="border-top-0">{{ $item->candidate->email }}</td>
                                        @if ($auth_user->hasRole('StageUser'))
                                            @if ($item->job)
                                                <td class="border-top-0">{{ $item->job->vacant_position }}</td>
                                            @else
                                                <td class="border-top-0">N/A</td>
                                            @endif

                                            <td class="border-top-0">{{ $item->stage_id }}</td>
                                        @endif
                                        <td>
                                            @if ($item->job_applicant)
                                                @php
                                                    $id = base64_encode($item->job_applicant->id);
                                                @endphp

                                                <a href="{{ route('applicant-stage_view', $id) }}"
                                                    class="btn btn-sm btn-success text-wgite"><i
                                                        class="fas fa-eye me-1"></i>
                                                    view</a>
                                            @else
                                                @php
                                                    $id = base64_encode($item->candidate->id);
                                                @endphp
                                                <a href="{{ route('candidates-view', $id) }}"
                                                    class="btn btn-sm btn-success text-wgite"><i
                                                        class="fas fa-eye me-1"></i>
                                                    view</a>
                                            @endif

                                            <a class="interview-cancel btn btn-sm btn-danger text-white"><i
                                                    class="far fa-trash-alt me-1"></i>Cancel</a>
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
        $('.interview-cancel').click(function(e) {
            e.preventDefault();
            var row = $(this).closest('tr');
            var id = row.data('id');
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Cancel Interviw!',
                cancelButtonText: 'No, revert action!',
                reverseButtons: true
            }).then(function(result) {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: "{{ route('cancel_interview') }}",
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
                                    'Cancelled!',
                                    result.Message,
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
