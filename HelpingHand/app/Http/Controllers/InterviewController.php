<?php

namespace App\Http\Controllers;

use App\Mail\InterviewCancel;
use App\Mail\InterviewSelection;
use App\Mail\SampleMail;
use App\Models\Candidate;
use App\Models\InterviewDate;
use App\Models\InterviewOption;
use App\Models\Job;
use App\Models\JobApplicant;
use App\Models\User;
use App\Notifications\InterviewConfirm;
use App\Notifications\NewCandidateForJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\isEmpty;

class InterviewController extends Controller
{
    public function send_registration_link(Request $request)
    {

        // $url = URL::temporarySignedRoute(
        //     'candidates-add',
        //     now()->addMinutes(30),
        //     ['id' => Auth::id()]
        // );

        $url = URL::signedRoute('candidates-add', ['id' => Auth::id()], absolute: true);
        $jsonString = json_encode($request->candidate);
        $decodedArray = json_decode($jsonString, true);
        foreach ($decodedArray as $key => $value) {
            $exist = Validator::make(
                $value,
                [
                    'email' => 'required|email|unique:users,email'
                ]
            );
            dump($value['email']);
            Mail::to($value['email'])->send(new SampleMail($url, $value));
        }
        dd('okay');
        // Mail::to('samir.maharjan349@gmail.com')->send(new SampleMail($url));
    }
    public function interview_option_candidate($user_id, $candidate_id)
    {

        $user_id = base64_decode($user_id);
        $candidate_id = base64_decode($candidate_id);
        // dd($user_id1,$candidate_id1);
        $interview_option = InterviewOption::where('created_by', $user_id)->where('candidate_id', $candidate_id)->orderBy('id', 'desc')->get();
        // dd($interview_option);
        return view('pages.candidates.interview_option_candidate', compact('interview_option'));
    }
    public function interview_option_applicant($job_applicant_id,Request $request)
    {
        if ($request->hasValidSignature()) {
        $job_applicant_id = base64_decode($job_applicant_id);
        // $candidate_id = base64_decode($candidate_id);
        // dd($user_id1,$candidate_id1);
        $interview_option = InterviewOption::where('job_applicant_id', $job_applicant_id)->orderBy('id', 'desc')->get();
        // dd($interview_option);
        return view('pages.candidates.interview_option_candidate', compact('interview_option'));
        }else{
            abort(404);
        }
    }

    public function interview_option_confirm(Request $request)
    {
        $request->validate([
            'interview_option' => 'required'
        ]);
        $id = base64_decode($request->interview_option);
        $interview_option = InterviewOption::findorFail($id);
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
        $options = InterviewOption::where('candidate_id', $interview_option->candidate_id)
            ->where('job_id', $interview_option->job_id)
            ->where('stage_id', $interview_option->stage_id)
            ->get();
        $options->each(function ($option) {
            $option->delete();
        });
        $create_user = User::find($interview_option->created_by);
        $create_user->notify(new InterviewConfirm($interview_date));
    }

    public function refer_candidate(Request $request)
    {
        //  dd( $request->all());
        $request->validate([
            'candidate_id' => 'required',
            'job_id' => 'required',
            'summary' => 'required',
        ]);
        $candidate_id = base64_decode($request->candidate_id);
        $candidate = Candidate::findOrFail($candidate_id);
        $job_id = $request->job_id;
        $job = Job::findOrFail($job_id);
        if ($job) {
            $client = $job->client;
            $client_admin = User::role('ClientAdmin')->where('org_id', $client->id)->first();

            # code...

            $client_admin->notify(new NewCandidateForJob($candidate, $job));
            // dump($client->id, $client_admin->org_id);
            // $tagIds[] = ['job_id'=>$id,'stage_id' => 1, 'created_by' => Auth::id()];
            // dump($id);
            if ($candidate->jobs()->where('jobs.id', $job_id)->wherePivot('stage_id', 0)->get()->count() < 1) {
                $candidate->jobs()->attach($job_id, ['stage_id' => 0, 'created_by' => Auth::id(), 'summary' => $request->summary]);
            } else {
                $candidate->jobs()->detach($job_id, ['stage_id' => 0, 'created_by' => Auth::id()]);
                $candidate->jobs()->attach($job_id, ['stage_id' => 0, 'created_by' => Auth::id(), 'summary' => $request->summary]);
            }
        }

        // $candidate->jobs()->sync($tagIds);
        return redirect()->back()->with('success', 'Candidate has been refer for the Job');
    }

    public function create_interview(Request $request)
    {
        // dd($request->all());
        $candidate_id = base64_decode($request->candidate_id);
        $candidate = Candidate::findOrFail($candidate_id);
        if (isset($request->job_applicant_id)) {
        $job_applicant_id = base64_decode($request->job_applicant_id);
        $job_applicant = JobApplicant::findOrFail($job_applicant_id);

        }
        $jsonString = json_encode($request->interview);
        $decodedArray = json_decode($jsonString, true);
        foreach ($decodedArray as $key => $value) {
            // dd(Carbon::parse($value['time'])->format('H:i:s'));
            if (isset($request->job_applicant_id)) {

                // dd('ok');
                $interview_option = InterviewOption::create([
                    'created_by' => Auth::id(),
                    'interview_date' => Carbon::parse($value['date']),
                    'interview_time' => Carbon::parse($value['time']),
                    'candidate_id' => $candidate_id,
                    'job_applicant_id' => $job_applicant->id,
                    'job_id' => $job_applicant->job_id,
                    'stage_id' => $job_applicant->stage_id,

                ]);
                // dd($interview_option);
               
            } else {
                $interview_option = InterviewOption::create([
                    'created_by' => Auth::id(),
                    'interview_date' => Carbon::parse($value['date']),
                    'interview_time' => Carbon::parse($value['time']),
                    'candidate_id' => $candidate_id

                ]);
               
            }
        }
        if (isset($request->job_applicant_id)) {

            $url = URL::signedRoute('interview_option_applicant', ['job_applicant_id' => base64_encode($job_applicant_id)], absolute: true);
            Mail::to($candidate->email)->send(new InterviewSelection($url, $candidate, $job_applicant));
        } else {

            $url = URL::signedRoute('interview_option_candidate', ['user_id' => base64_encode(Auth::id()), 'candidate_id' => base64_encode($candidate_id)], absolute: true);
            Mail::to($candidate->email)->send(new InterviewSelection($url, $candidate));
        }




        return redirect()->route('index')->with('success', 'Interview Dates Has been sent to the Candidate');
    }

    public function cancel_interview(Request $request)
    {
        $id = base64_decode($request->id);
        $interview_date = InterviewDate::findOrFail($id);

        $candidate = $interview_date->candidate;
        $job_applicant = $interview_date->job_applicant;


        $interview_date->update([
            'is_cancelled' => 1
        ]);

        if ($job_applicant) {
            Mail::to($candidate->email)->send(new InterviewCancel($interview_date, $candidate, $job_applicant));
        } else {
            Mail::to($candidate->email)->send(new InterviewCancel($interview_date, $candidate));
        }

        return response()->json(['status' => 1, 'Message' => 'Interview has been cancelled']);
    }
}
