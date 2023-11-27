<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\SkillType;
use App\Rules\InArrayValues;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::with('skill_category')->get();
        return view('pages.skills.index', compact('skills'));
    }
    public function create()
    {
        $skill_type = SkillType::all();
        return view('pages.skills.create', compact('skill_type'));
    }
    public function store(Request $request)
    {
        // dd($request->all());
        $allowedValues = ['Hard Skill', 'Soft Skill', 'Team Fit'];
        $request->validate([
            'name' => 'required|unique:skills,name',
            'skill_category' => 'required',
            'competency' => ['required', Rule::in($allowedValues)]
        ]);
        // dd($request->all());
        $inputArray = explode(',', $request->skill_category);
        $trimmedArray = array_map('trim', $inputArray);
        $uniqueTags = [];
        foreach ($trimmedArray as $tagName) {
            if (!empty($tagName) && !in_array($tagName, $uniqueTags)) {
                $uniqueTags[] = $tagName;
            }
        }
        // $string = implode(', ', $trimmedArray);
        foreach ($uniqueTags as $tagName) {
            $tag = SkillCategory::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        $org_type = Skill::firstorCreate([
            'name' => $request->name,
            'competency' => $request->competency,
        ]);
        $org_type->skill_category()->sync($tagIds);

        return redirect()->route('skills')->with('success', 'Skills Created SuccessFully');
    }
    public function edit($id)
    {
        $skill = Skill::find($id);
        return view('pages.skills.edit', compact('skill'));
    }

    public function update(Request $request)
    {
        $allowedValues = ['Hard Skill', 'Soft Skill', 'Team Fit'];
        $request->validate([
            'id' => 'required',
            'name' => 'required|unique:skills,name,' . $request->id,
            'competency' => ['required', Rule::in($allowedValues)]
        ]);
        // dd($request->all());
        $inputArray = explode(',', $request->skill_category);
        $trimmedArray = array_map('trim', $inputArray);
        $uniqueTags = [];
        foreach ($trimmedArray as $tagName) {
            if (!empty($tagName) && !in_array($tagName, $uniqueTags)) {
                $uniqueTags[] = $tagName;
            }
        }
        // $string = implode(', ', $trimmedArray);
        foreach ($uniqueTags as $tagName) {
            $tag = SkillCategory::firstOrCreate(['name' => $tagName]);
            $tagIds[] = $tag->id;
        }

        $skill = Skill::find($request->id);
        $skill->update([
            'name' => $request->name,
            'competency' => $request->competency,
        ]);
        $skill->skill_category()->sync($tagIds);
        return redirect()->route('skills')->with('success', 'Skills Updated SuccessFully');
    }


    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $skill = Skill::find($request->id);
        // dd(count($skill->job_questions));
        if (count($skill->job_questions) > 0) {
            // dd('ok');
            return response()->json(['status' => 0, 'message' => 'Unabale to Delete. Skill is active for many Jobs']);
        } else {

            if ($skill->delete()) {
                return response()->json(['status' => 1, 'message' => 'Skill Deleted Succcessfully']);
            } else {
                return response()->json(['status' => 0, 'message' => 'Unable to Delete Due to Unseen Errors']);
            }
        }
    }
    public function skill_category_suggest(Request $request)
    {
        // dd($request->all());
        $input = $request->input('input');
        $tags = SkillCategory::where('name', 'like', '%' . $input . '%')->get();
        if (count($tags) > 0) {
            return response()->json(['status' => 1, 'result' => $tags]);
        } else {
            return response()->json(['status' => 0, 'result' => $request->input('input')]);
        }
    }
}
