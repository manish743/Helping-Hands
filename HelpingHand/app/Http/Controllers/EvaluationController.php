<?php

namespace App\Http\Controllers;

use App\Mail\PanelSchedule;
use App\Mail\SendCaeStudy;
use App\Models\CaseStudy;
use App\Models\InterviewDate;
use App\Models\InterviewOption;
use App\Models\Job;
use App\Models\JobApplicant;
use App\Models\JobApplicantScore;
use App\Models\PanelConfirmation;
use App\Models\PanelInterviewer;
use App\Models\Skill;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EvaluationController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    // public function practical_evaluation(){
    //     dd('ok');
    // }
    public function practical_evaluation()
    {
        // dd('ok');
        $user = Auth::user();
        $client = $user->client;
        $job_applicant1 = $client->jobs()
            ->join('job_applicant', 'jobs.id', '=', 'job_applicant.job_id')
            // ->join('candidates', 'candidates.id', '=', 'job_applicant.candidate_id')
            ->select('job_applicant.*')
            ->where('job_applicant.stage_id', 4)
            ->where('job_applicant.current_complete', 0)
            ->get();
        $ids =  $job_applicant1->pluck('id')->toArray();
        // dd($ids);
        $job_applicant_list = JobApplicant::whereIn('id', $ids)->with('job', 'candidate', 'job_applicant_stage', 'case_study', 'panels', 'panel_interview_option')->get();
        // dd($job_applicant_list);
        return view('pages.applicant.parctical_list', compact('job_applicant_list'));
    }

    public function add_study_material(Request $request,)
    {
        // dd(Carbon::createFromTimestamp($request->server('REQUEST_TIME')));

        $validator = Validator::make($request->all(), [
            'job_applicant_id' => 'required',
            'case_study_material' => 'required',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $job_applicant_id = base64_decode($request->job_applicant_id);
        $job_applicant = JobApplicant::findOrFail($job_applicant_id);
        $candidate = $job_applicant->candidate;
        $case_study = $job_applicant->case_study()->first();
        if ($case_study) {
            $case_study->update([
                'submission_date' => $request->date,
                'submission_time' => $request->time,
            ]);
        } else {
            $case_study = CaseStudy::create([
                'job_applicant_id' => $job_applicant_id,
                'submission_date' => $request->date,
                'submission_time' => $request->time,
                // 'submitted_at'=>$request->job_applicant_id,
                // 'case_study_material'=>$request->job_applicant_id,
                // 'case_study'=>$request->job_applicant_id,
                'created_by' => $this->user->id,
            ]);
        }
        if ($request->hasFile('case_study_material')) {
            // $destinationPath = 'assets/admin/uploads/images';
            if (file_exists($case_study->case_study_material)) {
                unlink($case_study->case_study_material);
                $case_study->update([
                    'case_study_material' => null
                ]);
            }


            $slug =  Str::slug($job_applicant->candidate->first_name . base64_encode($job_applicant->id)) . "-";
            $myimage = $slug . time() . '.' . $request->case_study_material->getClientOriginalExtension();
            $path = 'assets/uploads/case_study/';
            $request->file('case_study_material')->move($path, $myimage);
            // $pdf = new PdfFile([
            //     'name' => $myimage,
            //     'path' => $path
            // ]);
            $pdfPath = $path . $myimage;
            $case_study->update([
                'case_study_material' => $pdfPath
            ]);
            // $case_study->pdffile()->save($pdf);

            $expirationDate = Carbon::parse($case_study->submission_date . $case_study->submission_time);
            Log::info($expirationDate);
            $signedUrl = URL::temporarySignedRoute('add_case_study', $expirationDate, ['job_applicant_id' => base64_encode($job_applicant_id)]);
            Mail::to($candidate->email)->send(new SendCaeStudy($job_applicant, $signedUrl, $case_study));
        }



        return response()->json(['status' => 1, 'Message' => 'Case Study Material Send to Applicant']);

        // dd($request->all(), $validator);
    }

    public function add_case_study($job_applicant_id, Request $request)
    {
        if ($request->hasValidSignature()) {
            $job_applicant_id = base64_decode($job_applicant_id);
            $job_applicant = JobApplicant::findOrFail($job_applicant_id);
            $case_study = $job_applicant->case_study()->first();
            return view('pages.client_user.add_case_study', compact('job_applicant', 'case_study'));
        } else {
            abort(404);
        }
    }
    public function store_case_study(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'case_study_id' => 'requeired',
            'job_applicant_id' => 'requeired',
            'case_study' => 'requeired|file|mimes:pdf',
        ]);
        $job_applicant_id = base64_decode($request->job_applicant_id);
        $case_study_id = base64_decode($request->case_study_id);
        $case_study = CaseStudy::findOrFail($case_study_id);
        $job_applicant = JobApplicant::findOrFail($job_applicant_id);
        if ($request->hasFile('case_study')) {
            // $destinationPath = 'assets/admin/uploads/images';
            if (file_exists($case_study->case_study)) {
                unlink($case_study->case_study);
                $case_study->update([
                    'case_study' => null
                ]);
            }


            $slug =  Str::slug($job_applicant->candidate->first_name . base64_encode($job_applicant->id)) . "-";
            $myimage = $slug . time() . '.' . $request->case_study->getClientOriginalExtension();
            $path = 'assets/uploads/case_study/';
            $request->file('case_study')->move($path, $myimage);
            // $pdf = new PdfFile([
            //     'name' => $myimage,
            //     'path' => $path
            // ]);
            $pdfPath = $path . $myimage;
            $case_study->update([
                'case_study' => $pdfPath,
                'submitted_at' => Carbon::now(),
            ]);
            // $case_study->pdffile()->save($pdf);         

            // Mail::to($candidate->email)->send(new SendCaeStudy($job_applicant,$case_study));
        }
        return response()->json(['status' => 1, 'Message' => 'Thank You Case Study Submitted Successfully']);
    }

    public function schedule_panel(Request $request)
    {
        $jsonString = json_encode($request->panel, JSON_PRETTY_PRINT);
        $decodedArray = json_decode($jsonString, true);
        $validator = Validator::make($request->all(), [
            'job_applicant_id' => 'required',
            'interview_date' => 'required|date|after_or_equal:today',
            // 'interview_id'=>'required',
            'interview_time' => 'required',
            'panel.*.name' => 'required',
            'panel.*.email' => 'required|email',
        ], [
            'job_applicant_id.required' => 'Invalid Job Applicant',
            'interview_date.required' => 'Date is Required',
            'interview_time.required' => 'Time is Required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->messages()]);
        }
        $job_applicant_id = base64_decode($request->job_applicant_id);
        $job_applicant = JobApplicant::findOrFail($job_applicant_id);
        $interview_option = $job_applicant->interview_option()->where('stage_id', 4)->first();
        // dd($interview_option);
        $interview_option = InterviewOption::firstOrCreate([
            'interview_date' => $request->interview_date,
            'interview_time' => $request->interview_time,
            'candidate_id' => $job_applicant->candidate_id,
            'job_applicant_id' => $job_applicant_id,
            'job_id' => $job_applicant->job_id,
            'stage_id' => 4,
            'created_by' => $this->user->id
        ]);
        foreach ($decodedArray as $key => $panel) {
            $new_panel = PanelInterviewer::firstOrCreate(
                [
                    'name' => $panel['name'],
                    'email' => $panel['email'],
                    'org_id' => $this->user->org_id,
                ]
            );
            $signedUrl = URL::temporarySignedRoute('panel_interview_confirm', now()->addDay(), ['job_applicant_id' => base64_encode($job_applicant_id), 'panel_id' => base64_encode($new_panel->id)]);
            Log::info('Signed_url: ' . $signedUrl);
            Mail::to($new_panel->email)->send(new PanelSchedule($new_panel, $signedUrl, $job_applicant));
            $existingJobApplicants = $new_panel->job_applicants;
            if (!$existingJobApplicants->contains($job_applicant->id)) {
                $new_panel->job_applicants()->sync([$job_applicant->id => ['interview_option_id' => $interview_option->id]], false);
            }
        }
        return response()->json(['status' => 1, 'Message' => 'Schedule sent to the Panels Successfully']);
    }
    public function reschedule_panel(Request $request)
    {
        // dd($request->all());
        $jsonString = json_encode($request->panel, JSON_PRETTY_PRINT);
        $decodedArray = json_decode($jsonString, true);
        $validator = Validator::make($request->all(), [
            'job_applicant_id' => 'required',
            'interview_date' => 'required|date|after_or_equal:today',
            // 'interview_id'=>'required',
            'interview_time' => 'required',
            'panel.*.name' => 'required',
            'panel.*.email' => 'required|email',
        ], [
            'job_applicant_id.required' => 'Invalid Job Applicant',
            'interview_date.required' => 'Date is Required',
            'interview_time.required' => 'Time is Required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->messages()]);
        }
        $job_applicant_id = base64_decode($request->job_applicant_id);
        $job_applicant = JobApplicant::findOrFail($job_applicant_id);
        $interview_option = $job_applicant->interview_option()->where('stage_id', 4)->first();
        foreach ($job_applicant->panel_confirmed as $item) {
            $new_panel = $item->panel;
            $item->update([
                'confirmed' => null
            ]);
            $signedUrl = URL::temporarySignedRoute('panel_interview_confirm', now()->addDay(), ['job_applicant_id' => base64_encode($job_applicant_id), 'panel_id' => base64_encode($new_panel->id)]);
            Log::info('Signed_url: ' . $signedUrl);
            Mail::to($new_panel->email)->send(new PanelSchedule($new_panel, $signedUrl, $job_applicant));
            $existingJobApplicants = $new_panel->job_applicants;
            if (!$existingJobApplicants->contains($job_applicant->id)) {
                $new_panel->job_applicants()->sync([$job_applicant->id => ['interview_option_id' => $interview_option->id]], false);
            }
        }
        // dd($job_applicant->panel_confirmed);
        $interview_option->update([
            'interview_date' => $request->interview_date,
            'interview_time' => $request->interview_time,
        ]);

        return response()->json(['status' => 1, 'Message' => 'Schedule sent to the Panels Successfully']);
    }


    public function panel_interview_confirm($job_applicant_id, $panel_id, Request $request)
    {


        if ($request->hasValidSignature()) {
            //    dd( Carbon::createFromTimestamp($request->expires)->format('jS F Y'));

            $job_applicant_id1 = base64_decode($job_applicant_id);
            $panel_id1 = base64_decode($panel_id);

            $job_applicant = JobApplicant::findOrFail($job_applicant_id1);
            $panel = PanelInterviewer::findOrFail($panel_id1);
            $panel_confirm = PanelConfirmation::where('panel_id', $panel->id)->where('job_applicant_id', $job_applicant->id)->with('interview_option')->first();

            $interview_option = $panel_confirm->interview_option;
            if (!isset($interview_option)) {
                $interview_option = $panel_confirm->interview_date;
                // dd('ok');
            }
            // dd($interview_option);
            return view('pages.client_user.panel_confirm', compact('job_applicant', 'panel', 'panel_confirm', 'interview_option'));
        } else {
            // dd( Carbon::createFromTimestamp($request->expires)->format('jS F Y'));
            abort(404);
        }
    }

    public function panel_interview_confirm_post(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'action' => 'required',
            'panel_confirm_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->messages()]);
        }
        $panel_confirm_id = base64_decode($request->panel_confirm_id);
        $panel_confirm = PanelConfirmation::findOrFail($panel_confirm_id);
        $interview_option = $panel_confirm->interview_option;
        // dd($interview_option);
        if ($request->action) {
            $panel_confirm->confirmed = 1;
            $panel_confirm->save();
            return response()->json(['status' => 1, 'Message' => 'The Interview Date Has been Confirm']);
        } else {
            $panel_confirm->confirmed = 0;
            $panel_confirm->save();
            return response()->json(['status' => 1, 'Message' => 'The Interview Date Has been Rejected']);
        }
    }

    public function schedule_applicant(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'job_applicant_id' => 'required',
            'interview_option_id' => 'required',
            'interview_date' => 'required',
            'interview_time' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $job_applicant_id = base64_decode($request->job_applicant_id);
        $interview_option_id = base64_decode($request->interview_option_id);
        $job_applicant = JobApplicant::findOrFail($job_applicant_id);
        $interview_option = InterviewOption::findOrFail($interview_option_id);
        $existing_interview_option = $job_applicant->interview_option()->pluck('id');

        $validation = validator(['interview_option_id' => $interview_option_id], [
            'interview_option_id' => [
                Rule::in($existing_interview_option),
            ],
        ]);
        if ($validation->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        $panel_confirmation = PanelConfirmation::where('job_applicant_id', $job_applicant_id)->where('confirmed', 1)->get();
        $expiration_date = Carbon::parse($interview_option->interview_date . $interview_option->interview_time);
        Log::info('#');
        Log::info('#New Line');
        Log::info('interview_option: ' . $expiration_date);
        $expiration_date1 = $expiration_date->addMinute(30);
        Log::info('interview_option_after_add: ' . $expiration_date);
        Log::info('expiration_date: ' . $expiration_date);
        // dd($panel_confirmation->count());
        foreach ($panel_confirmation as $panel_confirm) {
            $panel = $panel_confirm->panel;
            $signedUrl = URL::temporarySignedRoute('jobs-applicants-panel_scoring', $expiration_date1, ['job_applicant_id' => base64_encode($job_applicant_id), 'panel_id' => base64_encode($panel->id), 'expiration_date' => base64_encode($expiration_date1)], absolute: true);
            Log::info('Signed_url: ' . $signedUrl);
            Log::info('interview: ' . $expiration_date);
            Log::info('expiration_date1: ' . $expiration_date1);
            // Mail::to($panel->email)->send(new PanelSchedule($panel, $signedUrl, $job_applicant));
        }

        dd('ok');

        $interview_date = InterviewDate::create(
            [
                'created_by' => $interview_option->created_by,
                'interview_date' => Carbon::parse($interview_option->interview_date),
                'interview_time' => Carbon::parse($interview_option->interview_time),
                'candidate_id' => $interview_option->candidate_id,
                'job_id' => $interview_option->job_id,
                'stage_id' => $interview_option->stage_id,
                'job_applicant_id' => $interview_option->job_applicant_id,

            ]
        );
        foreach ($panel_confirmation as $item) {
            $item->update([
                'interview_date_id' => $interview_date->id
            ]);
        }
        return response()->json(['status' => 1, 'Message' => 'Presentaion has been scheduled with Panel ']);
    }

    public function extend_submission_date(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'job_applicant_id' => 'required',
            'case_study_id' => 'required',
            'submission_date' => 'required',
            'submission_time' => 'required',
            'add_day' => 'required|numeric|max:30',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $job_applicant_id = base64_decode($request->job_applicant_id);
        $case_study_id = base64_decode($request->case_study_id);
        $case_study = CaseStudy::findOrFail($case_study_id);
        $extended_date = Carbon::parse($case_study->submission_date)->addDays($request->add_day);
        $update = $case_study->update(
            ['submission_date' => $extended_date]
        );
        if ($update) {
            return response()->json(['status' => 1, 'Message' => 'Submisstion Date Has Been Extended By ' . $request->add_day . ' days']);
        } else {
            return response()->json(['status' => 0, 'Message' => 'Error in Extending Submission Date']);
        }
    }

    public function panel_scoring_page($job_applicant_id, $panel_id, $expiration_date, Request $request)
    {
        if ($request->hasValidSignature()) {
            $panel_id = base64_decode($panel_id);
            $panel = PanelInterviewer::findOrFail($panel_id);
            $expiration_date = base64_decode($expiration_date);
            $current_time = Carbon::now();
            $expiration_date1 = Carbon::parse($expiration_date);
            $opening_date = Carbon::parse($expiration_date)->subMinutes(30);
            $timeDifference = $current_time->diff($expiration_date1);
            $minutesDifference = $current_time->diffInMinutes($expiration_date1);
            // dd($minutesDifference);
            if ($current_time->lt($expiration_date)) {
                // dd('okay'.$minutesDifference);
                if ($minutesDifference <= 30) {
                    $id1 = base64_decode($job_applicant_id);

                    $applicant = JobApplicant::with('panels', 'panel_interview_option')->findOrFail($id1);
                    $job = $applicant->job()->first();
                    $candidate = $applicant->candidate()->with('images', 'pdffile')->first();
                    $screening_date = $applicant->interview_date()->where('stage_id', $applicant->stage_id)->where('status', 0)->where('is_cancelled', 0)->first();
                    $screening_option = $applicant->interview_option()->where('stage_id', $applicant->stage_id)->get();
                    $job_stage_weight = $job->job_stage_weight()->select('stage_id', 'competency', 'competency_weight', 'stage_weight')->get()->groupBy('stage_id');
                    $stages = $job->questions->pluck('pivot.stage_id')->unique()->values()->toArray();
                    $skill = $job->questions()->select('job_question.skill_id', 'job_question.stage_id', 'job_question.competency')->get()->groupBy('stage_id')->toArray();
                    foreach ($skill as $stageId => $stageSkills) {
                        $stageSkills = collect($stageSkills)->groupBy('competency')->unique()->toArray();
                    }
                    $stages_question = $job->questions()
                        ->leftjoin('skills', 'job_question.skill_id', '=', 'skills.id')
                        ->select('questions.question', 'job_question.stage_id', 'job_question.skill_id', 'job_question.competency', 'skills.name as skill')
                        ->wherePivotIn('job_question.stage_id', $stages)
                        ->get()
                        ->groupBy('pivot.stage_id');
                    $applied = $candidate->jobs()->where('org_id', $job->org_id)->get();
                    $current_job = $candidate->experience()->where('present_job', 1)->firstOrFail();
                    $previous_job = $candidate->experience()->where('present_job', 0)->firstOrFail();
                    $hard_skill = Skill::where('competency', 'Hard Skill')->with('skill_category')->get();
                    $skill_category = $hard_skill->pluck('skill_category', 'id')->unique()->toArray();

                    if (count($candidate->pdffile) > 0) {
                        $pdf_file = $candidate->pdffile()->firstOrFail();
                        $pdfPath = $pdf_file->path . $pdf_file->name;
                    } else {
                        $pdfPath = null;
                    }
                    $panel_score = JobApplicantScore::where('job_applicant_id',$id1)->where('panel_id',$panel_id)->first();
                    // dd($panel_id,$id1);
                    return view('pages.client_user.panel_scoring', compact(
                        'candidate',
                        'applied',
                        'applicant',
                        'job',
                        'hard_skill',
                        'skill_category',
                        'current_job',
                        'previous_job',
                        'pdfPath',
                        'stages',
                        'stages_question',
                        'job_stage_weight',
                        'screening_date',
                        'screening_option',
                        'panel_id',
                        'panel_score',
                        'minutesDifference'
                    ));
                } else {
                    // dd($minutesDifference,$current_time,$opening_date);
                    return view('pages.auth.page_expired', compact(['opening_date', 'panel','minutesDifference']));
                }
            } else {
                return view('pages.auth.page_expired', compact(['opening_date', 'panel','minutesDifference']));
            }

            dump(Carbon::createFromTimestamp($request->expires)->format('jS F Y H:i'));
            dump(Carbon::createFromTimestamp(20700)->format('H:i'));
            dump(Carbon::now('Europe/Kirov')->format('jS F Y H:i'));
            dd('ok');
        } else {
            // dd('Page Expired');
            // return view('pages.auth.page_expired');
            abort(404);
        }
    }
    public function panel_score_submit(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'job_applicant_id'=>'required',
            'panel_id'=>'required',
            'job_id'=>'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()]);
        }
        $job_applicant_id = base64_decode($request->job_applicant_id);
        $panel_id = base64_decode($request->panel_id);
        $panel = PanelInterviewer::findOrFail($panel_id);
        // dd($job_applicant_id,$panel);
        $job_id = base64_decode($request->job_id);
        $job = Job::findOrFail($job_id);

        $jsonString = json_encode($request->stage, JSON_PRETTY_PRINT);
        $decodedArray = json_decode($jsonString, true);
        // dd($decodedArray[4]);
        $job_applicant = JobApplicant::findOrFail($job_applicant_id);
        $stage_id = base64_decode($request->stage_id);
        $competency_weight = $job->job_stage_weight()->where('stage_id', 4)->where('competency', 'others')->first();
        $count = count($decodedArray[4]);
        $stage_weight = $competency_weight->stage_weight;
        $question_weight = $competency_weight->competency_weight * ($stage_weight / 100) / $count;
        // dd($stage_weight,$competency_weight->competency_weight,$count,$question_weight);
        $score = 0;
        foreach ($decodedArray[4] as $value2) {
            // dd($value2);
            $score = $score + (($value2 / 100) * $question_weight);
        }

        $job_applicant_score = JobApplicantScore::create([
            'job_applicant_id' => $job_applicant_id,
            'stage_id' => 4,
            'competency' => 'others',
            'competency_score' => $score,
            'panel_id' => $panel->id ,
        ]);
        // return redirect()->back()->with('success','Score has been submitted');
        return response()->json(['status' => 1, 'Message' => 'Score has been submitted']);
    }
}
