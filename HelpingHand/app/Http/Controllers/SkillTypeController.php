<?php

namespace App\Http\Controllers;

use App\Models\SkillType;
use Illuminate\Http\Request;

class SkillTypeController extends Controller
{
    public function index(){
        $skill_type = SkillType::with('skills')->get();
        return view('pages.skills_type.index',compact('skill_type'));
        
    }
    public function create(){
        return view('pages.skills_type.create');

    }
    public function store(Request $request){
        // dd($request->all());
        $request->validate([
            'name'=>'required|unique:skill_type,name'
        ]);
        $skill_type = SkillType::create([
            'name'=>$request->name,
        ]);
         return redirect()->route('skill_type')->with('success', 'Skill Type Created Successfully');

    }
    public function edit($id){
        $skill_type = SkillType::find($id);
        return view('pages.skills_type.edit',compact('skill_type'));

    }

    public function update(Request $request){
        dd($request->all());
        $request->validate([
            'name'=>'required|unique:skill_type,name'
        ]);
        $skill_type = SkillType::find($request->id);
        $skill_type->update([
            'name'=>$request->name
        ]);
         return redirect()->route('skill_type')->with('success', 'Skill Type Updated Successfully');
    }

    public function delete(Request $request){
        dd($request->all());
        $request->validate([
            'id'=>'required'
        ]);
        $skill_type = SkillType::find($request->id);

    }

}
