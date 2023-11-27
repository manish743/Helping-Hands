<div class="row p-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">


                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="card-title">Scoring</h4>
                    </div><!--end col-->

                </div>
            </div><!--end card-header-->
            <form action="{{ route('applicant-proceed') }}" method="post">
                @csrf
                <input type="hidden" name="job_applicant_id" value={{ base64_encode($applicant->id) }}>
                <input type="hidden" name="job_id" value={{ base64_encode($applicant->job_id) }}>
                <input type="hidden" name="stage_id" value={{ base64_encode($applicant->stage_id) }}>
                <div class="card-body bootstrap-select-1">
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <div class="card-header">
                                    @php
                                        if (isset($job_stage_weight[1])) {
                                            $stage1_stage = $job_stage_weight[1]
                                                ->pluck('stage_weight', 'stage_id')
                                                ->unique()
                                                ->first();
                                            // dd($stage1_stage);
                                            $stage1 = $job_stage_weight[1]->pluck('competency_weight', 'competency');
                                        }
                                    @endphp
                                    <div class="form-check form-check-inline">
                                        <h4 class="card-title">Stage 1</h4>
                                    </div>

                                </div><!--end card-header-->



                                <div class="card-body mb-2 {{ isset($stage1_stage) ? '' : 'd-none' }} stage_id"
                                    style="overflow-y: auto;  max-height: ;" data-stage="1">


                                    @if (isset($stage1_stage) && isset($stage1['JD']) && isset($stages_question[1]))

                                        <div class="form-check form-check-inline">

                                            <h4 class="card-title">JD and skills comparison
                                            </h4>


                                        </div>

                                        @if (isset($stage1_stage) && in_array('JD', $job_stage_weight[1]->pluck('competency')->toArray()))

                                            <div class="ms-5">

                                                @php
                                                    $jd = $stages_question[1]->where('competency', 'JD')->groupBy('competency');
                                                    // dd($jd);
                                                @endphp

                                                @foreach ($jd['JD'] as $jd_item)
                                                    <div class="form-group row ms-2 my-2 d-flex align-items-end">

                                                        <div class="col-lg-6">
                                                            <div class="">
                                                                <h6 class="">{!! $jd_item->question !!}</h6>
                                                                <input type="text" name="stage[1][JD][]"
                                                                    class="range_selector">
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach


                                            </div>
                                        @endif
                                        <hr>
                                    @endif


                                    @if (isset($stage1_stage) && isset($stage1['ORG']) && isset($stages_question[1]))

                                        <div class="form-check form-check-inline">

                                            <h4 class="card-title">ORG and skills comparison
                                            </h4>


                                        </div>

                                        @if (isset($stage1_stage) && in_array('ORG', $job_stage_weight[1]->pluck('competency')->toArray()))

                                            <div class="ms-5">

                                                @php
                                                    $ORG = $stages_question[1]->where('competency', 'ORG')->groupBy('competency');
                                                    // dd($ORG);
                                                @endphp

                                                @foreach ($ORG['ORG'] as $ORG_item)
                                                    <div class="form-group row ms-2 my-2 d-flex align-items-end">

                                                        <div class="col-lg-6">
                                                            <div class="">
                                                                <h6 class="">{!! $ORG_item->question !!}</h6>
                                                                <input type="text" name="stage[1][ORG][]"
                                                                    class="range_selector">
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach


                                            </div>
                                        @endif
                                        <hr>
                                    @endif
                                    @if (isset($stage1_stage) && isset($stage1['Hard Skill'])&& isset($stages_question[1]))

                                        <div class="form-check form-check-inline">

                                            <h4 class="card-title">Hard Skill
                                            </h4>


                                        </div>

                                        @if (isset($stage1_stage) && in_array('Hard Skill', $job_stage_weight[1]->pluck('competency')->toArray()))

                                            <div class="ms-5">

                                                @php
                                                    $HARD = $stages_question[1]->where('competency', 'Hard Skill')->groupBy('competency');
                                                    // dd($HARD);
                                                @endphp

                                                @foreach ($HARD['Hard Skill'] as $HARD_item)
                                                    <div class="form-group row ms-2 my-2 d-flex align-items-end">

                                                        <div class="col-lg-6">
                                                            <div class="">
                                                                <h6 class="">
                                                                    {{ $loop->iteration }}.{!! $HARD_item->question !!}</h6>
                                                                <input type="text" name="stage[1][hard][]"
                                                                    class="range_selector">
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach

                                            </div>

                                        @endif
                                        <hr>
                                    @endif
                                    @if (isset($stage1_stage) && isset($stage1['Soft Skill'])&& isset($stages_question[1]))

                                        <div class="form-check form-check-inline">

                                            <h4 class="card-title">Soft Skill
                                            </h4>


                                        </div>

                                        @if (isset($stage1_stage) && in_array('Soft Skill', $job_stage_weight[1]->pluck('competency')->toArray()))
                                            <div class="ms-5">


                                                @php
                                                    $soft = $stages_question[1]->where('competency', 'Soft Skill')->groupBy('competency');
                                                    // dd($soft);
                                                @endphp

                                                @foreach ($soft['Soft Skill'] as $soft_item)
                                                    <div class="form-group row ms-2 my-2 d-flex align-items-end">

                                                        <div class="col-lg-6">
                                                            <div class="">
                                                                <h6 class="">
                                                                    {{ $loop->iteration }}.{!! $soft_item->question !!}</h6>
                                                                <input type="text" name="stage[1][soft][]"
                                                                    class="range_selector">
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach


                                            </div>
                                        @endif
                                        <hr>
                                    @endif
                                    @if (isset($stage1_stage) && isset($stage1['Team Fit'])&& isset($stages_question[1]))

                                        <div class="form-check form-check-inline">

                                            <h4 class="card-title">Team Fit
                                            </h4>


                                        </div>

                                        @if (isset($stage1_stage) && in_array('Team Fit', $job_stage_weight[1]->pluck('competency')->toArray()))
                                            <div class="ms-5">


                                                @php
                                                    $team = $stages_question[1]->where('competency', 'Team Fit')->groupBy('competency');
                                                    // dd($team);
                                                @endphp

                                                @foreach ($team['Team Fit'] as $team_item)
                                                    <div class="form-group row ms-2 my-2 d-flex align-items-end">

                                                        <div class="col-lg-6">
                                                            <div class="">
                                                                <h6 class="">
                                                                    {{ $loop->iteration }}.{!! $HARD_item->question !!}</h6>
                                                                <input type="text" name="stage[1][team][]"
                                                                    class="range_selector">
                                                            </div>
                                                        </div>

                                                    </div>
                                                @endforeach


                                            </div>
                                        @endif
                                        <hr>
                                    @endif


                                    <div class="row">

                                        <div class="col-md-6 m-2 ms-5">
                    
                                            <label for="">Feedback</label>
                                            <span class="text-danger">
                                                @error('feedback')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            <textarea rows="4" name="feedback" required class="form-control" parsley-type="reason"></textarea>
                    
                    
                                        </div>
                    
                    
                                    </div>
                                </div><!--end of card body -->
                                <!--end /div-->

                            </div>



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



                </div><!-- end card-body -->
            </form>
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
