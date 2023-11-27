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


                            <div class="card">
                                <div class="card-header">
                                    @php

                                        if (isset($job_stage_weight[5])) {
                                            $stage1_stage = $job_stage_weight[5]->pluck('stage_weight', 'stage_id')->unique();
                                            $stage1 = $job_stage_weight[5]->pluck('competency_weight', 'competency');
                                        }
                                    @endphp

                                    <h4 class="card-title">Stage 5</h4>
                                </div>

                                <!--end card-header-->
                                @if (in_array(5, $stages))
                                    <div class="card-body mb-2 stage_id"
                                        style="max-height:; overflow-y:auto; visibility:{{ in_array(5, $stages) ? 'visible' : 'hidden' }};"
                                        data-stage="2">
                                        
                                       
                                            @if ($stages_question->has(5))
                                                
                                                @foreach ($stages_question[5] as $competency => $question)
                                                   
                                                        <fieldset id="hard" class="field-set"
                                                            data-count="{{ $loop->iteration }}">

                                                            <div class="row">
                                                                <div class="">
                                                                   
                                                                    <div class="repeat-list">
                                                                        
                                                                            <div
                                                                                class="form-group row ms-2 my-2 d-flex align-items-end">

                                                                                <div class="col-lg-6">
                                                                                    <div class="">
                                                                                        <h6 class="">
                                                                                            {{ $question->question }}
                                                                                        </h6>
                                                                                        <input type="text"
                                                                                            name="stage[5][{{ $question->question }}]"
                                                                                            class="range_selector">
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
                                    
                                @endif

                                <!--end /div-->

                            </div><!--end card-->





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
