@extends('layouts.master')
@section('title')
    Dashboard
@endsection
@section('css')
   
@endsection
@section('create_button')
    <li class="creat-btn">
        <div class="nav-link">
            <a class=" btn btn-sm btn-soft-primary" href="{{ route('subscription-add') }}" role="button"><i
                    class="fas fa-plus me-2"></i>New Subscriptrion Package</a>
        </div>
    </li>
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            HIM
        @endslot
        @slot('li_2')
            Subscription
        @endslot
        {{-- @slot('li_3')
            Analytics
        @endslot --}}
        @slot('title')
            Subscription
        @endslot
    @endcomponent

    <div class="row">
        <div class="col-lg-12">
            <div class="card m-2">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Subscription Package</h4>
                        </div><!--end col-->
                        <div class="col-auto align-self-center">

                            {{-- <a class=" btn btn-sm btn-soft-primary" href="{{ route('subscription-add') }}" role="button"><i
                                    class="fas fa-plus me-2"></i>New Subcription Packages</a> --}}
                        </div>
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive browser_users">
                        <table id="datatable"class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-top-0">Package Name</th>
                                    <th class="border-top-0">Package Type</th>
                                    <th class="border-top-0">Subscription Duration</th>
                                    <th class="border-top-0">Link Generation</th>
                                    <th class="border-top-0">No. Of Vacancies</th>
                                    <th class="border-top-0">No of Users</th>
                                    <th class="border-top-0">Action</th>
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                @foreach ($subscription_list as $item)
                                    <tr data-id="{{ $item->id }}">
                                        {{-- <td><img src="{{ URL::asset('assets/images/browser_logo/chrome.png') }}" alt="" height="16" class="me-2">Chrome</td> --}}
                                        <td>{{ $item->name }}</td>
                                        <td> {{ $item->package_type }}</td>
                                        <td> {{ $item->subscription_duration }}</td>
                                        <td> {{ $item->can_generate_link ? 'Yes' : 'No' }}</td>
                                        <td> {{ $item->no_of_vacancy }}</td>
                                        <td>{{ $item->no_of_users }}</td>
                                        <td>
                                            <a href="{{ route('subscription-edit', $item->id) }}"
                                                class="btn btn-sm btn-primary text-white"><i
                                                    class="fas fa-pencil-alt me-1"></i> Edit</a>
                                            {{-- <button type="button" class="delete_subscription btn btn-danger" data-id="{{ $item->id }}" data-bs-toggle="modal"
                                                data-bs-target="#exampleModalDanger">Delete</button> --}}
                                            <a class="delete_subscription btn btn-sm btn-danger text-white"
                                                ><i
                                                    class="far fa-trash-alt me-1"></i>Delete</a>
                                        </td>
                                    </tr><!--end tr-->
                                @endforeach
                                {{-- <div class="btn btn-primary" id="myForm">myForm</div> --}}

                                <div class="modal fade" id="exampleModalDanger" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalDanger1" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <form  id="myForm"  action="{{ route('subscription-delete') }}" method="post">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <h6 class="modal-title m-0 text-white" id="exampleModalDanger1">This
                                                        Package
                                                        May be Subscribed by Clients</h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div><!--end modal-header-->
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-lg-3 text-center align-self-center">
                                                            <img src="{{ URL::asset('assets/images/widgets/btc.png') }}"
                                                                alt="" class="img-fluid">
                                                        </div><!--end col-->
                                                        <div class="col-lg-9">
                                                            <h5>Please Select new Subscriptions Packages for Existing
                                                                Customers
                                                                First</h5>
                                                            <span class="badge bg-soft-secondary">Once Deleted You Won't Be
                                                                able
                                                                to recover the Data</span>


                                                            @csrf
                                                            <input type="hidden" id="old_id" name="id"
                                                                value="">
                                                            <select name="new_subscription_id" id="tag-suggestions"
                                                                class="select2 form-control mb-3 custom-select"
                                                                style="width: 100%; height:36px;">
                                                                <option value="">Select</option>



                                                            </select>

                                                        </div><!--end col-->
                                                    </div><!--end row-->
                                                </div><!--end modal-body-->
                                                <div class="modal-footer">
                                                    <button type="submit"  id="sub_delete"
                                                        class="btn btn-soft-secondary btn-sm">Delete</button>
                                                    <button type="button" class="btn btn-soft-danger btn-sm"
                                                        data-bs-dismiss="modal">Cancel</button>
                                                </div><!--end modal-footer-->
                                            </div><!--end modal-content-->
                                        </form>
                                    </div><!--end modal-dialog-->
                                </div><!--end modal-->


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
    <script src="{{ URL::asset('assets/js/pages/jquery.analytics_dashboard.init.js') }}"></script> --}}
    <script src="{{ URL::asset('assets/js/app.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Reference to the input field and tag suggestions element
            var org_type = $(".delete_subscription");
          

            $('.delete_subscription').on('click', function(e) {
                e.preventDefault();
                var row = $(this).closest('tr');
                var id = row.data('id');
                debugger
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
                        url: "{{ route('subscription-delete') }}",
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

        });
    </script>
@endsection
