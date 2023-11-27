<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\EmployeeDetail;
use App\Models\Job;
use App\Models\JobApplicant;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }
    public function index()
    {
        $client = EmployeeDetail::with(['images', 'subscription'])->orderby('expires_at', 'asc')->get();
        $now = Carbon::now();
        $client = $client->map(function ($item) use ($now) {
            $expiresAt = Carbon::parse($item->expires_at);
            if ($expiresAt > $now) {

                $item['remaining_days'] = $expiresAt->diffInDays($now);
            } else {

                $item['remaining_days'] = 0;
            }


            return $item;
        });

        $user = $this->user;
        // dd($user);
        if ($user->hasRole('SuperAdmin')) {
            $job_list = Job::where('status', 1)->with('questions', 'client')->orderBy('created_at', 'desc')->get();
        } elseif ($user->hasRole('ClientAdmin')) {
            $job_list = Job::where('status', 1)->where('org_id', $user->org_id)->with('questions', 'client')->orderBy('created_at', 'desc')->get();
        } elseif ($user->hasRole('HIMSubUser')) {
            return $this->sub_user_index();
        } elseif ($user->hasRole('StageUser')) {
            return $this->client_user_index();
        }


        $job_list->each(function ($job) {
            // Retrieve the stages associated with questions for this job
            $stages = $job->questions->pluck('pivot.stage_id')->unique()->values()->toArray();

            // Add the $stages array as a new column 'stages' in the job
            $job->stages = $stages;
        });
        return view('pages.index', compact('client', 'job_list'));
    }
    public function sub_user_index()
    {
        $job_list = Job::where('status', 1)->with('questions', 'client')->orderBy('created_at', 'desc')->get();
        // dd(count($job_list));
        $candidate = Candidate::with('experience')->where('is_screened', 0)->get();
        $candidate = $candidate->map(function ($item) {
            $current_job = $item->experience()->where('present_job', 1)->first();
            $item['current_job'] = $current_job;
            return $item;
        });
        $job_list->each(function ($job) {
            // Retrieve the stages associated with questions for this job
            $stages = $job->questions->pluck('pivot.stage_id')->unique()->values()->toArray();

            // Add the $stages array as a new column 'stages' in the job
            $job->stages = $stages;
        });
        return view('pages.admin_user.dashboard', compact('candidate', 'job_list'));
    }
    public function client_user_index()
    {
        $user = $this->user;
        $client = $user->client;
        $ids = [];
        if ($user->hasPermissionto('Edit-Stage1')) {
            $job_applicant1 = $client->jobs()
                ->join('job_applicant', 'jobs.id', '=', 'job_applicant.job_id')
                // ->join('candidates', 'candidates.id', '=', 'job_applicant.candidate_id')
                ->select('job_applicant.*')
                ->where('job_applicant.stage_id', 1)
                ->where('job_applicant.stage_complete', 0)
                ->where('job_applicant.current_complete',0)
                ->get();
            $ids = array_merge($ids, $job_applicant1->pluck('id')->toArray());
        }
        if ($user->hasPermissionto('Edit-Stage2')) {
            $job_applicant2 = $client->jobs()
                ->join('job_applicant', 'jobs.id', '=', 'job_applicant.job_id')
                // ->join('candidates', 'candidates.id', '=', 'job_applicant.candidate_id')
                ->select('job_applicant.*')
                ->where('job_applicant.stage_id', 2)
                ->where('job_applicant.stage_complete', 0)
                ->where('job_applicant.current_complete',0)
                ->get();
                $ids = array_merge($ids, $job_applicant2->pluck('id')->toArray());
        }
        if ($user->hasPermissionto('Edit-Stage3')) {
            $job_applicant3 = $client->jobs()
                ->join('job_applicant', 'jobs.id', '=', 'job_applicant.job_id')
                // ->join('candidates', 'candidates.id', '=', 'job_applicant.candidate_id')
                ->select('job_applicant.*')
                ->where('job_applicant.stage_id', 3)
                ->where('job_applicant.stage_complete', 0)
                ->where('job_applicant.current_complete',0)
                ->get();
                $ids = array_merge($ids, $job_applicant3->pluck('id')->toArray());
        }
        if ($user->hasPermissionto('Edit-Stage4')) {
            $job_applicant4 = $client->jobs()
                ->join('job_applicant', 'jobs.id', '=', 'job_applicant.job_id')
                // ->join('candidates', 'candidates.id', '=', 'job_applicant.candidate_id')
                ->select('job_applicant.*')
                ->where('job_applicant.stage_id', 4)
                ->where('job_applicant.stage_complete', 0)
                ->where('job_applicant.current_complete',0)
                ->get();
                // $ids = array_merge($ids, $job_applicant4->pluck('id')->toArray());
        }
        if ($user->hasPermissionto('Edit-Stage5')) {
            $job_applicant4 = $client->jobs()
                ->join('job_applicant', 'jobs.id', '=', 'job_applicant.job_id')
                // ->join('candidates', 'candidates.id', '=', 'job_applicant.candidate_id')
                ->select('job_applicant.*')
                ->where('job_applicant.stage_id', 5)
                ->where('job_applicant.stage_complete', 0)
                ->where('job_applicant.current_complete',0)
                ->get();
                $ids = array_merge($ids, $job_applicant4->pluck('id')->toArray());
        }

        $job_applicant_list = JobApplicant::whereIn('id',$ids)->with('job','candidate','job_applicant_stage')->get();


        // dd($ids, $job_applicant_list);
        // $candidate = Candidate::with('experience')->where('is_screened', 0)->get();
        // $candidate = $candidate->map(function ($item) {
        //     $current_job = $item->experience()->where('present_job', 1)->first();
        //     $item['current_job'] = $current_job;
        //     return $item;
        // });
        // $job_list->each(function ($job) {
        //     // Retrieve the stages associated with questions for this job
        //     $stages = $job->questions->pluck('pivot.stage_id')->unique()->values()->toArray();

        //     // Add the $stages array as a new column 'stages' in the job
        //     $job->stages = $stages;
        // });
        return view('pages.client_user.dashboard', compact('job_applicant_list'));
    }

    public function read_notification(Request $request)
    {
        $notificationId = $request->id;
        $notification = Auth::user()->notifications()->findOrFail($notificationId);
        $notification->markAsRead();
        return response()->json(['status' => 1, 'message' => 'Notification marked as read']);
    }
}
