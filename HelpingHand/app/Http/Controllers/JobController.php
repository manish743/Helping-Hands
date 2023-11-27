<?php

namespace App\Http\Controllers;

use App\Mail\SampleMail;
use App\Models\EmployeeDetail;
use App\Policies\JobPolicy;
use App\Models\Job;
use App\Models\JobStageWeight;
use App\Models\Question;
use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Mockery\Matcher\Type;

use function PHPSTORM_META\type;

class JobController extends Controller
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
            $job_list = Job::with('questions', 'client')->orderBy('created_at', 'desc')->get();
        } else {
            $job_list = Job::where('org_id', $user->org_id)->with('questions', 'client')->orderBy('created_at', 'desc')->get();
        }


        // $job_list->each(function ($job) {
        //     $stages = $job->questions->pluck('pivot.stage_id')->unique()->values()->toArray();
        //     $job->update(['stages'=>$stages]) ;
        // });
        // dd($job_list);

        return view('pages.jobs.index', compact('job_list'));
    }
    public function validate_step($step,Request $request){
        // 
        if ($step==0) {
            $validator = Validator::make($request->all(), [
                // 'org_id' => 'required',
                'project_number' => 'required',
                'vacant_position' => 'required',
                'job_type' => 'required',
                'type_of_position' => 'required',
                'department_id' => 'required',
                'project_owner' => 'required',
                'hr_incharge' => 'required',
                // 'departmengt' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            return response()->json(['status'=>1,'Message'=>'Validation Passed']);
        }
        if ($step==1) {
            // dd($request->all());
            $validator = Validator::make($request->all(), [
                // 'org_id' => 'required',
                'JD.question.*.question' => 'required',
                'ORG.question.*.question' => 'required',
                'hard.*.question.*.question' =>'required',
                  
                
                            
            ]);

            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            // dd($request->all());
            return response()->json(['status'=>1,'Message'=>'Validation Passed']);
        }
    }
    public function create()
    {
        // $this->authorize('create', Job::class);
        $response = Gate::inspect('create', Job::class);
        // Mail::to('samir.maharjan349@gmail.com')->send(new SampleMail());
        if ($response->allowed()) {
            $hard = Skill::where('competency', 'Hard Skill')->get();
            $soft = Skill::where('competency', 'Soft Skill')->get();
            $team = Skill::where('competency', 'Team Fit')->get();
            $client_list = EmployeeDetail::with('departments')->get();
            $client= $this->user->client;
            $department_list= $client->departments;
            // dd($department_list);
            return view('pages.jobs.create', compact('hard', 'soft', 'team', 'client_list','department_list'));
        } else {
            return redirect()->back()->with('warning', $response->message());
        }
    }
    public function store(Request $request)
    {
        $stage_status = json_encode($request->stage_status);
        // dd($stage_status);
        $user = $this->user;
        // dd($user->id);
        $response = Gate::inspect('create', Job::class);
        if ($response->allowed()) {
            $validator = Validator::make($request->all(), [
                // 'org_id' => 'required',
                'project_number' => 'required',
                'vacant_position' => 'required',
                'job_type' => 'required',
                'type_of_position' => 'required',
                'department' => 'required',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            if ($user->hasRole('SuperAdmin')) {
                $request->validate(['org_id' => 'required']);
                $org_id = $request->org_id;
                $create_id = 1;
                // dd($create_id);
            } else {
                $org_id = $user->org_id;
                $create_id = $user->org_id;
            }

            $job = Job::create([
                'org_id' =>  $org_id,
                'project_number' => $request->project_number,
                'vacant_position' => $request->vacant_position,
                'job_type' => $request->job_type,
                'type_of_position' => $request->type_of_position,
                'department' => $request->department,
                'stages'=>$stage_status,
                'cim_candidate' => isset($request->cim_candidate) ? 1 : 0,
            ]);

            $jsonString = json_encode($request->stage, JSON_PRETTY_PRINT);
            $decodedArray = json_decode($jsonString, true);
            if ($decodedArray) {
                foreach ($decodedArray as $stage => $value1) {
                    // dd( $stage,$value1['hard_weight'],$value1['soft_weight'],$value1['soft_weight']);
                    // dd($stage);
                    if ($stage == 1) {
                        if (isset($value1['JD_weight'])) {
                            //   dd($value1['JD']);
                            $job_weight = JobStageWeight::create([
                                'job_id' => $job->id,
                                'stage_id' => $stage,
                                'competency' => 'JD',
                                'competency_weight' => $value1['JD_weight'],
                                'stage_weight' => $value1['weight'],
                            ]);
                            foreach ($value1['JD'] as $value2) {

                                $type = "JD";
                                // dd($type);
                                // dd($value2);

                                foreach ($value2 as $question) {
                                    //dump($question['question']);


                                    if ($question['question'] !== "") {
                                        $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                        if (!$job_question) {
                                            $question['created_by'] = $create_id;
                                            $question['competency'] = $type;
                                            $job_question = Question::firstOrCreate($question);
                                        }
                                        $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                    }
                                }
                            }
                        }
                        if (isset($value1['HR_weight'])) {
                            $job_weight = JobStageWeight::create([
                                'job_id' => $job->id,
                                'stage_id' => $stage,
                                'competency' => 'HR',
                                'competency_weight' => $value1['HR_weight'],
                                'stage_weight' => $value1['weight'],
                            ]);
                            foreach ($value1['HR'] as $value2) {

                                $type = "HR";
                                // dd($type);
                                // dd($value2);

                                foreach ($value2 as $question) {
                                    //dump($question['question']);


                                    if ($question['question'] !== "") {
                                        $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                        if (!$job_question) {
                                            $question['created_by'] = $create_id;
                                            $question['competency'] = $type;
                                            $job_question = Question::firstOrCreate($question);
                                        }
                                        $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                    }
                                }
                            }
                        }
                        if (isset($value1['ORG_weight'])) {
                            $job_weight = JobStageWeight::create([
                                'job_id' => $job->id,
                                'stage_id' => $stage,
                                'competency' => 'ORG',
                                'competency_weight' => $value1['ORG_weight'],
                                'stage_weight' => $value1['weight'],
                            ]);
                            foreach ($value1['ORG'] as $value2) {

                                $type = "ORG";
                                // dd($type);
                                // dd($value2);

                                foreach ($value2 as $question) {
                                    //dump($question['question']);


                                    if ($question['question'] !== "") {
                                        $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                        if (!$job_question) {
                                            $question['created_by'] = $create_id;
                                            $question['competency'] = $type;
                                            $job_question = Question::firstOrCreate($question);
                                        }
                                        $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                    }
                                }
                            }
                        }
                        if (isset($value1['hard_weight'])) {
                            $job_weight = JobStageWeight::create([
                                'job_id' => $job->id,
                                'stage_id' => $stage,
                                'competency' => 'Hard Skill',
                                'competency_weight' => $value1['hard_weight'],
                                'stage_weight' => $value1['weight'],
                            ]);
                            foreach ($value1['hard'] as $value2) {

                                $type = "Hard Skill";
                                // dd($type);
                                // dd($value2);

                                foreach ($value2 as $question) {
                                    //dump($question['question']);


                                    if ($question['question'] !== "") {
                                        $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                        if (!$job_question) {
                                            $question['created_by'] = $create_id;
                                            $question['competency'] = $type;
                                            $job_question = Question::firstOrCreate($question);
                                        }
                                        $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                    }
                                }
                            }
                        }
                        if (isset($value1['soft_weight'])) {
                            $job_weight = JobStageWeight::create([
                                'job_id' => $job->id,
                                'stage_id' => $stage,
                                'competency' => 'Soft Skill',
                                'competency_weight' => $value1['soft_weight'],
                                'stage_weight' => $value1['weight'],
                            ]);
                            foreach ($value1['soft'] as $value2) {

                                $type = "Soft Skill";
                                // dd($type);
                                // dd($value2);

                                foreach ($value2 as $question) {
                                    //dump($question['question']);


                                    if ($question['question'] !== "") {
                                        $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                        if (!$job_question) {
                                            $question['created_by'] = $create_id;
                                            $question['competency'] = $type;
                                            $job_question = Question::firstOrCreate($question);
                                        }
                                        $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                    }
                                }
                            }
                        }
                        if (isset($value1['team_weight'])) {
                            $job_weight = JobStageWeight::create([
                                'job_id' => $job->id,
                                'stage_id' => $stage,
                                'competency' => 'Team Fit',
                                'competency_weight' => $value1['team_weight'],
                                'stage_weight' => $value1['weight'],
                            ]);
                            foreach ($value1['team'] as $value2) {

                                $type = "Team Fit";
                                // dd($type);
                                // dd($value2);

                                foreach ($value2 as $question) {
                                    //dump($question['question']);


                                    if ($question['question'] !== "") {
                                        $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                        if (!$job_question) {
                                            $question['created_by'] = $create_id;
                                            $question['competency'] = $type;
                                            $job_question = Question::firstOrCreate($question);
                                        }
                                        $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                    }
                                }
                            }
                        }
                    }
                    if ($stage == 2 || $stage == 3) {
                        if (isset($value1['hard_weight'])) {
                            $job_weight = JobStageWeight::create([
                                'job_id' => $job->id,
                                'stage_id' => $stage,
                                'competency' => 'Hard Skill',
                                'competency_weight' => $value1['hard_weight'],
                                'stage_weight' => $value1['weight'],
                            ]);
                            foreach ($value1['hard'] as $competency => $value2) {


                                $type = "Hard Skill";
                                // dd($type);
                                // dd($value2['skill']);

                                foreach ($value2['question'] as $skill => $question) {
                                    //  //dump($question['question']);

                                    // $question['created_by'] = $org_id;
                                    if ($question['question'] !== "") {
                                        $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                        if (!$job_question) {
                                            $question['created_by'] = $create_id;
                                            $question['competency'] = $type;
                                            $job_question = Question::firstOrCreate($question);
                                        }
                                        $job_question->job()->attach($job->id, ['skill_id' => $value2['skill'], 'stage_id' => $stage, 'competency' => $type]);
                                        $job_question->skills()->sync($value2['skill']);
                                    }
                                }
                            }
                        }
                        if (isset($value1['soft_weight'])) {
                            $job_weight = JobStageWeight::create([
                                'job_id' => $job->id,
                                'stage_id' => $stage,
                                'competency' => 'Soft Skill',
                                'competency_weight' => $value1['soft_weight'],
                                'stage_weight' => $value1['weight'],
                            ]);
                            foreach ($value1['soft'] as $competency => $value2) {


                                $type = "Soft Skill";
                                // dd($type);
                                // dd($value2['skill']);

                                foreach ($value2['question'] as $skill => $question) {
                                    //  //dump($question['question']);


                                    if ($question['question'] !== "") {
                                        $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                        if (!$job_question) {
                                            $question['created_by'] = $create_id;
                                            $question['competency'] = $type;
                                            $job_question = Question::firstOrCreate($question);
                                        }
                                        $job_question->job()->attach($job->id, ['skill_id' => $value2['skill'], 'stage_id' => $stage, 'competency' => $type]);
                                        $job_question->skills()->sync($value2['skill']);
                                    }
                                }
                            }
                        }
                        if (isset($value1['team_weight'])) {
                            $job_weight = JobStageWeight::create([
                                'job_id' => $job->id,
                                'stage_id' => $stage,
                                'competency' => 'Team Fit',
                                'competency_weight' => $value1['team_weight'],
                                'stage_weight' => $value1['weight'],
                            ]);
                            foreach ($value1['team'] as $competency => $value2) {


                                $type = "Team Fit";
                                // dd($type);
                                // dd($value2['skill']);

                                foreach ($value2['question'] as $skill => $question) {
                                    //  //dump($question['question']);


                                    if ($question['question'] !== "") {
                                        $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                        if (!$job_question) {
                                            $question['created_by'] = $create_id;
                                            $question['competency'] = $type;
                                            $job_question = Question::firstOrCreate($question);
                                        }
                                        $job_question->job()->attach($job->id, ['skill_id' => $value2['skill'], 'stage_id' => $stage, 'competency' => $type]);
                                        $job_question->skills()->sync($value2['skill']);
                                    }
                                }
                            }
                        }
                    }

                    if ($stage == 4 || $stage == 5) {
                        if (isset($value1['weight'])) {
                            $job_weight = JobStageWeight::create([
                                'job_id' => $job->id,
                                'stage_id' => $stage,
                                'competency' => 'others',
                                'competency_weight' => 100,
                                'stage_weight' => $value1['weight'],
                            ]);
                            foreach ($value1['question'] as $question) {

                                $type = "others";
                                // dd($type);
                                // dd($value2);


                                //  //dump($question['question']);
                                //  

                                if ($question['question'] !== "") {
                                    $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                    if (!$job_question) {
                                        $question['created_by'] = $create_id;
                                        $question['competency'] = $type;
                                        $job_question = Question::firstOrCreate($question);
                                    }
                                    $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                }
                            }
                        }
                    }
                }
            }

            return redirect()->route('jobs')->with('success', 'Job created SuccessFully');
        } else {
            return redirect()->back()->with('warning', $response->message());
        }
    }
    public function edit($id)
    {
        $id = base64_decode($id);
        $job = Job::find($id);
        // dd($job);
        $job_stage_weight = $job->job_stage_weight()->select('stage_id', 'competency', 'competency_weight', 'stage_weight')->get()->groupBy('stage_id');
        // dd($job_stage_weight[1]->pluck('competency_weight','competency'));
        // dd($job_stage_weight[1]->pluck('stage_weight','stage_id')->unique());
        // Gate::authorize('update', $job);
        $this->authorize('update', $job);
        $stages = $job->questions->pluck('pivot.stage_id')->unique()->values()->toArray();
        $skill = $job->questions()->select('job_question.skill_id', 'job_question.stage_id', 'job_question.competency')->get()->groupBy('stage_id')->toArray();
        foreach ($skill as $stageId => $stageSkills) {
            $stageSkills = collect($stageSkills)->groupBy('competency')->unique()->toArray();
        }
        $stages_question = $job->questions()->select('questions.question', 'job_question.stage_id', 'job_question.skill_id', 'job_question.competency')
            ->wherePivotIn('job_question.stage_id', $stages)
            ->get()
            ->groupBy('pivot.stage_id');
        // dd($job->job_stage_weight()->select('stage_weight','competency_weight','competency','job_stage_weight.stage_id')->get()->groupBy('stage_id')->toArray());
        // dd($stages_question,$skill);
        // dd($stages_question[1]->where('competency', 'JD')->groupBy('competency'));
        // dd($stages);
        $hard = Skill::where('competency', 'Hard Skill')->get();
        $soft = Skill::where('competency', 'Soft Skill')->get();
        $team = Skill::where('competency', 'Team Fit')->get();
        $client = EmployeeDetail::all();
        return view('pages.jobs.edit2', compact('job', 'hard', 'soft', 'team', 'stages', 'stages_question', 'client', 'job_stage_weight'));
    }
    public function update(Request $request)
    {
        // dd($request->all());
        // $job = Job::find($request->job_id);
        // $job->job_stage_weight()->delete();
        // dd($job->job_stage_weight);
        $user = $this->user;
        $request->validate([
            'job_id' => 'required',
            'project_number' => 'required',
            'vacant_position' => 'required',
            'job_type' => 'required',
            'type_of_position' => 'required',
            'department' => 'required',
        ]);

        $stage_status = json_encode($request->stage_status);
        $job = Job::find($request->job_id);
        $org_id = $job->org_id;
        $job->job_stage_weight()->delete();
        $job->questions()->detach();
        $job->update([
            'project_number' => $request->project_number,
            'vacant_position' => $request->vacant_position,
            'job_type' => $request->job_type,
            'type_of_position' => $request->type_of_position,
            'department' => $request->department,
            'stages'=>$stage_status,
            'cim_candidate' => isset($request->cim_candidate) ? 1 : 0,
        ]);

        if ($user->hasRole('SuperAdmin')) {

            $create_id = 1;
            // dd($create_id);
        } else {

            $create_id = $user->org_id;
        }

        $jsonString = json_encode($request->stage, JSON_PRETTY_PRINT);
        $decodedArray = json_decode($jsonString, true);
        if ($decodedArray) {
            foreach ($decodedArray as $stage => $value1) {
                // dd( $stage,$value1['hard_weight'],$value1['soft_weight'],$value1['soft_weight']);
                // dd($stage);
                if ($stage == 1) {
                    if (isset($value1['JD_weight'])) {
                        $job_weight = JobStageWeight::create([
                            'job_id' => $job->id,
                            'stage_id' => $stage,
                            'competency' => 'JD',
                            'competency_weight' => $value1['JD_weight'],
                            'stage_weight' => $value1['weight'],
                        ]);
                        foreach ($value1['JD'] as $value2) {

                            $type = "JD";
                            // dd($type);
                            // dd($value2);

                            foreach ($value2 as $question) {
                                if ($question['question'] !== "") {
                                    $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                    if (!$job_question) {
                                        $question['created_by'] = $create_id;
                                        $question['competency'] = $type;
                                        $job_question = Question::firstOrCreate($question);
                                    }
                                    $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                }
                            }
                        }
                    }
                    if (isset($value1['HR_weight'])) {
                        $job_weight = JobStageWeight::create([
                            'job_id' => $job->id,
                            'stage_id' => $stage,
                            'competency' => 'HR',
                            'competency_weight' => $value1['HR_weight'],
                            'stage_weight' => $value1['weight'],
                        ]);
                        foreach ($value1['HR'] as $value2) {

                            $type = "HR";
                            // dd($type);
                            // dd($value2);

                            foreach ($value2 as $question) {
                                //dump($question['question']);


                                if ($question['question'] !== "") {
                                    $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                    if (!$job_question) {
                                        $question['created_by'] = $create_id;
                                        $question['competency'] = $type;
                                        $job_question = Question::firstOrCreate($question);
                                    }
                                    $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                }
                            }
                        }
                    }
                    if (isset($value1['ORG_weight'])) {
                        $job_weight = JobStageWeight::create([
                            'job_id' => $job->id,
                            'stage_id' => $stage,
                            'competency' => 'ORG',
                            'competency_weight' => $value1['ORG_weight'],
                            'stage_weight' => $value1['weight'],
                        ]);
                        foreach ($value1['ORG'] as $value2) {

                            $type = "ORG";
                            // dd($type);
                            // dd($value2);

                            foreach ($value2 as $question) {
                                //dump($question['question']);


                                if ($question['question'] !== "") {
                                    $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                    if (!$job_question) {
                                        $question['created_by'] = $create_id;
                                        $question['competency'] = $type;
                                        $job_question = Question::firstOrCreate($question);
                                    }
                                    $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                }
                            }
                        }
                    }
                    if (isset($value1['hard_weight'])) {
                        $job_weight = JobStageWeight::create([
                            'job_id' => $job->id,
                            'stage_id' => $stage,
                            'competency' => 'Hard Skill',
                            'competency_weight' => $value1['hard_weight'],
                            'stage_weight' => $value1['weight'],
                        ]);
                        foreach ($value1['hard'] as $value2) {

                            $type = "Hard Skill";
                            // dd($type);
                            // dd($value2);

                            foreach ($value2 as $question) {
                                //dump($question['question']);


                                if ($question !== "") {
                                    $job_question = Question::where('created_by', 1)->where('question', $question)->first();
                                    if (!$job_question) {
                                        $question['created_by'] = $create_id;
                                        $question['competency'] = $type;
                                        $job_question = Question::firstOrCreate($question);
                                    }
                                    $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                }
                            }
                        }
                    }
                    if (isset($value1['soft_weight'])) {
                        $job_weight = JobStageWeight::create([
                            'job_id' => $job->id,
                            'stage_id' => $stage,
                            'competency' => 'Soft Skill',
                            'competency_weight' => $value1['soft_weight'],
                            'stage_weight' => $value1['weight'],
                        ]);
                        foreach ($value1['soft'] as $value2) {

                            $type = "Soft Skill";
                            // dd($type);
                            // dd($value2);

                            foreach ($value2 as $question) {
                                //dump($question['question']);


                                if ($question !== "") {
                                    $job_question = Question::where('created_by', 1)->where('question', $question)->first();
                                    if (!$job_question) {
                                        $question['created_by'] = $create_id;
                                        $question['competency'] = $type;
                                        $job_question = Question::firstOrCreate($question);
                                    }
                                    $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                }
                            }
                        }
                    }
                    if (isset($value1['team_weight'])) {
                        $job_weight = JobStageWeight::create([
                            'job_id' => $job->id,
                            'stage_id' => $stage,
                            'competency' => 'Team Fit',
                            'competency_weight' => $value1['team_weight'],
                            'stage_weight' => $value1['weight'],
                        ]);
                        foreach ($value1['team'] as $value2) {

                            $type = "Team Fit";
                            // dd($type);
                            // dd($value2);

                            foreach ($value2 as $question) {
                                //dump($question['question']);


                                if ($question !== "") {
                                    $job_question = Question::where('created_by', 1)->where('question', $question)->first();
                                    if (!$job_question) {
                                        $question['created_by'] = $create_id;
                                        $question['competency'] = $type;
                                        $job_question = Question::firstOrCreate($question);
                                    }
                                    $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                                }
                            }
                        }
                    }
                }
                if ($stage == 2 || $stage == 3) {
                    if (isset($value1['hard_weight'])) {
                        $job_weight = JobStageWeight::create([
                            'job_id' => $job->id,
                            'stage_id' => $stage,
                            'competency' => 'Hard Skill',
                            'competency_weight' => $value1['hard_weight'],
                            'stage_weight' => $value1['weight'],
                        ]);
                        foreach ($value1['hard'] as $competency => $value2) {


                            $type = "Hard Skill";
                            // dd($type);
                            // dd($value2['skill']);

                            foreach ($value2['question'] as $skill => $question) {
                                //  //dump($question['question']);

                                // $question['created_by'] = $org_id;
                                if ($question['question'] !== "") {
                                    $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                    if (!$job_question) {
                                        $question['created_by'] = $create_id;
                                        $question['competency'] = $type;
                                        $job_question = Question::firstOrCreate($question);
                                    }
                                    $job_question->job()->attach($job->id, ['skill_id' => $value2['skill'], 'stage_id' => $stage, 'competency' => $type]);
                                    $job_question->skills()->sync($value2['skill']);
                                }
                            }
                        }
                    }
                    if (isset($value1['soft_weight'])) {
                        $job_weight = JobStageWeight::create([
                            'job_id' => $job->id,
                            'stage_id' => $stage,
                            'competency' => 'Soft Skill',
                            'competency_weight' => $value1['soft_weight'],
                            'stage_weight' => $value1['weight'],
                        ]);
                        foreach ($value1['soft'] as $competency => $value2) {


                            $type = "Soft Skill";
                            // dd($type);
                            // dd($value2['skill']);

                            foreach ($value2['question'] as $skill => $question) {
                                //  //dump($question['question']);


                                if ($question['question'] !== "") {
                                    $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                    if (!$job_question) {
                                        $question['created_by'] = $create_id;
                                        $question['competency'] = $type;
                                        $job_question = Question::firstOrCreate($question);
                                    }
                                    $job_question->job()->attach($job->id, ['skill_id' => $value2['skill'], 'stage_id' => $stage, 'competency' => $type]);
                                    $job_question->skills()->sync($value2['skill']);
                                }
                            }
                        }
                    }
                    if (isset($value1['team_weight'])) {
                        $job_weight = JobStageWeight::create([
                            'job_id' => $job->id,
                            'stage_id' => $stage,
                            'competency' => 'Team Fit',
                            'competency_weight' => $value1['team_weight'],
                            'stage_weight' => $value1['weight'],
                        ]);
                        foreach ($value1['team'] as $competency => $value2) {


                            $type = "Team Fit";
                            // dd($type);
                            // dd($value2['skill']);

                            foreach ($value2['question'] as $skill => $question) {
                                //  //dump($question['question']);


                                if ($question['question'] !== "") {
                                    $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                    if (!$job_question) {
                                        $question['created_by'] = $create_id;
                                        $question['competency'] = $type;
                                        $job_question = Question::firstOrCreate($question);
                                    }
                                    $job_question->job()->attach($job->id, ['skill_id' => $value2['skill'], 'stage_id' => $stage, 'competency' => $type]);
                                    $job_question->skills()->sync($value2['skill']);
                                }
                            }
                        }
                    }
                }

                if ($stage == 4 || $stage == 5) {
                    if (isset($value1['weight'])) {
                        $job_weight = JobStageWeight::create([
                            'job_id' => $job->id,
                            'stage_id' => $stage,
                            'competency' => 'others',
                            'competency_weight' => 100,
                            'stage_weight' => $value1['weight'],
                        ]);
                        foreach ($value1['question'] as $question) {

                            $type = "others";
                            // dd($type);
                            // dd($value2);


                            //  //dump($question['question']);
                            //  

                            if ($question['question'] !== "") {
                                $job_question = Question::where('created_by', 1)->where('question', $question['question'])->first();
                                if (!$job_question) {
                                    $question['created_by'] = $create_id;
                                    $question['competency'] = $type;
                                    $job_question = Question::firstOrCreate($question);
                                }
                                $job_question->job()->attach($job->id, ['stage_id' => $stage, 'competency' => $type]);
                            }
                        }
                    }
                }
            }
        }
        // dd($job, $job->questions);
        return redirect()->route('jobs')->with('success', 'Job updated SuccessFully');

        //
    }
    public function delete(Request $request)
    {
        $request->validate(['id' => 'required']);
        $job = Job::find($request->id);

        if ($job->delete()) {
            return response()->json(['status' => 1, 'Message' => 'Job has been deleted successfully']);
        } else {
            return response()->json(['status' => 0, 'Message' => 'Unabale to Delete due to unseen Error']);
        }
    }
    public function applicants($id)
    {

        $id = base64_decode($id);
        $job = Job::findOrFail($id);
        $applicants = $job->candidates;
        return view('pages.jobs.applicant_list', compact('applicants'));
    }
    public function complete(Request $request)
    {
        $request->validate(['id' => 'required']);
        $job = Job::find($request->id);
        // dd('ok');
        $job->update([
            'status' => 0,
        ]);
        return response()->json(['status' => 1, 'Message' => 'Job has been completed']);
    }
    public function question_suggest(Request $request)
    {
        // dd($request->all());
        if (isset($request->id)) {
            $input = $request->input('input');
            $id = $request->input('id');
            $skill = Skill::find($id);
            $question = $skill->questions()->where('question', 'like', '%' . $input . '%')
                ->whereIn('created_by', [1, Auth::user()->org_id])
                ->get();
        } elseif (isset($request->type)) {
            $input = $request->input('input');
            $type = $request->input('type');

            $question = Question::where('question', 'like', '%' . $input . '%')
                ->where('competency', $type)
                ->whereIn('created_by', [1, Auth::user()->org_id])
                ->get();
        }

        // dd($question);
        if (count($question) > 0) {
            return response()->json(['status' => 1, 'result' => $question]);
        } else {
            return response()->json(['status' => 0, 'result' => $request->input('input')]);
        }
    }
}
