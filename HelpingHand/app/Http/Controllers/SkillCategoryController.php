<?php

namespace App\Http\Controllers;

use App\Models\SkillCategory;
use Illuminate\Http\Request;

class SkillCategoryController extends Controller
{
    public function index(){
        $skill_category = SkillCategory::with('skills')->get();
        return view('pages.skill_category.index',compact('skill_category'));
        
    }
    public function create(){
        return view('pages.skill_category.create');

    }
    public function store(Request $request){
        // dd($request->all());
        $request->validate([
            'name'=>'required|unique:skill_category,name'
        ]);
        $skill_category = SkillCategory::create([
            'name'=>$request->name,
        ]);
         return redirect()->route('skill_category')->with('success', 'Skill Category Created Successfully');

    }
    public function edit($id){
        $skill_category = SkillCategory::find($id);
        // dd($skill_category);
        return view('pages.skill_category.edit',compact('skill_category'));

    }

    public function update(Request $request){
       
        $request->validate([
            
            'name' => 'required|unique:skill_category,name,' . $request->id,

        ]);
        // dd($request->all());
        $skill_category = SkillCategory::find($request->id);
        $skill_category->update([
            'name'=>$request->name
        ]);
         return redirect()->route('skill_category')->with('success', 'Skill Type Updated Successfully');
    }

    public function delete(Request $request){
        // dd($request->all());
        $request->validate([
            'id'=>'required'
        ]);
        $skill_category = SkillCategory::find($request->id);
        if ($skill_category->delete()) {
            return response()->json(['status'=>1,'message'=>'Skill category Deleted Successfully']);
        } else {
            return response()->json(['status'=>0,'message'=>'Skill categoryUnable to delete due to unseen errors']);
        }
        
        
    }

}
