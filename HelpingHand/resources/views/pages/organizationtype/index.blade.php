@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('css')

@endsection
@section('create_button')
<li class="creat-btn">
    <div class="nav-link">
        <a class=" btn btn-sm btn-soft-primary" href="{{ route('organizationtype-add') }}" role="button"><i
                class="fas fa-plus me-2"></i>New Organization Type</a>
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
            Organization Type
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
                            <h4 class="card-title">Organization Type</h4>
                        </div><!--end col-->
                        <div class="col-auto align-self-center">

                            {{-- <a class=" btn btn-sm btn-soft-primary" href="{{ route('organizationtype-add') }}"
                                role="button"><i class="fas fa-plus me-2"></i>New Organization Type</a> --}}
                        </div>
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="">
                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-top-0">Organization Type</th>
                                    <th class="border-top-0">Specialization</th>
                                    <th class="border-top-0">Action</th>
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                @foreach ($organization_type as $item)
                                    <tr data-id="{{ $item->id }}">

                                        <td>{{ $item->org_type }}</td>
                                        <td>
                                            @if (count( $item->specialization)> 0)
                                                @foreach ($item->specialization as $specialization)
                                                    {{ $specialization->name }}
                                                    {{ $loop->last? "":"," }}
                                                @endforeach
                                            @else
                                                N/A
                                            @endif
                                         
                                        </td>
                                        <td> <a href="{{ route('organizationtype-edit', $item->id) }}" class="btn btn-sm btn-primary text-white"><i
                                                    class="fas fa-pencil-alt"></i> </a>
                                                    <a class="organizationtype-delete btn btn-sm btn-danger text-white"><i class="far fa-trash-alt me-1"></i>Delete</a>
                                            {{-- <i class="far fa-trash-alt"></i> --}}
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
{{-- <script src="{{ URL::asset('assets/plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/buttons.colVis.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/jquery.datatable.init.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/apex-charts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/jvectormap/jquery-jvectormap-us-aea-en.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/jquery.analytics_dashboard.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/app.js') }}"></script> --}}
    <script>
        $('.organizationtype-delete').click(function(e) {
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
                        url: "{{ route('organizationtype-delete') }}",
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
