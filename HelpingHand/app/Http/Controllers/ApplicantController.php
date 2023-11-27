<?php

namespace App\Http\Controllers;

use App\Mail\PanelSchedule;
use App\Mail\SendCaeStudy;
use App\Models\Candidate;
use App\Models\CaseStudy;
use App\Models\InterviewDate;
use App\Models\InterviewOption;
use App\Models\Job;
use App\Models\JobApplicant;
use App\Models\JobApplicantScore;
use App\Models\JobApplicantStage;
use App\Models\JobStageWeight;
use App\Models\PanelConfirmation;
use App\Models\PanelInterviewer;
use App\Models\PdfFile;
use App\Models\Skill;
use App\Models\User;
use App\Notifications\NewStageApplicant;
use Carbon\Carbon;
use GuzzleHttp\Psr7\ServerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\ServerBag;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class ApplicantController extends Controller
{

    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }
    public function index($id)
    {
        $id = base64_decode($id);
        $job = Job::findOrFail($id);
        $applicants = $job->applicants()->where('stage_id', 0)->where('is_rejected', 0)->with('candidate')->get();
        $rejected_applicants = $job->applicants()->where('is_rejected', 1)->with('candidate')->get();
        $proceeding_applicants = $job->applicants()->where('stage_id', '!=', 0)->with('candidate')->get();
        // dd($proceeding_applicants);
        return view('pages.applicant.applicant_list', compact('applicants', 'proceeding_applicants', 'rejected_applicants'));
    }   
    public function completed()
    {
        // dd('ok');
        $user = Auth::user();
        $client = $user->client;
        $job_applicant1 = $client->jobs()
            ->join('job_applicant', 'jobs.id', '=', 'job_applicant.job_id')
            // ->join('candidates', 'candidates.id', '=', 'job_applicant.candidate_id')
            ->select('job_applicant.*')
            ->where('job_applicant.current_complete', 1)
            ->get();
        $ids =  $job_applicant1->pluck('id')->toArray();
        // dd($ids);
        $job_applicant_list = JobApplicant::whereIn('id', $ids)->with('job', 'candidate', 'job_applicant_stage')->get();
        // dd($proceeding_applicants);
        return view('pages.applicant.completed_applicant', compact('job_applicant_list'));
    }
    public function show($id)
    {
        $id1 = base64_decode($id);
        // dd($id1);

        $applicant = JobApplicant::findOrFail($id1);
        $job = $applicant->job()->first();
        $candidate = $applicant->candidate()->with('images', 'pdffile')->first();
        // dd($applicant, $candidate);
        $applied = $candidate->jobs()->where('org_id', $job->org_id)->get();
        // dd($applied);
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
        return view('pages.applicant.detail', compact('candidate', 'applied', 'applicant', 'hard_skill', 'skill_category', 'current_job', 'previous_job', 'pdfPath'));
    }
    public function stage_view($id)
    {
        $id1 = base64_decode($id);
        // dd($id1);

        $applicant = JobApplicant::with('panels','panel_interview_option')->findOrFail($id1);
        // dd($applicant->panels);
        $job = $applicant->job()->first();
        $candidate = $applicant->candidate()->with('images', 'pdffile')->first();
        $screening_date = $applicant->interview_date()->where('stage_id', $applicant->stage_id)->where('status', 0)->where('is_cancelled', 0)->first();
        $screening_option = $applicant->interview_option()->where('stage_id', $applicant->stage_id)->get();
        // dd($screening_date,$screening_option);


        $job_stage_weight = $job->job_stage_weight()->select('stage_id', 'competency', 'competency_weight', 'stage_weight')->get()->groupBy('stage_id');

        // dd($job_stage_weight[1]->pluck('stage_weight','stage_id')->unique());
        // Gate::authorize('update', $job);
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




        // dd($stages_question);
        $applied = $candidate->jobs()->where('org_id', $job->org_id)->get();
        // dd($applied);
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
        // dd($stages_question); 
        return view('pages.client_user.stage_applicant', compact(
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
            'screening_option'
        ));
    }
    public function stage_review($id)
    {
        $id1 = base64_decode($id);
        // dd($id1);

        $applicant = JobApplicant::findOrFail($id1);
        $job = $applicant->job()->first();
        $candidate = $applicant->candidate()->with('images', 'pdffile')->first();
        $feedback = $applicant->job_applicant_stage()->where('stage_id', $applicant->stage_id)->with('created_user')->first();
        // dd($job);
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
        // dd($stages_question); 
        return view('pages.client_user.stage_review', compact(
            'candidate',
            'applicant',
            'job',
            'feedback',
            'hard_skill',
            'skill_category',
            'current_job',
            'previous_job',
            'pdfPath',



        ));
    }
    public function screen_pass(Request $request)
    {
        $id = base64_decode($request->id);
        $job_applicant = JobApplicant::findOrFail($id);
        $job = $job_applicant->job;
        $stage_status = json_decode($job->stages);
        // dd(array_search($job_applicant->stage_id,$stage_status));
        // dd($stage_status[0]);
        $job_applicant->update([
            'stage_id' => $stage_status[0]
        ]);
        return response()->json(['status' => 1, 'Message' => 'The Apllicant will has been proceeded']);
    }
    public function proceed(Request $request)
    {

        dd($request->all());
        $job_applicant_id = base64_decode($request->job_applicant_id);
        // dd($job_applicant_id);
        $job_id = base64_decode($request->job_id);
        $job = Job::findOrFail($job_id);


        $job_applicant = JobApplicant::findOrFail($job_applicant_id);
        $stage_id = base64_decode($request->stage_id);
        $stage_status = json_decode($job->stages);
        $index = array_search($stage_id, $stage_status);
        if (isset($stage_status[($index + 1)])) {
            $next = $stage_status[($index + 1)];
        } else {
            $next = $stage_status[$index];
        }
        // dd(isset($stage_status[($index+1)]));
        $stages = $job->questions->pluck('pivot.stage_id')->unique()->values()->toArray();
        $jsonString = json_encode($request->stage, JSON_PRETTY_PRINT);
        $decodedArray = json_decode($jsonString, true);

        if ($decodedArray) {

            foreach ($decodedArray as $stage => $value1) {
                // dd( $stage,$value1['hard_weight'],$value1['soft_weight'],$value1['soft_weight']);

                $validator = Validator::make($value1, [
                    'JD.*' => 'numeric',
                    'ORG.*' => 'numeric',
                    'hard.*' => 'numeric',
                    'soft.*' => 'numeric',
                    'team.*' => 'numeric',

                    // Other validation rules...
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                if ($stage == 1) {
                    if (isset($value1['JD'])) {


                        $competency_weight = $job->job_stage_weight()->where('competency', 'JD')->first();

                        $count = count($value1['JD']);
                        $stage_weight  = $competency_weight->stage_weight;
                        $question_weight = $competency_weight->competency_weight * ($stage_weight / 100) / $count;
                        $score = 0;
                        // dd($question_weight,$stage_weight);
                        foreach ($value1['JD'] as $value2) {
                            $score = $score + ($value2 / 100 * $question_weight);
                        }
                        $job_applicant_score = JobApplicantScore::create([
                            'job_applicant_id' => $job_applicant_id,
                            'stage_id' => 1,
                            'competency' => 'JD',
                            'competency_score' => $score,
                        ]);
                    }
                    if (isset($value1['ORG'])) {

                        $competency_weight = $job->job_stage_weight()->where('competency', 'ORG')->first();
                        $count = count($value1['ORG']);
                        $stage_weight  = $competency_weight->stage_weight;
                        $question_weight = $competency_weight->competency_weight * ($stage_weight / 100) / $count;
                        $score = 0;
                        foreach ($value1['ORG'] as $value2) {
                            $score = $score + ($value2 / 100 * $question_weight);
                        }
                        $job_applicant_score = JobApplicantScore::create([
                            'job_applicant_id' => $job_applicant_id,
                            'stage_id' => 1,
                            'competency' => 'ORG',
                            'competency_score' => $score,
                        ]);
                    }
                    if (isset($value1['hard'])) {

                        $competency_weight = $job->job_stage_weight()->where('competency', 'Hard Skill')->first();
                        $count = count($value1['hard']);
                        $stage_weight  = $competency_weight->stage_weight;
                        $question_weight = $competency_weight->competency_weight * ($stage_weight / 100) / $count;
                        $score = 0;
                        foreach ($value1['hard'] as $value2) {
                            $score = $score + ($value2 / 100 * $question_weight);
                        }
                        $job_applicant_score = JobApplicantScore::create([
                            'job_applicant_id' => $job_applicant_id,
                            'stage_id' => 1,
                            'competency' => 'Hard Skill',
                            'competency_score' => $score,
                        ]);
                    }
                    if (isset($value1['soft'])) {

                        $competency_weight = $job->job_stage_weight()->where('competency', 'Soft Skill')->first();
                        $count = count($value1['soft']);
                        $stage_weight  = $competency_weight->stage_weight;
                        $question_weight = $competency_weight->competency_weight * ($stage_weight / 100) / $count;
                        $score = 0;
                        foreach ($value1['soft'] as $value2) {
                            $score = $score + ($value2 / 100 * $question_weight);
                        }
                        $job_applicant_score = JobApplicantScore::create([
                            'job_applicant_id' => $job_applicant_id,
                            'stage_id' => 1,
                            'competency' => 'Soft Skill',
                            'competency_score' => $score,
                        ]);
                    }
                    if (isset($value1['team'])) {

                        $competency_weight = $job->job_stage_weight()->where('competency', 'Team Fit')->first();
                        $count = count($value1['team']);
                        $stage_weight  = $competency_weight->stage_weight;
                        $question_weight = $competency_weight->competency_weight * ($stage_weight / 100) / $count;
                        $score = 0;
                        foreach ($value1['team'] as $value2) {
                            $score = $score + ($value2 / 100 * $question_weight);
                        }
                        $job_applicant_score = JobApplicantScore::create([
                            'job_applicant_id' => $job_applicant_id,
                            'stage_id' => 1,
                            'competency' => 'Team Fit',
                            'competency_score' => $score,
                        ]);
                    }
                    $totalscore = JobApplicantScore::where('job_applicant_id', $job_applicant_id)->sum('competency_score');
                    $job_applicant_stage = JobApplicantStage::firstOrCreate([
                        'job_applicant_id' => $job_applicant_id,
                        'job_id' => $job_id,
                        'stage_id' => 1,
                        'score' => $totalscore,
                        'is_rejected' => 0,
                        'summary' => $request->feedback,
                        'next_stage' => $next,
                        'created_by' => Auth::id(),
                    ]);
                    $job_applicant->update([
                        'current_complete' => 1,

                    ]);
                }
                if ($stage == 2 || $stage == 3) {
                    if (isset($value1['hard'])) {
                        // dd($request->all());
                        $competency_weight = $job->job_stage_weight()->where('stage_id', $stage)->where('competency', 'Hard Skill')->first();
                        $count = count($value1['hard']);
                        $stage_weight = $competency_weight->stage_weight;
                        $question_weight = $competency_weight->competency_weight * ($stage_weight / 100) / $count;
                        // dd($stage_weight,$competency_weight->competency_weight,$count,$question_weight);
                        $score = 0;
                        foreach ($value1['hard'] as $value2) {

                            $score = $score + (($value2 / 100) * $question_weight);
                            dump($score);
                        }

                        $job_applicant_score = JobApplicantScore::create([
                            'job_applicant_id' => $job_applicant_id,
                            'stage_id' => $stage,
                            'competency' => 'Hard Skill',
                            'competency_score' => $score,
                        ]);
                    }
                    if (isset($value1['soft'])) {

                        $competency_weight = $job->job_stage_weight()->where('stage_id', $stage)->where('competency', 'Soft Skill')->first();
                        $count = count($value1['soft']);
                        $stage_weight = $competency_weight->stage_weight;
                        $question_weight = $competency_weight->competency_weight * ($stage_weight / 100) / $count;
                        $score = 0;
                        foreach ($value1['soft'] as $value2) {
                            $score = $score + (($value2 / 100) * $question_weight);
                        }
                        $job_applicant_score = JobApplicantScore::create([
                            'job_applicant_id' => $job_applicant_id,
                            'stage_id' => $stage,
                            'competency' => 'Soft Skill',
                            'competency_score' => $score,
                        ]);
                    }
                    if (isset($value1['team'])) {

                        $competency_weight = $job->job_stage_weight()->where('stage_id', $stage)->where('competency', 'Team Fit')->first();
                        $count = count($value1['team']);
                        $stage_weight = $competency_weight->stage_weight;
                        $question_weight = $competency_weight->competency_weight * ($stage_weight / 100) / $count;
                        $score = 0;
                        foreach ($value1['team'] as $value2) {
                            $score = $score + (($value2 / 100) * $question_weight);
                        }
                        $job_applicant_score = JobApplicantScore::create([
                            'job_applicant_id' => $job_applicant_id,
                            'stage_id' => $stage,
                            'competency' => 'Team Fit',
                            'competency_score' => $score,
                        ]);
                    }
                    $totalscore = JobApplicantScore::where('stage_id', $stage)->where('job_applicant_id', $job_applicant_id)->sum('competency_score');
                    $job_applicant_stage = JobApplicantStage::create([
                        'job_applicant_id' => $job_applicant_id,
                        'job_id' => $job_id,
                        'stage_id' => $stage,
                        'score' => $totalscore,
                        'is_rejected' => 0,
                        'summary' => $request->feedback,
                        'next_stage' => $next,
                        'created_by' => Auth::id(),
                    ]);
                    $job_applicant->update([
                        'current_complete' => 1,

                    ]);
                }
                if ($stage == 4 || $stage == 5) {

                    if (isset($value1)) {
                        // dd($value1);
                        $competency_weight = $job->job_stage_weight()->where('stage_id', $stage)->where('competency', 'others')->first();
                        $count = count($value1);
                        $stage_weight = $competency_weight->stage_weight;
                        $question_weight = $competency_weight->competency_weight * ($stage_weight / 100) / $count;
                        // dd($stage_weight,$competency_weight->competency_weight,$count,$question_weight);
                        $score = 0;
                        foreach ($value1 as $value2) {
                            // dd($value2);
                            $score = $score + (($value2 / 100) * $question_weight);
                        }

                        $job_applicant_score = JobApplicantScore::create([
                            'job_applicant_id' => $job_applicant_id,
                            'stage_id' => $stage,
                            'competency' => 'others',
                            'competency_score' => $score,
                        ]);
                        $totalscore = JobApplicantScore::where('stage_id', $stage)->where('job_applicant_id', $job_applicant_id)->sum('competency_score');
                        $job_applicant_stage = JobApplicantStage::create([
                            'job_applicant_id' => $job_applicant_id,
                            'job_id' => $job_id,
                            'stage_id' => $stage,
                            'score' => $totalscore,
                            'is_rejected' => 0,
                            'summary' => $request->feedback,
                            'next_stage' => $next,
                            'created_by' => Auth::id(),
                        ]);
                        $job_applicant->update([
                            'current_complete' => 1,

                        ]);
                    }
                }
            }
        }
        if (!isset($stage_status[($index + 1)])) {
            $job_applicant->update([
                'stage_complete' => 1,
            ]);
        }
        return redirect()->back()->with('success', 'Applicant Evaluation Completed');
    }
    public function review_proceed(Request $request)
    {

        // dd($request->all());
        $validator = Validator::make(
            $request->all(),
            [
                'job_applicant_id' => 'required',
                'stage' => 'required',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $job_applicant_id = base64_decode($request->job_applicant_id);
        $job_applicant = JobApplicant::findOrFail($job_applicant_id);
        $job = $job_applicant->job;
        $permission_name = 'Edit-Stage' . $request->stage;
        $permission = Permission::where('name', $permission_name)->first();
        $user_id = $permission->users()->pluck('id');
        // dump($user_id);
        $stage_users = User::whereIn('id', $user_id)->where('org_id', $job->org_id)->get();
        // dd($stage_users);




        if ($request->stage == 'hire' || $request->stage == 'Hire') {
            $job_applicant->update([
                'is_hired' => 1,
            ]);
        } elseif ($request->stage == 'reject' || $request->stage == 'Reject') {
            $job_applicant->update([
                'is_rejected' => 1,
            ]);
        } else {
            $job_applicant->update([
                'stage_id' => $request->stage,
                'current_complete' => 0
            ]);
            Log::info('stage changed to : ' . $request->stage);
            Notification::send($stage_users, new NewStageApplicant($stage_users, $job_applicant,));
        }


        return redirect()->route('jobs-applicants-completed')->with('success', 'Applicant has been recommended to Stage ' . $request->stage);
    }
    public function stage_reject(Request $request)
    {
        $request->validate([
            'applicant_id' => 'required',
            'reason' => 'required',
        ]);
        $id = base64_decode($request->applicant_id);

        $applicant = JobApplicant::findOrFail($id);
        $job_applicant_stage = JobApplicantStage::firstOrCreate([
            'job_applicant_id' => $applicant->id,
            'job_id' => $applicant->job_id,
            'stage_id' => $applicant->stage_id,
            'is_rejected' => 1,
            'reason' => $request->reason,
            'summary' => $request->summary,

            'created_by' => Auth::id(),
        ]);
        $applicant->update([
            'current_complete' => 1,

        ]);
        // dd($applicant);
        return redirect()->back()->with('success', 'Applicant has been rejected from the job');
    }

    
}
