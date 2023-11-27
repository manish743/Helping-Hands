<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateStoreValidation;
use App\Mail\InterviewSelection;
use App\Mail\SampleMail;
use Illuminate\Support\Str;
use App\Models\Candidate;
use App\Models\CandidateExperience;
use App\Models\EmployeeDetail;
use App\Models\Image;
use App\Models\InterviewDate;
use App\Models\InterviewOption;
use App\Models\Job;
use App\Models\PdfFile;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\Summary;
use App\Models\User;
use App\Notifications\CandidateRegistered;
use App\Notifications\InterviewConfirm;
use App\Notifications\NewCandidateForJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator as ValidationValidator;

class CandidateController extends Controller
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
        $user = $this->user;
        if ($user->hasRole('SuperAdmin')) {
            $candidate = Candidate::with('experience')->get();
        } else {
            $candidate = Candidate::with('experience')->get();
            $candidate = Candidate::where('created_by', $user->org_id)->get();
        }
        // $candidate = Candidate::with('experience')->get();
        $candidate = $candidate->map(function ($item) {
            $current_job = $item->experience()->where('present_job', 1)->first();
            $item['current_job'] = $current_job;
            return $item;
        });
        // dd($candidate);
        return view('pages.candidates.index', compact('candidate'));
    }
    public function category_index($cat)
    {
        $allowed = ['TOM','PATTY','INES','BARON','tom','patty','ines','baron'];
        $validator = Validator::make(['cat' => $cat],[
            'cat'=>[
                'required',
                Rule::in($allowed),
            ],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
    
        $user = $this->user;
            $cat = Str::upper($cat);
            $candidate = Candidate::where('category',$cat)->with('experience')->get();
        
        // $candidate = Candidate::with('experience')->get();
        $candidate = $candidate->map(function ($item) {
            $current_job = $item->experience()->where('present_job', 1)->first();
            $item['current_job'] = $current_job;
            return $item;
        });
        // dd($candidate);
        return view('pages.candidates.category_index', compact('candidate'));
    }
    public function screening_candidates()
    {
        $user = $this->user;
        $interview_dates = $user->interview_date()->where('status',0)->where('is_cancelled',0)->with('candidate','job','job_applicant')->orderBy('interview_date')->orderBy('interview_time')->get();
      
        return view('pages.candidates.screening', compact('interview_dates'));
    }
    public function test()
    {
        $url = URL::temporarySignedRoute(
            'candidates-add',
            now()->addMinutes(30),
            ['id' => Auth::id()]
        );
        // Mail::to('samir.maharjan349@gmail.com')->send(new SampleMail($url));
        // return view('pages.candidates.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id)
    {
        // dd('ok');
        $hard_skill = Skill::where('competency', 'Hard Skill')->with('skill_category')->get();
        $skill_category = $hard_skill->pluck('skill_category', 'id')->unique()->toArray();
        // $skill_category = $hard_skill->flatMap(function ($skill) {
        //     return $skill->skill_category;
        // });
        // dd($skill_category);

        if ($request->hasValidSignature()) {

            return view('pages.candidates.unauth_create', compact('id', 'hard_skill', 'skill_category'));
        }
        if (Auth::check()) {
            $user = Auth::user();
            return view('pages.candidates.create', compact('id', 'hard_skill', 'skill_category'));
        } else {
            abort(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CandidateStoreValidation $request)
    {

        $user1 = User::findOrFail($request->id);
        $candidate = Candidate::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact' => $request->contact,
            'current_salary' => $request->current_salary,
            'expected_salary' => $request->expected_salary,
            'job_type' => $request->job_type,
            'speciality' => $request->area_of_speciality,
            'interest' => $request->area_of_interest,
            'created_by' => $user1->id,
            'available' => 1,
        ]);
        $new_user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact' => $request->contact,
            'candidate_id' => $candidate->id,
            'password' => Hash::make($request->password),

        ]);

        $current_job = CandidateExperience::create([
            'job_title' => $request->current_job_title,
            'job_tenure' => $request->current_job_tenure,
            'company_name' => $request->current_company_name,
            'responsibility' => $request->current_responsibility,
            'achievement' => $request->current_achievement,
            'skills_developed' => $request->current_skills_developed,
            'candidate_id' => $candidate->id,
            'present_job' => 1,
        ]);
        $previous_job = CandidateExperience::create([
            'job_title' => $request->previous_job_title,
            'job_tenure' => $request->previous_job_tenure,
            'company_name' => $request->previous_company_name,
            'responsibility' => $request->previous_responsibility,
            'achievement' => $request->previous_achievement,
            'skills_developed' => $request->previous_skills_developed,
            'candidate_id' => $candidate->id,
            'present_job' => 0,
        ]);

        if ($request->hasFile('image')) {
            // $destinationPath = 'assets/admin/uploads/images';

            $slug =  Str::slug($candidate->first_name . $candidate->last_name) . "-";
            $myimage = $slug . time() . '.' . $request->image->getClientOriginalExtension();
            $path = 'assets/uploads/image/';
            $request->file('image')->move($path, $myimage);
            $image = new Image([
                'name' => $myimage,
                'path' => $path
            ]);
            $candidate->images()->save($image);
            // $user->images()->save($image);
        }
        if ($request->hasFile('cv')) {
            // $destinationPath = 'assets/admin/uploads/images';

            $slug =  Str::slug($candidate->first_name . $candidate->last_name) . "-";
            $myimage = $slug . time() . '.' . $request->cv->getClientOriginalExtension();
            $path = 'assets/uploads/resume/';
            $request->file('cv')->move($path, $myimage);
            $pdf = new PdfFile([
                'name' => $myimage,
                'path' => $path
            ]);
            $pdf->pdffilable_id = $candidate->id;
            $pdf->pdffilable_type = get_class($candidate);
            $pdf->save();
            // $candidate->pdffile()->save($pdf);
            // $user->images()->save($image);
        }
        foreach ($request->hard_skill as $skill_id) {
            $skill = Skill::find($skill_id);
            if ($skill) {
                $skillIds[] = $skill->id;
            }
        }
        $candidate->skills()->sync($skillIds);
        foreach ($request->skill_detail as $skill_cat_id) {
            $skill = SkillCategory::find($skill_cat_id);
            if ($skill) {
                $skill_cat[] = $skill->id;
            }
        }
        $candidate->skill_category()->sync($skill_cat);


        $create_user = User::find($request->id);
        $create_user->notify(new CandidateRegistered($candidate));
        if (Auth::check()) {
            return redirect()->route('candidates');
        }


        return redirect()->route('login');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $id1 = base64_decode($id);

        $candidate = Candidate::with('images', 'pdffile','summary')->findOrFail($id1);

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
        if ($this->user->hasRole('HIMSubUser')) {
            $job_list1 = Job::where('status', 1)->where('cim_candidate', 1)->with('questions', 'client')->orderBy('created_at', 'desc')->get();
            $applied = $candidate->jobs()->get();
            $screening_date = $candidate->interview_date()->where('stage_id', null)->where('job_id', null)->where('status',0)->where('is_cancelled',0)->first();
            $screening_option = $candidate->interview_option;
            $client_list = EmployeeDetail::with('active_jobs')->get();
            $job_list = $client_list->pluck('active_jobs', 'id')->unique()->toArray();
            // dd($job_list,$job_list1);
            return view('pages.admin_user.candidates.detail', compact('candidate', 'hard_skill', 'skill_category',
            'client_list', 'current_job', 'previous_job', 'pdfPath', 'job_list', 'applied', 'screening_date', 'screening_option'));
        }


        return view('pages.candidates.detail', compact('candidate', 'hard_skill', 'skill_category', 'current_job', 'previous_job', 'pdfPath'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        //
    }
    public function candidate_summary_update(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'summary'=>'required',
            'category'=>'required',
        ]);
        $id = base64_decode($request->id);
        $candidate = Candidate::findOrFail($id);
        $interview =$candidate->interview_date()->where('job_id',null)->first();
        $summary = Summary::create(
            [
                'description'=>$request->summary,
                'category'=>$request->category,
                'candidate_id'=>$candidate->id,
                'created_by'=>$this->user->id
            ]
            );
        $candidate->update([
            'category'=>$request->category,
            'is_screened'=>1,
        ]);
        $interview->update([
            'status'=>1
        ]);
        return redirect()->route('candidates-view',base64_encode($id))->with('success','Candidate Summary Updated SuccessFully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $id = base64_decode($request->id);
        $candidate = Candidate::find($id);

        if ($candidate->delete()) {
            return response()->json(['status' => 1, 'Message' => 'Candidate, candidate user and images are deleted']);
        } else {
            return response()->json(['status' => 0, 'Message' => 'Unabale to Delete due to unseen Error']);
        }
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
        $job_id=$request->job_id;
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
                    $candidate->jobs()->attach($job_id, ['stage_id' => 0, 'created_by' => Auth::id(),'summary'=>$request->summary]);
                }else{
                    $candidate->jobs()->detach($job_id, ['stage_id' => 0, 'created_by' => Auth::id()]);
                    $candidate->jobs()->attach($job_id, ['stage_id' => 0, 'created_by' => Auth::id(),'summary'=>$request->summary]);
                }
            }
        
        // $candidate->jobs()->sync($tagIds);
        return redirect()->back()->with('success', 'Candidate has been refer for the Job');
    }
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
            dd($url);
            Mail::to($value['email'])->send(new SampleMail($url, $value));
        }
        dd($url);
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
        $create_user->notify(new InterviewConfirm($interview_date->candidate));
        dd('ok');
    }

   

    public function create_interview(Request $request)
    {
        // dd($request->all());
        $candidate_id = base64_decode($request->candidate_id);
        $candidate = Candidate::findOrFail($candidate_id);
        $jsonString = json_encode($request->interview);
        $decodedArray = json_decode($jsonString, true);
        foreach ($decodedArray as $key => $value) {
            // dd(Carbon::parse($value['time'])->format('H:i:s'));
            $interview_option = InterviewOption::create([
                'created_by' => Auth::id(),
                'interview_date' => Carbon::parse($value['date']),
                'interview_time' => Carbon::parse($value['time']),
                'candidate_id' => $candidate_id

            ]);
        }
        $url = URL::signedRoute('interview_option_candidate', ['user_id' => base64_encode(Auth::id()), 'candidate_id' => base64_encode($candidate_id)], absolute: true);
        Mail::to($candidate->email)->send(new InterviewSelection($url, $candidate));
        dd($request->all());
    }

    public function cancel_interview(Request $request){
        $id = base64_decode($request->id);
        $interview_date = InterviewDate::findOrFail($id);
        // dd($interview_date);
        $interview_date->update([
            'is_cancelled'=>1
        ]);
        return response()->json(['status' => 1, 'Message' => 'Interview hs been cancelled']);
    }
}
