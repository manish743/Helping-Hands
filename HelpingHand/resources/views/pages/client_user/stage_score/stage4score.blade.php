<div class="row p-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">Scoring/ Practical Evaluation</h4>
                    </div><!--end col-->
                    <div class="col-auto align-self-center">
                        @if ($applicant->case_study)
                            <a href="{{ asset($applicant->case_study->case_study_material) }}" target="blank">
                                <div class="btn btn-soft-primary">View Case Study material</div>
                            </a>
                            @if ($applicant->case_study->case_study)
                                <a href="{{ asset($applicant->case_study->case_study) }}" target="blank">
                                    <div class="btn btn-soft-primary">View Case Study</div>
                                </a>
                            @else
                                <div class="btn btn-soft-warning">Case Study Not received</div>
                            @endif

                        @endif
                    </div>
                </div>
            </div><!--end card-header-->
            <div class="card-body bootstrap-select-1">
                @if ($applicant->panels && isset($applicant->panel_interview_option[0]))                   

                    <div class="row">
                        <h4 class="card-title text-success mb-1">Panlels Scheduled: {{ $applicant->panel_interview_option[0]->interview_date.' at '.$applicant->panel_interview_option[0]->interview_time}}</h4>
                        @foreach ($applicant->panels as $item)
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="form-group mb-1">
                                    <label class="form-label">Panel Name:</label>
                                    {{ $item->name }}
                                </div>
                                <div class="form-group mb-1">
                                    <label class="form-label">Panel Email :</label>
                                    {{ $item->email }}
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Confirmation :</label>
                                    <div
                                        class="btn btn-sm btn-soft-{{ $item->pivot->confirmed == null ? 'warning' : ($item->pivot->confirmed == 0 ? 'danger' : 'primary') }}">
                                        {{ $item->pivot->confirmed == null ? 'Pending' : ($item->pivot->confirmed == 0 ? 'Rejected' : 'Confirmed') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div> <!--end row-->
                @endif
                <div class="row my-3">
                    <div class="col-lg-8">


                        @if (!$applicant->case_study)
                           
                            <form action="{{ route('applicant_add_study_material') }}" class="modal_form m-2"
                                method="post" id="send_material_form" enctype="multipart/form-data" novalidate>
                                @csrf
                                <h3> Case Study Material:</h3>
                                <input type="hidden" name="job_applicant_id" class="job_applicant_id"
                                    value="{{ $applicant->id }}">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">Upload your Case Study Material</label>
                                                <span class="text-danger error-container"
                                                    id="case_study_material_error">
                                                    @error('case_study_material')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                                <input required type="file" id="input-file-now-custom-2"
                                                    name="case_study_material" class="dropify" data-height="100" />



                                            </div>
                                        </div>
                                        <div class="col-12">

                                            <div class="form-group row d-flex align-items-end">

                                                <div class="col-lg-6 col-md-12">
                                                    <label class="form-label">Date</label>
                                                    <span class="text-danger error-container" id="date_error">
                                                        @error('date')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                    <input type="date" required name="date" class="form-select">
                                                    {{-- <input type="text" required name="interview[0][date]" class="form-control mdate" placeholder="2017-06-04"> --}}

                                                </div><!--end col-->

                                                <div class="col-lg-6 col-md-12">
                                                    <label class="form-label">Time</label>
                                                    <span class="text-danger error-container" id="time_error">
                                                        @error('time')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                    <input required class="form-control timepicker" name="time"
                                                        id="" placeholder="Check time">


                                                </div><!--end col-->




                                            </div>

                                        </div>
                                        <div class="col-2">
                                            <button class="btn btn-sm btn-outline-primary" type="submit">
                                                Submit</button>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        @endif
                    </div>
                </div>
                <form action="{{ route('jobs-applicants-panel_score_submit') }}" method="post">
                    @csrf

                    <input type="hidden" name="job_applicant_id" value={{ base64_encode($applicant->id) }}>
                    <input type="hidden" name="job_id" value={{ base64_encode($applicant->job_id) }}>
                    <input type="hidden" name="stage_id" value={{ base64_encode($applicant->stage_id) }}>

                    <div class="row">
                        <div class="col-12">


                            @php
                                if (isset($job_stage_weight[4])) {
                                    $stage1_stage = $job_stage_weight[4]->pluck('stage_weight', 'stage_id')->unique();
                                    $stage1 = $job_stage_weight[4]->pluck('competency_weight', 'competency');
                                }
                            @endphp
                            <h4 class="card-title">Stage 4</h4>



                            @if (in_array(4, $stages))

                                @if ($stages_question->has(4))
                                    @foreach ($stages_question[4] as $competency => $question)
                                        <fieldset id="hard" class="field-set "
                                            data-count="{{ $loop->iteration }}">
                                            <div class="row">
                                                <div class="">
                                                    <div class="repeat-list">
                                                        <div class="form-group row ms-2 my-2 d-flex align-items-end">
                                                            <div class="col-lg-6">
                                                                <div class="">
                                                                    <h6 class="">
                                                                        {{ $question->question }}
                                                                    </h6>
                                                                    <input type="text"
                                                                        name="stage[4][{{ $question->question }}]"
                                                                        class="disabled_range_selector">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!--end row-->
                                                </div>
                                            </div><!--end row-->
                                        </fieldset>
                                    @endforeach
                                @endif
                                <div class="row">
                                    <div class="col-md-6 m-2">
                                        <label for="">Feedback</label>
                                        <span class="text-danger">
                                            @error('feedback')
                                                {{ $message }}
                                            @enderror
                                        </span>
                                        <textarea rows="4" name="feedback" required class="form-control" parsley-type="reason"></textarea>
                                    </div>
                                </div>

                            @endif
                            <!--end /div-->

                        </div><!-- end col -->
                    </div><!-- end row -->
                    <div class="row align-items-center">
                        <hr>
                        <div class="col">
                            @if ($applicant->is_rejected == 0)
                                <button class=" btn btn-sm btn-soft-primary" type="submit">Screening passed</button>

                                <a class=" btn btn-sm btn-soft-danger" id="show_jobs">Reject</a>
                            @endif
                        </div><!--end col-->
                    </div>

                </form>
            </div><!-- end card-body -->
            <form action="{{ route('applicant_stage_reject') }}" method="post" id="refer_form" class="m-2">
                @csrf
                <input type="hidden" name="applicant_id" value="{{ base64_encode($applicant->id) }}">
                <div class="row">

                    <div class="col-md-6 mt-2">
                        <label for="">Reson For rejection</label>
                        <textarea rows="4" name="reason" required class="form-control" parsley-type="reason"></textarea>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-2">
                        <button class="btn btn-sm btn-primary" type="submit"> Submit</button>
                    </div>
                </div>
            </form>
        </div> <!-- end card -->
    </div> <!-- end col -->

</div>
