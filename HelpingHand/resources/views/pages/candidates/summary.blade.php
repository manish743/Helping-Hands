<div class="row">
    <div class="col-md-8">
        @if ($screening_date)
            <input class="form-check-input" type="checkbox" name="candidate_summary"
                {{ Carbon\Carbon::parse($screening_date->interview_date)->format('d-m-Y') == Carbon\Carbon::today()->format('d-m-Y') ? '' : 'disabled' }}
                value="1" onclick=" toggleSummary() ">
            <label class="form-label">Candidate Summary</label>
        @endif


        <form id="summary" style="display: none" action="{{ Route('candidate_summary_update') }}" method="post">
            <div class="form-group">
                @csrf
                <input type="hidden" name="id" value="{{ base64_encode($candidate->id) }}">
                <div>

                    @if (isset($candidate->summary[0]))
                        <textarea rows="4" name="summary" class="form-control" parsley-type="summary"> {!! $candidate->summary[0]->description !!}</textarea>
                    @else
                        <textarea rows="4" name="summary" class="form-control" parsley-type="summary"> </textarea>
                    @endif


                </div>
                <div class="form-group">
                    <label class="form-label">Specify Category Of candidate</label>
                    <div>
                        <select id="skill_detail_select" name="category" class="select2 mb-3 select2"
                            style="width: 100%" data-placeholder="Choose">
                            <option value=""></option>
                            <option value="TOM" {{ $candidate->category == 'TOM' ? 'selected' : '' }}>TOM</option>
                            <option value="PATTY" {{ $candidate->category == 'PATTY' ? 'selected' : '' }}>PATTY
                            </option>
                            <option value="INES" {{ $candidate->category == 'INES' ? 'selected' : '' }}>INES</option>
                            <option value="BARON"{{ $candidate->category == 'BARON' ? 'selected' : '' }}>BARON</option>

                            {{-- @foreach ($job_list as $item)
                                            <option value="{{ base64_encode($item->id) }}">{{ $item->vacant_position }}
                                            </option>
                                        @endforeach --}}

                        </select>

                    </div>
                    <span class="text-danger">
                        @error('skill_detail')
                            {{ $message }}
                        @enderror
                    </span>
                </div>
                <span class="text-danger">
                    @error('summary')
                        {{ $message }}
                    @enderror
                </span>
            </div>
            {{-- @if (Carbon\Carbon::parse($screening_date->interview_date)->format('d-m-Y') == Carbon\Carbon::today()->format('d-m-Y'))
                    <button class="btn btn-primary text-white mb-3" type="submit">Save Summary</button>
                @else
                <button class="btn btn-primary text-white mb-3" disabled type="submit">Save Summary</button>
                @endif --}}
            <button class="btn btn-primary text-white mb-3" type="submit">Save Summary</button>
        </form>
    </div>
</div>
<script>
    function toggleSummary() {
        var summaryElement = document.getElementById('summary');
        if (summaryElement.style.display === 'none' || summaryElement.style.display === '') {
            summaryElement.style.display = 'block';
        } else {
            summaryElement.style.display = 'none';
        }
    }
</script>
