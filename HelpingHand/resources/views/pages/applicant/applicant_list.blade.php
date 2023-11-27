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
  
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-2">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Applicant List</h4>
                        </div><!--end col-->
                        
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive browser_users">
                        <table id="datatable"class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-top-0">Applied date</th>
                                    <th class="border-top-0">Candidate Name</th>
                                    <th class="border-top-0">Email</th>
                                    <th class="border-top-0">Type Of Job</th>
                                    <th class="border-top-0">CurrentJob</th>
                                    <th class="border-top-0">Tenure In Job</th>
                                    <th class="border-top-0">Action</th>
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                @foreach ($applicants as $item)
                                    @php
                                        $id = base64_encode($item->id);
                                    @endphp
                                    <tr data-id="{{ $id }}">
                                        <td class="border-top-0">{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td class="border-top-0">{{ $item->candidate->first_name . ' ' . $item->candidate->last_name }}</td>
                                        <td class="border-top-0">{{ $item->candidate->email }}</td>
                                        <td class="border-top-0">{{ $item->candidate->job_type }}</td>
                                        <td class="border-top-0">
                                            {{ $item->candidate->current_job ? $item->candidate->current_job->candidate->job_title : 'N/A' }}</td>
                                        <td class="border-top-0">
                                            {{ $item->candidate->current_job ? $item->candidate->current_job->candidate->job_tenure : 'N/A' }}</td>
                                        <td> <a href="{{ route('applicant-view', $id) }}"
                                                class="btn btn-sm btn-success text-wgite"><i class="fas fa-eye me-1"></i>
                                                view</a>
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
  
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-2">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Proceeding Applicants</h4>
                        </div><!--end col-->
                        
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive browser_users">
                        <table id=""class="datatable_class table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-top-0">Applied date</th>
                                    <th class="border-top-0">Candidate Name</th>
                                    <th class="border-top-0">Email</th>
                                    <th class="border-top-0">Type Of Job</th>
                                    <th class="border-top-0">CurrentJob</th>
                                    <th class="border-top-0">Tenure In Job</th>
                                    <th class="border-top-0">Stage</th>
                                   
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                @foreach ($proceeding_applicants as $item)
                                    @php
                                        $id = base64_encode($item->id);
                                    @endphp
                                    <tr data-id="{{ $id }}">
                                        <td class="border-top-0">{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td class="border-top-0">{{ $item->candidate->first_name . ' ' . $item->candidate->last_name }}</td>
                                        <td class="border-top-0">{{ $item->candidate->email }}</td>
                                        <td class="border-top-0">{{ $item->candidate->job_type }}</td>
                                        <td class="border-top-0">
                                            {{ $item->candidate->current_job ? $item->candidate->current_job->candidate->job_title : 'N/A' }}</td>
                                        <td class="border-top-0">
                                            {{ $item->candidate->current_job ? $item->candidate->current_job->candidate->job_tenure : 'N/A' }}</td>
                                            <td> 
                                                {{  $item->stage_id }}</td>
                                    </tr><!--end tr-->
                                @endforeach



                            </tbody>
                        </table> <!--end table-->
                    </div><!--end /div-->
                </div><!--end card-body-->
            </div><!--end card-->
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-2">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="card-title">Rejected Applicants</h4>
                        </div><!--end col-->
                        
                    </div> <!--end row-->
                </div><!--end card-header-->
                <div class="card-body">
                    <div class="table-responsive browser_users">
                        <table id=""class="datatable_class table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-top-0">Applied date</th>
                                    <th class="border-top-0">Candidate Name</th>
                                    <th class="border-top-0">Email</th>
                                    <th class="border-top-0">Type Of Job</th>
                                    <th class="border-top-0">CurrentJob</th>
                                    <th class="border-top-0">Reason</th>
                                    <th class="border-top-0">Stage</th>
                                   
                                </tr><!--end tr-->
                            </thead>
                            <tbody>
                                @foreach ($rejected_applicants as $item)
                                    @php
                                        $id = base64_encode($item->id);
                                    @endphp
                                    <tr data-id="{{ $id }}">
                                        <td class="border-top-0">{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td class="border-top-0">{{ $item->candidate->first_name . ' ' . $item->candidate->last_name }}</td>
                                        <td class="border-top-0">{{ $item->candidate->email }}</td>
                                        <td class="border-top-0">{{ $item->candidate->job_type }}</td>
                                        <td class="border-top-0">
                                            {{ $item->candidate->current_job ? $item->candidate->current_job->candidate->job_title : 'N/A' }}</td>
                                        <td class="border-top-0">
                                            {{ $item->reason}}</td>
                                            <td> 
                                                {{  $item->stage_id }}</td>
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
   
@endsection
