<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DepartmentController extends Controller
{
    protected $user;
    protected $user3;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();

            return $next($request);
        });
    }

    public function index(){
        $user = $this->user;
        $department_list = Department::where('org_id',$user->org_id)->get();
        return view('pages.department.index',compact('department_list'));
    }

    public function create(){
        return view('pages.department.create');
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),
        [
            'name'=>'required'
        ]);
        if ($validator->fails()){
            // return response()->json(['errors'=>$validator->errors()]);
            return redirect()->back()->withErrors($validator);
        }
        $department = Department::firstOrCreate([
            'org_id'=>$this->user->org_id,
            'name'=>$request->name,
        
        ]);
        return redirect()->route('department')->with('success','Department created successfully');
    }
    public function edit($id)
    {
        $user = $this->user;
        $user_id =$user->org_id;
        $id = base64_decode($id);
        $department = Department::findOrFail($id);
        $validator = Validator::make(['org_id'=>$department->org_id],[
            'org_id' => [
                'required',
                Rule::in([$user_id])]
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('warning','Access Denied');
            }
       
        return view('pages.department.edit', compact('department'));
    }
    public function update(Request $request){
        $user = $this->user;
        $id = base64_encode($user->id);
        $validator = Validator::make($request->all(),
        [
            'name'=>'required',
            'org_id' => [
                'required',
                Rule::in([$id]) // Ensure org_id is equal to the id of the authenticated user
            ],
        ]);
        if ($validator->fails()) {
           return redirect()->back()->withErrors($validator);
        }
    }
}
